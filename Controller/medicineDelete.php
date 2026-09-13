<?php
session_start();
include_once "sessionCheck.php";
include_once "../Model/Medicine.php";
requireRole("pharmacist");

$id = intval($_GET["id"] ?? 0);
$medicineModel = new Medicine();
if ($medicineModel->usedInOrders($id)) {
    setMessage("Medicine could not be deleted because it is used in an existing order.", "error");
} else {
    $medicineModel->delete($id);
    setMessage("Medicine deleted successfully.");
}
Header("Location: medicines.php");
exit();
?>
