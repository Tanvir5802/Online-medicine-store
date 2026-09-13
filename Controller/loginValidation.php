<?php
session_start();
include_once "../Model/User.php";

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$hasEmailError = true;
$hasPasswordError = true;

$_SESSION["emailValue"] = $email;

if (!$email) {
    $_SESSION["emailError"] = "Email is required";
    $hasEmailError = true;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["emailError"] = "Please enter a valid email";
    $hasEmailError = true;
} else {
    unset($_SESSION["emailError"]);
    $hasEmailError = false;
}

if (!$password) {
    $_SESSION["passwordError"] = "Password is required";
    $hasPasswordError = true;
} else {
    unset($_SESSION["passwordError"]);
    $hasPasswordError = false;
}

if ($hasEmailError || $hasPasswordError) {
    Header("Location: login.php");
    exit();
}

$userModel = new User();
$user = $userModel->findByEmail($email);

if (!$user || !password_verify($password, $user["password_hash"])) {
    $_SESSION["loginError"] = "Invalid email or password";
    Header("Location: login.php");
    exit();
}

if ($user["status"] !== "active") {
    $_SESSION["loginError"] = "Your account is inactive. Please contact the administrator.";
    Header("Location: login.php");
    exit();
}

$_SESSION["userId"] = $user["id"];
$_SESSION["loggedInUser"] = $user["name"];
$_SESSION["role"] = $user["role"];
$_SESSION["isLoggedIn"] = true;

if (isset($_POST["remember"])) {
    setcookie("email", $email, time() + 3600 * 24 * 30, "/");
} else {
    setcookie("email", "", time() - 1, "/");
}

Header("Location: dashboard.php");
exit();
?>
