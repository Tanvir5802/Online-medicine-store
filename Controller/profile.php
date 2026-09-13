<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
requireLogin();

$userModel = new User();
$user = $userModel->findById($_SESSION["userId"]);
$profileError = $_SESSION["profileError"] ?? "";
unset($_SESSION["profileError"]);

include "../View/header.php";
include "../View/profile.php";
include "../View/footer.php";
?>
