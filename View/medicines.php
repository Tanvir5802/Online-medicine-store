<div class="section-header">
    <div><h2>Medicine & Stock Management</h2><p>Add, edit, delete and monitor medicine stock/availability.</p></div>
    <a href="medicineForm.php" class="btn">+ Add New Medicine</a>
</div>
<div class="table-wrap">
<table class="data-table">
    <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Vendor</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
    <?php foreach ($medicines as $medicine): ?>
        <tr>
            <td><?php echo $medicine["id"]; ?></td>
            <td><img src="../uploads/medicines/<?php echo htmlspecialchars($medicine["image_path"] ?: "default.png"); ?>" class="table-image" alt="Medicine"></td>
            <td><?php echo htmlspecialchars($medicine["name"]); ?></td>
            <td><?php echo htmlspecialchars($medicine["category_name"]); ?></td>
            <td><?php echo htmlspecialchars($medicine["vendor_name"]); ?></td>
            <td>৳<?php echo number_format($medicine["price"], 2); ?></td>
            <td><?php echo intval($medicine["availability"]); ?></td>
            <td>
                <a href="medicineForm.php?id=<?php echo $medicine["id"]; ?>" class="btn btn-small">Edit</a>
                <a href="medicineDelete.php?id=<?php echo $medicine["id"]; ?>" class="btn btn-danger btn-small" onclick="return confirmDelete('Delete this medicine?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
