<?php
session_start();
include_once "../Model/User.php";

$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

if (!$email || !$phone || !$password || !$confirmPassword) {
    $_SESSION["resetError"] = "All fields are required.";
    Header("Location: forgotPassword.php");
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["resetError"] = "Please enter a valid email.";
    Header("Location: forgotPassword.php");
    exit();
}
if (strlen($password) < 8) {
    $_SESSION["resetError"] = "Password should be at least 8 characters.";
    Header("Location: forgotPassword.php");
    exit();
}
if ($password !== $confirmPassword) {
    $_SESSION["resetError"] = "Password does not match.";
    Header("Location: forgotPassword.php");
    exit();
}

$userModel = new User();
$user = $userModel->findByEmailAndPhone($email, $phone);
if (!$user) {
    $_SESSION["resetError"] = "Email and phone do not match any account.";
    Header("Location: forgotPassword.php");
    exit();
}

$userModel->updatePassword($user["id"], $password);
$_SESSION["resetSuccess"] = "Password reset successful. You can login now.";
Header("Location: forgotPassword.php");
exit();
?>
