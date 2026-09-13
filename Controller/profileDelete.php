<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
requireLogin();

$password = $_POST["password"] ?? "";
$userModel = new User();
$user = $userModel->findById($_SESSION["userId"]);

if (!$password || !password_verify($password, $user["password_hash"])) {
    $_SESSION["profileError"] = "Enter your correct password to delete the profile.";
    Header("Location: profile.php");
    exit();
}

$userModel->deleteProfile($_SESSION["userId"]);
session_destroy();
Header("Location: login.php");
exit();
?>
