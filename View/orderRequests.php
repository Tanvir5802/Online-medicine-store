<h2>Purchase Requests & Order Processing</h2>
<p>Review incoming orders, accept/reject requests, update order status and monitor payment information.</p>
<?php if (!$orders): ?>
    <div class="empty-box">No active purchase requests.</div>
<?php else: ?>
<div class="table-wrap">
<table class="data-table">
    <tr><th>ID</th><th>Customer</th><th>Amount</th><th>Payment</th><th>Transaction</th><th>Status</th><th>Next Action</th><th>Details</th></tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td>#<?php echo $order["id"]; ?></td>
            <td><?php echo htmlspecialchars($order["customer_name"]); ?><br><small><?php echo htmlspecialchars($order["customer_phone"]); ?></small></td>
            <td>৳<?php echo number_format($order["total_amount"], 2); ?></td>
            <td><?php echo htmlspecialchars($order["payment_method"] ?? ""); ?><br><small><?php echo htmlspecialchars($order["payment_status"]); ?></small></td>
            <td><?php echo htmlspecialchars($order["transaction_id"] ?? ""); ?></td>
            <td><span class="status status-<?php echo $order["status"]; ?>"><?php echo ucfirst($order["status"]); ?></span></td>
            <td>
                <form action="orderStatusUpdate.php" method="POST" class="inline-form">
                    <input type="hidden" name="order_id" value="<?php echo $order["id"]; ?>">
                    <select name="status">
                        <?php if ($order["status"] === "pending"): ?>
                            <option value="accepted">Accept</option><option value="rejected">Reject</option>
                        <?php elseif ($order["status"] === "accepted"): ?>
                            <option value="processing">Processing</option><option value="cancelled">Cancel</option>
                        <?php elseif ($order["status"] === "processing"): ?>
                            <option value="shipped">Shipped</option><option value="cancelled">Cancel</option>
                        <?php elseif ($order["status"] === "shipped"): ?>
                            <option value="delivered">Delivered</option>
                        <?php endif; ?>
                    </select>
                    <input type="submit" value="Update" class="btn btn-small">
                </form>
            </td>
            <td><a href="invoice.php?id=<?php echo $order["id"]; ?>" class="btn btn-small">View</a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php endif; ?>
