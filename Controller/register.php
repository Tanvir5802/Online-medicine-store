<?php
session_start();

include_once "sessionCheck.php";


if (isLoggedIn())
{
    goToDashboard();
}




$fields = array(
    "name",
    "email",
    "password",
    "confirmPassword",
    "address",
    "phone"
);

foreach ($fields as $field)
{
    ${$field . "Error"} = $_SESSION[$field . "Error"] ?? "";

    unset($_SESSION[$field . "Error"]);
}




$nameValue = $_SESSION["nameValue"] ?? "";
$emailValue = $_SESSION["emailValue"] ?? "";
$addressValue = $_SESSION["addressValue"] ?? "";
$phoneValue = $_SESSION["phoneValue"] ?? "";




unset($_SESSION["nameValue"]);
unset($_SESSION["emailValue"]);
unset($_SESSION["addressValue"]);
unset($_SESSION["phoneValue"]);




include "../View/header.php";
include "../View/registration.php";
include "../View/footer.php";

?>