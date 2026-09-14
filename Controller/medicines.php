<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Medicine.php";
requireRole("pharmacist");

$medicineModel = new Medicine();
$medicines = $medicineModel->getAll();

include "../View/header.php";
include "../View/medicines.php";
include "../View/footer.php";
?>
