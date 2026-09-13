<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Cart.php";
requireRole("customer");

$cartId = intval($_GET["id"] ?? 0);
$cartModel = new Cart();
$cartModel->removeItem($cartId, $_SESSION["userId"]);
setMessage("Item removed from cart.");
Header("Location: cart.php");
exit();
?>
