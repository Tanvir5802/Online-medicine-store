<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Cart.php";
include_once "../Model/User.php";
requireRole("customer");

$cartModel = new Cart();
$userModel = new User();
$cartItems = $cartModel->getUserCart($_SESSION["userId"]);
if (!$cartItems) {
    setMessage("Your cart is empty.", "error");
    Header("Location: cart.php");
    exit();
}

$user = $userModel->findById($_SESSION["userId"]);
$total = 0;
foreach ($cartItems as $item) {
    $total += $item["price"] * $item["quantity"];
}

include "../View/header.php";
include "../View/checkout.php";
include "../View/footer.php";
?>
