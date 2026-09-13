<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
requireRole("admin");

$userModel = new User();
$users = $userModel->getAllUsers();

include "../View/header.php";
include "../View/users.php";
include "../View/footer.php";
?>
