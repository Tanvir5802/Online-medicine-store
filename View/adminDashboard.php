<h2>Admin Dashboard</h2>
<p>Manage users, roles, categories and view overall system information.</p>
<div class="stats-grid">
    <div class="stat-card"><span>All Users</span><strong><?php echo $stats["users"]; ?></strong></div>
    <div class="stat-card"><span>Customers</span><strong><?php echo $stats["customers"]; ?></strong></div>
    <div class="stat-card"><span>Categories</span><strong><?php echo $stats["categories"]; ?></strong></div>
    <div class="stat-card"><span>Medicines</span><strong><?php echo $stats["medicines"]; ?></strong></div>
    <div class="stat-card"><span>Pending Orders</span><strong><?php echo $stats["pendingOrders"]; ?></strong></div>
</div>
<div class="action-row">
    <a class="btn" href="users.php">Manage Users & Roles</a>
    <a class="btn" href="categories.php">Manage Categories</a>
</div>
