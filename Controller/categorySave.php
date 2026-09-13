<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Category.php";
requireRole("admin");

$id = intval($_POST["id"] ?? 0);
$name = trim($_POST["name"] ?? "");
$categoryType = $_POST["category_type"] ?? "";

if (!$name || !in_array($categoryType, array("solid", "liquid"))) {
    setMessage("Category name and valid type are required.", "error");
    Header("Location: categoryForm.php" . ($id ? "?id=" . $id : ""));
    exit();
}

$categoryModel = new Category();
if ($id) {
    $categoryModel->update($id, $name, $categoryType);
    setMessage("Category updated successfully.");
} else {
    $categoryModel->create($name, $categoryType);
    setMessage("Category added successfully.");
}
Header("Location: categories.php");
exit();
?>
