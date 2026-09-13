<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
requireRole("admin");

$id = intval($_GET["id"] ?? 0);
if (!$id || $id === intval($_SESSION["userId"])) {
    setMessage("You cannot delete this account.", "error");
    Header("Location: users.php");
    exit();
}

$userModel = new User();
$userModel->deleteUser($id);
setMessage("User account deleted successfully.");
Header("Location: users.php");
exit();
?>
