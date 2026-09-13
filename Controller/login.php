<?php
session_start();
include_once "sessionCheck.php";

if (isLoggedIn()) {
    goToDashboard();
}

$emailError = $_SESSION["emailError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";
$loginError = $_SESSION["loginError"] ?? "";
$emailValue = $_SESSION["emailValue"] ?? ($_COOKIE["email"] ?? "");

unset($_SESSION["emailError"]);
unset($_SESSION["passwordError"]);
unset($_SESSION["loginError"]);
unset($_SESSION["emailValue"]);

include "../View/header.php";
include "../View/login.php";
include "../View/footer.php";
?>
