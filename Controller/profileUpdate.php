<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
requireLogin();

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$address = trim($_POST["address"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$currentPassword = $_POST["current_password"] ?? "";
$newPassword = $_POST["new_password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

if (!$name || !$email || !$address || !$phone) {
    $_SESSION["profileError"] = "Name, email, address and phone are required.";
    Header("Location: profile.php");
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["profileError"] = "Please enter a valid email.";
    Header("Location: profile.php");
    exit();
}

$userModel = new User();
$user = $userModel->findById($_SESSION["userId"]);
if ($userModel->emailExistsForOtherUser($email, $_SESSION["userId"])) {
    $_SESSION["profileError"] = "This email is already used by another account.";
    Header("Location: profile.php");
    exit();
}

$profilePicture = "";
if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["profile_picture"];
    $allowed = array("jpg", "jpeg", "png");
    $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowed) || $file["size"] > 2 * 1024 * 1024) {
        $_SESSION["profileError"] = "Profile picture must be JPG/PNG and less than 2MB.";
        Header("Location: profile.php");
        exit();
    }
    $profilePicture = "profile_" . $_SESSION["userId"] . "_" . time() . "." . $extension;
    move_uploaded_file($file["tmp_name"], "../uploads/profiles/" . $profilePicture);
}

if ($newPassword || $currentPassword || $confirmPassword) {
    if (!password_verify($currentPassword, $user["password_hash"])) {
        $_SESSION["profileError"] = "Current password is incorrect.";
        Header("Location: profile.php");
        exit();
    }
    if (strlen($newPassword) < 8) {
        $_SESSION["profileError"] = "New password should be at least 8 characters.";
        Header("Location: profile.php");
        exit();
    }
    if ($newPassword !== $confirmPassword) {
        $_SESSION["profileError"] = "New password does not match confirmation.";
        Header("Location: profile.php");
        exit();
    }
    $userModel->updatePassword($_SESSION["userId"], $newPassword);
}

$userModel->updateProfile($_SESSION["userId"], $name, $email, $address, $phone, $profilePicture);
$_SESSION["loggedInUser"] = $name;
setMessage("Profile updated successfully.");
Header("Location: profile.php");
exit();
?>
