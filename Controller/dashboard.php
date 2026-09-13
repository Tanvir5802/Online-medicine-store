<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/User.php";
include_once "../Model/Category.php";
include_once "../Model/Medicine.php";
include_once "../Model/Cart.php";
include_once "../Model/Order.php";

requireLogin();
$role = $_SESSION["role"];

$userModel = new User();
$categoryModel = new Category();
$medicineModel = new Medicine();
$orderModel = new Order();

include "../View/header.php";

if ($role === "customer") {
    $cartModel = new Cart();
    $stats = array(
        "cart" => $cartModel->countItems($_SESSION["userId"]),
        "orders" => $orderModel->countUserOrders($_SESSION["userId"]),
        "activeOrders" => $orderModel->countUserPending($_SESSION["userId"])
    );
    include "../View/customerDashboard.php";
} elseif ($role === "admin") {
    $stats = array(
        "users" => $userModel->countAll(),
        "customers" => $userModel->countCustomers(),
        "categories" => $categoryModel->countAll(),
        "medicines" => $medicineModel->countAll(),
        "pendingOrders" => $orderModel->countPending()
    );
    include "../View/adminDashboard.php";
} elseif ($role === "pharmacist") {
    $stats = array(
        "medicines" => $medicineModel->countAll(),
        "stock" => $medicineModel->totalStock(),
        "outOfStock" => $medicineModel->outOfStockCount(),
        "categories" => $categoryModel->countAll()
    );
    include "../View/pharmacistDashboard.php";
} elseif ($role === "order_manager") {
    $stats = array(
        "pending" => $orderModel->countPending(),
        "active" => $orderModel->countByStatuses(array("accepted", "processing", "shipped")),
        "completed" => $orderModel->countByStatuses(array("delivered")),
        "closed" => $orderModel->countByStatuses(array("rejected", "cancelled"))
    );
    include "../View/orderManagerDashboard.php";
}

include "../View/footer.php";
?>
