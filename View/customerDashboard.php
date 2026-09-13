<h2>Customer Dashboard</h2>
<p>Welcome, <b><?php echo htmlspecialchars($_SESSION["loggedInUser"]); ?></b>. Browse medicines, manage your cart and check your orders.</p>
<div class="stats-grid">
    <div class="stat-card"><span>Cart Items</span><strong><?php echo $stats["cart"]; ?></strong></div>
    <div class="stat-card"><span>Total Orders</span><strong><?php echo $stats["orders"]; ?></strong></div>
    <div class="stat-card"><span>Active Orders</span><strong><?php echo $stats["activeOrders"]; ?></strong></div>
</div>
<div class="action-row">
    <a class="btn" href="home.php">Browse Medicines</a>
    <a class="btn" href="cart.php">Manage Cart</a>
    <a class="btn" href="orderHistory.php">Order History</a>
</div>
