<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Cart.php";
include_once "../Model/Medicine.php";
requireRole("customer");

$medicineId = intval($_POST["medicine_id"] ?? 0);
$quantity = intval($_POST["quantity"] ?? 1);
if ($quantity < 1) $quantity = 1;

$medicineModel = new Medicine();
$cartModel = new Cart();
$medicine = $medicineModel->findById($medicineId);

if (!$medicine || $medicine["status"] !== "active") {
    setMessage("Medicine is not available.", "error");
    Header("Location: home.php");
    exit();
}

$currentQuantity = 0;
$items = $cartModel->getUserCart($_SESSION["userId"]);
foreach ($items as $item) {
    if (intval($item["medicine_id"]) === $medicineId) {
        $currentQuantity = intval($item["quantity"]);
        break;
    }
}

if (($currentQuantity + $quantity) > intval($medicine["availability"])) {
    setMessage("Requested quantity is more than available stock.", "error");
    Header("Location: home.php");
    exit();
}

$cartModel->addItem($_SESSION["userId"], $medicineId, $quantity);
setMessage("Medicine added to cart.");
Header("Location: home.php");
exit();
?>
