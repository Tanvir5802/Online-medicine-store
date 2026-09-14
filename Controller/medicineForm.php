<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Medicine.php";
include_once "../Model/Category.php";
requireRole("pharmacist");

$medicine = null;
$id = intval($_GET["id"] ?? 0);
$medicineModel = new Medicine();
$categoryModel = new Category();
$categories = $categoryModel->getAll();
if ($id) {
    $medicine = $medicineModel->findById($id);
}

include "../View/header.php";
include "../View/medicineForm.php";
include "../View/footer.php";
?>
