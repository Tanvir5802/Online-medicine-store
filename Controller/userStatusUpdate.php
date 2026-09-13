<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
requireRole("admin");

$id = intval($_POST["id"] ?? 0);
$status = $_POST["status"] ?? "";
if (!$id || !in_array($status, array("active", "inactive"))) {
    setMessage("Invalid user status.", "error");
    Header("Location: users.php");
    exit();
}
if ($id === intval($_SESSION["userId"])) {
    setMessage("You cannot deactivate your own account from this page.", "error");
    Header("Location: users.php");
    exit();
}

$userModel = new User();
$userModel->updateStatus($id, $status);
setMessage("User status updated successfully.");
Header("Location: users.php");
exit();
?>
