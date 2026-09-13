<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Category.php";
requireRole("admin");

$id = intval($_GET["id"] ?? 0);
$categoryModel = new Category();
if ($categoryModel->hasMedicines($id)) {
    setMessage("Cannot delete a category that has medicines.", "error");
} else {
    $categoryModel->delete($id);
    setMessage("Category deleted successfully.");
}
Header("Location: categories.php");
exit();
?>
