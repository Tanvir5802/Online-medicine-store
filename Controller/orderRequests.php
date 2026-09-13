<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Order.php";
requireRole("order_manager");

$orderModel = new Order();
$orders = $orderModel->getWorkingOrders();

include "../View/header.php";
include "../View/orderRequests.php";
include "../View/footer.php";
?>
