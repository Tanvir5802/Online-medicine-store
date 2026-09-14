<h2>Pharmacist / Inventory Manager Dashboard</h2>
<p>Maintain medicine records, medicine details and stock availability.</p>
<div class="stats-grid">
    <div class="stat-card"><span>Total Medicines</span><strong><?php echo $stats["medicines"]; ?></strong></div>
    <div class="stat-card"><span>Total Stock</span><strong><?php echo $stats["stock"]; ?></strong></div>
    <div class="stat-card"><span>Out of Stock</span><strong><?php echo $stats["outOfStock"]; ?></strong></div>
    <div class="stat-card"><span>Categories</span><strong><?php echo $stats["categories"]; ?></strong></div>
</div>
<div class="action-row">
    <a class="btn" href="medicines.php">Manage Medicines</a>
    <a class="btn" href="medicineForm.php">Add New Medicine</a>
</div>
