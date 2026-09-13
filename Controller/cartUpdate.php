<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Cart.php";
include_once "../Model/Medicine.php";
requireRole("customer");

$cartId = intval($_POST["cart_id"] ?? 0);
$quantity = intval($_POST["quantity"] ?? 1);
if ($quantity < 1) $quantity = 1;

$cartModel = new Cart();
$medicineModel = new Medicine();
$item = $cartModel->getItemById($cartId, $_SESSION["userId"]);
if (!$item) {
    setMessage("Cart item not found.", "error");
    Header("Location: cart.php");
    exit();
}

$medicine = $medicineModel->findById($item["medicine_id"]);
if (!$medicine || $quantity > intval($medicine["availability"])) {
    setMessage("Requested quantity is more than available stock.", "error");
    Header("Location: cart.php");
    exit();
}

$cartModel->updateQuantity($cartId, $_SESSION["userId"], $quantity);
setMessage("Cart updated successfully.");
Header("Location: cart.php");
exit();
?>
