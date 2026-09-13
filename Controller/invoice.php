<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Order.php";
requireLogin();

$orderId = intval($_GET["id"] ?? 0);
$orderModel = new Order();
$order = $orderModel->findById($orderId);

if (!$order) {
    setMessage("Order not found.", "error");
    goToDashboard();
}

$role = $_SESSION["role"];
if ($role === "customer" && intval($order["user_id"]) !== intval($_SESSION["userId"])) {
    setMessage("You cannot view another customer's order.", "error");
    goToDashboard();
}
if (!in_array($role, array("customer", "order_manager", "admin"))) {
    setMessage("You do not have permission to view this order.", "error");
    goToDashboard();
}

$orderItems = $orderModel->getItems($orderId);
include "../View/header.php";
include "../View/invoice.php";
include "../View/footer.php";
?>
