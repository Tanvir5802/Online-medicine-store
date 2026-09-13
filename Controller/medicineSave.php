<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Medicine.php";
include_once "../Model/Category.php";
requireRole("pharmacist");

$id = intval($_POST["id"] ?? 0);
$name = trim($_POST["name"] ?? "");
$categoryId = intval($_POST["category_id"] ?? 0);
$vendorName = trim($_POST["vendor_name"] ?? "");
$price = floatval($_POST["price"] ?? 0);
$availability = intval($_POST["availability"] ?? -1);
$description = trim($_POST["description"] ?? "");

if (!$name || !$categoryId || !$vendorName || $price <= 0 || $availability < 0) {
    setMessage("Medicine name, category, vendor, valid price and stock are required.", "error");
    Header("Location: medicineForm.php" . ($id ? "?id=" . $id : ""));
    exit();
}

$categoryModel = new Category();
if (!$categoryModel->findById($categoryId)) {
    setMessage("Selected category does not exist.", "error");
    Header("Location: medicineForm.php" . ($id ? "?id=" . $id : ""));
    exit();
}

$imagePath = "";
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["image"];
    $allowed = array("jpg", "jpeg", "png");
    $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowed) || $file["size"] > 2 * 1024 * 1024) {
        setMessage("Medicine image must be JPG/PNG and less than 2MB.", "error");
        Header("Location: medicineForm.php" . ($id ? "?id=" . $id : ""));
        exit();
    }
    $imagePath = "medicine_" . time() . "_" . rand(1000, 9999) . "." . $extension;
    move_uploaded_file($file["tmp_name"], "../uploads/medicines/" . $imagePath);
}

$medicineModel = new Medicine();
if ($id) {
    $medicineModel->update($id, $name, $categoryId, $vendorName, $price, $availability, $description, $imagePath);
    setMessage("Medicine updated successfully.");
} else {
    if (!$imagePath) {
        $imagePath = "default.png";
    }
    $medicineModel->create($name, $categoryId, $vendorName, $price, $availability, $description, $imagePath);
    setMessage("Medicine added successfully.");
}
Header("Location: medicines.php");
exit();
?>
