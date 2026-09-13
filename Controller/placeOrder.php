<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Cart.php";
include_once "../Model/Medicine.php";
include_once "../Model/Order.php";
include_once "../Model/Payment.php";
requireRole("customer");

$shippingAddress = trim($_POST["shipping_address"] ?? "");
$paymentMethod = $_POST["payment_method"] ?? "";
$allowedPayments = array("Cash on Delivery", "bKash", "Nagad", "Bank Transfer");

if (!$shippingAddress || !in_array($paymentMethod, $allowedPayments)) {
    setMessage("Shipping address and payment method are required.", "error");
    Header("Location: checkout.php");
    exit();
}

$cartModel = new Cart();
$medicineModel = new Medicine();
$orderModel = new Order();
$paymentModel = new Payment();
$cartItems = $cartModel->getUserCart($_SESSION["userId"]);

if (!$cartItems) {
    setMessage("Your cart is empty.", "error");
    Header("Location: cart.php");
    exit();
}

$total = 0;
foreach ($cartItems as $item) {
    if (!$medicineModel->checkStock($item["medicine_id"], $item["quantity"])) {
        setMessage("Insufficient stock for " . $item["name"] . ".", "error");
        Header("Location: cart.php");
        exit();
    }
    $total += $item["price"] * $item["quantity"];
}

$paymentStatus = $paymentMethod === "Cash on Delivery" ? "pending" : "paid";
$orderId = $orderModel->create($_SESSION["userId"], $total, $shippingAddress, $paymentStatus, $cartItems);
if (!$orderId) {
    setMessage("Order could not be created.", "error");
    Header("Location: checkout.php");
    exit();
}

foreach ($cartItems as $item) {
    $medicineModel->decreaseStock($item["medicine_id"], $item["quantity"]);
}

$transactionId = "TXN" . date("YmdHis") . $orderId;
$paymentModel->create($orderId, $total, $paymentMethod, $transactionId, $paymentStatus);
$cartModel->clearCart($_SESSION["userId"]);

setMessage("Order placed successfully.");
Header("Location: invoice.php?id=" . $orderId);
exit();
?>
