<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Order.php";
requireRole("order_manager");

$orderModel = new Order();
$orders = $orderModel->getCompletedOrders();

include "../View/header.php";
include "../View/orderHistoryManager.php";
include "../View/footer.php";
?>
