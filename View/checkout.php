<div class="checkout-grid">
    <div class="panel">
        <h2>Checkout</h2>
        <form action="placeOrder.php" method="POST">
            <div class="form-group">
                <label>Shipping Address</label>
                <textarea name="shipping_address" required><?php echo htmlspecialchars($user["address"] ?? ""); ?></textarea>
            </div>
            <div class="form-group">
                <label>Payment Method</label>
                <label class="radio-line"><input type="radio" name="payment_method" value="Cash on Delivery" checked> Cash on Delivery</label>
                <label class="radio-line"><input type="radio" name="payment_method" value="bKash"> bKash</label>
                <label class="radio-line"><input type="radio" name="payment_method" value="Nagad"> Nagad</label>
                <label class="radio-line"><input type="radio" name="payment_method" value="Bank Transfer"> Bank Transfer</label>
            </div>
            <input type="submit" value="Place Order" class="btn btn-success">
        </form>
    </div>
    <div class="panel">
        <h3>Order Summary</h3>
        <?php foreach ($cartItems as $item): ?>
            <p><?php echo htmlspecialchars($item["name"]); ?> × <?php echo $item["quantity"]; ?> = ৳<?php echo number_format($item["price"] * $item["quantity"], 2); ?></p>
        <?php endforeach; ?>
        <hr>
        <h3>Total: ৳<?php echo number_format($total, 2); ?></h3>
    </div>
</div>
