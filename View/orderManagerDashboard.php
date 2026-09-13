<h2>Order Manager / Sales Staff Dashboard</h2>
<p>Process purchase requests, monitor order/payment information and completed sales records.</p>
<div class="stats-grid">
    <div class="stat-card"><span>Pending Requests</span><strong><?php echo $stats["pending"]; ?></strong></div>
    <div class="stat-card"><span>Active Orders</span><strong><?php echo $stats["active"]; ?></strong></div>
    <div class="stat-card"><span>Delivered</span><strong><?php echo $stats["completed"]; ?></strong></div>
    <div class="stat-card"><span>Rejected/Cancelled</span><strong><?php echo $stats["closed"]; ?></strong></div>
</div>
<div class="action-row">
    <a class="btn" href="orderRequests.php">Purchase Requests</a>
    <a class="btn" href="orderHistoryManager.php">Completed Order History</a>
</div>
