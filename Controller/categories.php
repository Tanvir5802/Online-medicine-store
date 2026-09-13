<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Category.php";
requireRole("admin");

$categoryModel = new Category();
$categories = $categoryModel->getAll();

include "../View/header.php";
include "../View/categories.php";
include "../View/footer.php";
?>
