<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Order.php";
include_once "../Model/Medicine.php";
include_once "../Model/Payment.php";
requireRole("order_manager");

$orderId = intval($_POST["order_id"] ?? 0);
$newStatus = $_POST["status"] ?? "";
$orderModel = new Order();
$medicineModel = new Medicine();
$paymentModel = new Payment();
$order = $orderModel->findById($orderId);

if (!$order) {
    setMessage("Order not found.", "error");
    Header("Location: orderRequests.php");
    exit();
}

$transitions = array(
    "pending" => array("accepted", "rejected"),
    "accepted" => array("processing", "cancelled"),
    "processing" => array("shipped", "cancelled"),
    "shipped" => array("delivered")
);
$currentStatus = $order["status"];
if (!isset($transitions[$currentStatus]) || !in_array($newStatus, $transitions[$currentStatus])) {
    setMessage("Invalid order status change.", "error");
    Header("Location: orderRequests.php");
    exit();
}

if ($newStatus === "rejected" || $newStatus === "cancelled") {
    $items = $orderModel->getItems($orderId);
    foreach ($items as $item) {
        $medicineModel->increaseStock($item["medicine_id"], $item["quantity"]);
    }
}

$orderModel->updateStatus($orderId, $newStatus);
if ($newStatus === "delivered" && $order["payment_method"] === "Cash on Delivery") {
    $orderModel->updatePaymentStatus($orderId, "paid");
    $paymentModel->updateStatus($orderId, "paid");
}

setMessage("Order status updated to " . ucfirst($newStatus) . ".");
Header("Location: orderRequests.php");
exit();
?>
