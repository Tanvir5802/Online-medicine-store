<?php
session_start();
include_once "sessionCheck.php";

if (isLoggedIn()) {
    goToDashboard();
}

$resetError = $_SESSION["resetError"] ?? "";
$resetSuccess = $_SESSION["resetSuccess"] ?? "";
unset($_SESSION["resetError"]);
unset($_SESSION["resetSuccess"]);

include "../View/header.php";
include "../View/forgotPassword.php";
include "../View/footer.php";
?>
