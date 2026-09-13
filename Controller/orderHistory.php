<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Order.php";
requireRole("customer");

$orderModel = new Order();
$orders = $orderModel->getUserOrders($_SESSION["userId"]);

include "../View/header.php";
include "../View/orderHistory.php";
include "../View/footer.php";
?>
