<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Category.php";
requireRole("admin");

$category = null;
$id = intval($_GET["id"] ?? 0);
if ($id) {
    $categoryModel = new Category();
    $category = $categoryModel->findById($id);
}

include "../View/header.php";
include "../View/categoryForm.php";
include "../View/footer.php";
?>
