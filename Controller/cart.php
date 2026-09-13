<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Cart.php";
requireRole("customer");

$cartModel = new Cart();
$cartItems = $cartModel->getUserCart($_SESSION["userId"]);
$total = 0;
foreach ($cartItems as $item) {
    $total += $item["price"] * $item["quantity"];
}

include "../View/header.php";
include "../View/cart.php";
include "../View/footer.php";
?>
