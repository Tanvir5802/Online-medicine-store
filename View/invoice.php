<div class="invoice-box">
    <div class="section-header">
        <div><h2>Order Confirmation / Invoice</h2><p>Order #<?php echo $order["id"]; ?></p></div>
        <button type="button" class="btn" onclick="printInvoice();">Print Invoice</button>
    </div>
    <div class="invoice-meta">
        <p><b>Customer:</b> <?php echo htmlspecialchars($order["customer_name"]); ?></p>
        <p><b>Email:</b> <?php echo htmlspecialchars($order["customer_email"]); ?></p>
        <p><b>Phone:</b> <?php echo htmlspecialchars($order["customer_phone"]); ?></p>
        <p><b>Shipping Address:</b> <?php echo nl2br(htmlspecialchars($order["shipping_address"])); ?></p>
        <p><b>Order Status:</b> <?php echo ucfirst($order["status"]); ?></p>
        <p><b>Payment:</b> <?php echo htmlspecialchars($order["payment_method"] ?? ""); ?> (<?php echo htmlspecialchars($order["payment_status"]); ?>)</p>
        <p><b>Transaction ID:</b> <?php echo htmlspecialchars($order["transaction_id"] ?? ""); ?></p>
        <p><b>Date:</b> <?php echo $order["order_date"]; ?></p>
    </div>
    <table class="data-table">
        <tr><th>Medicine</th><th>Vendor</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr>
        <?php foreach ($orderItems as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item["medicine_name"]); ?></td>
                <td><?php echo htmlspecialchars($item["vendor_name"]); ?></td>
                <td><?php echo $item["quantity"]; ?></td>
                <td>৳<?php echo number_format($item["unit_price"], 2); ?></td>
                <td>৳<?php echo number_format($item["unit_price"] * $item["quantity"], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h3 class="invoice-total">Grand Total: ৳<?php echo number_format($order["total_amount"], 2); ?></h3>
</div>
