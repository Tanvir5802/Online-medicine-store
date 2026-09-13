<?php
session_start();
include_once "../Model/Medicine.php";
include_once "../Model/Category.php";

$keyword = $_GET["q"] ?? "";
$categoryId = $_GET["category_id"] ?? "";
$vendor = $_GET["vendor"] ?? "";
$categoryType = $_GET["category_type"] ?? "";

$medicineModel = new Medicine();
$categoryModel = new Category();
$medicines = $medicineModel->getAll($keyword, $categoryId, $vendor, $categoryType);
$categories = $categoryModel->getAll();
$vendors = $medicineModel->getVendors();

include "../View/header.php";
include "../View/home.php";
include "../View/footer.php";
?>
