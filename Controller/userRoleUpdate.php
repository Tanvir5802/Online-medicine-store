<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
requireRole("admin");

$id = intval($_POST["id"] ?? 0);
$role = $_POST["role"] ?? "";
$allowedRoles = array("customer", "admin", "pharmacist", "order_manager");

if (!$id || !in_array($role, $allowedRoles)) {
    setMessage("Invalid user or role.", "error");
    Header("Location: users.php");
    exit();
}
if ($id === intval($_SESSION["userId"])) {
    setMessage("You cannot change your own role while logged in.", "error");
    Header("Location: users.php");
    exit();
}

$userModel = new User();
$userModel->updateRole($id, $role);
setMessage("User role updated successfully.");
Header("Location: users.php");
exit();
?>
