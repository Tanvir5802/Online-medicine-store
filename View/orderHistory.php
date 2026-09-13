<h2>My Order History</h2>
<?php if (!$orders): ?>
    <div class="empty-box">You have no orders yet.</div>
<?php else: ?>
<div class="table-wrap">
<table class="data-table">
    <tr><th>Order ID</th><th>Date</th><th>Total</th><th>Order Status</th><th>Payment</th><th>Action</th></tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td>#<?php echo $order["id"]; ?></td>
            <td><?php echo $order["order_date"]; ?></td>
            <td>৳<?php echo number_format($order["total_amount"], 2); ?></td>
            <td><span class="status status-<?php echo $order["status"]; ?>"><?php echo ucfirst($order["status"]); ?></span></td>
            <td><?php echo htmlspecialchars($order["payment_method"] ?? ""); ?> / <?php echo htmlspecialchars($order["payment_status"]); ?></td>
            <td><a href="invoice.php?id=<?php echo $order["id"]; ?>" class="btn btn-small">View Invoice</a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php endif; ?>
