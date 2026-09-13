<h2>Shopping Cart</h2>
<?php if (!$cartItems): ?>
    <div class="empty-box">Your cart is empty. <a href="home.php">Continue Shopping</a></div>
<?php else: ?>
<div class="table-wrap">
<table class="data-table">
    <tr><th>Medicine</th><th>Price</th><th>Available</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>
    <?php foreach ($cartItems as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item["name"]); ?><br><small><?php echo htmlspecialchars($item["vendor_name"]); ?></small></td>
            <td>৳<?php echo number_format($item["price"], 2); ?></td>
            <td><?php echo intval($item["availability"]); ?></td>
            <td>
                <form action="cartUpdate.php" method="POST" class="inline-form">
                    <input type="hidden" name="cart_id" value="<?php echo $item["cart_id"]; ?>">
                    <input type="number" name="quantity" value="<?php echo $item["quantity"]; ?>" min="1" max="<?php echo intval($item["availability"]); ?>" class="qty-input">
                    <input type="submit" value="Update" class="btn btn-small">
                </form>
            </td>
            <td>৳<?php echo number_format($item["price"] * $item["quantity"], 2); ?></td>
            <td><a href="cartRemove.php?id=<?php echo $item["cart_id"]; ?>" class="btn btn-danger btn-small" onclick="return confirmDelete('Remove this cart item?');">Remove</a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<div class="total-box">
    <h3>Total: ৳<?php echo number_format($total, 2); ?></h3>
    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
</div>
<?php endif; ?>
