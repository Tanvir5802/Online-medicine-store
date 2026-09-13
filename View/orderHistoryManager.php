<h2>Completed Order / Purchase History</h2>
<?php if (!$orders): ?>
    <div class="empty-box">No completed or closed orders yet.</div>
<?php else: ?>
<div class="table-wrap">
<table class="data-table">
    <tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Payment</th><th>Date</th><th>Details</th></tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td>#<?php echo $order["id"]; ?></td>
            <td><?php echo htmlspecialchars($order["customer_name"]); ?></td>
            <td>৳<?php echo number_format($order["total_amount"], 2); ?></td>
            <td><span class="status status-<?php echo $order["status"]; ?>"><?php echo ucfirst($order["status"]); ?></span></td>
            <td><?php echo htmlspecialchars($order["payment_method"] ?? ""); ?> / <?php echo htmlspecialchars($order["payment_status"]); ?></td>
            <td><?php echo $order["order_date"]; ?></td>
            <td><a href="invoice.php?id=<?php echo $order["id"]; ?>" class="btn btn-small">View</a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php endif; ?>
