<div class="hero">
    <div>
        <h1>Online Medicine Store</h1>
        <p>Browse available medicines, check stock and manage your purchase in one place.</p>
    </div>
</div>

<form method="GET" action="home.php" class="filter-box">
    <input type="text" name="q" placeholder="Search medicine or vendor" value="<?php echo htmlspecialchars($keyword); ?>">
    <select name="category_id">
        <option value="">All Categories</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category["id"]; ?>" <?php echo strval($categoryId) === strval($category["id"]) ? "selected" : ""; ?>>
                <?php echo htmlspecialchars($category["name"]); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="vendor">
        <option value="">All Vendors</option>
        <?php foreach ($vendors as $vendorItem): ?>
            <option value="<?php echo htmlspecialchars($vendorItem["vendor_name"]); ?>" <?php echo $vendor === $vendorItem["vendor_name"] ? "selected" : ""; ?>>
                <?php echo htmlspecialchars($vendorItem["vendor_name"]); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="category_type">
        <option value="">All Types</option>
        <option value="solid" <?php echo $categoryType === "solid" ? "selected" : ""; ?>>Solid</option>
        <option value="liquid" <?php echo $categoryType === "liquid" ? "selected" : ""; ?>>Liquid</option>
    </select>
    <input type="submit" value="Search" class="btn">
    <a href="home.php" class="btn btn-light">Clear</a>
</form>

<h2>Available Medicines</h2>
<div class="medicine-grid">
    <?php if (!$medicines): ?>
        <p>No medicine found.</p>
    <?php endif; ?>
    <?php foreach ($medicines as $medicine): ?>
        <div class="medicine-card">
            <img src="../uploads/medicines/<?php echo htmlspecialchars($medicine["image_path"] ?: "default.png"); ?>" alt="Medicine Image">
            <h3><?php echo htmlspecialchars($medicine["name"]); ?></h3>
            <p><b>Category:</b> <?php echo htmlspecialchars($medicine["category_name"]); ?> (<?php echo htmlspecialchars($medicine["category_type"]); ?>)</p>
            <p><b>Vendor:</b> <?php echo htmlspecialchars($medicine["vendor_name"]); ?></p>
            <p><b>Price:</b> ৳<?php echo number_format($medicine["price"], 2); ?></p>
            <p><b>Stock:</b> <?php echo intval($medicine["availability"]); ?></p>
            <p class="description"><?php echo htmlspecialchars($medicine["description"]); ?></p>

            <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "customer" && intval($medicine["availability"]) > 0 && $medicine["status"] === "active"): ?>
                <form action="cartAdd.php" method="POST" class="inline-form">
                    <input type="hidden" name="medicine_id" value="<?php echo $medicine["id"]; ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo intval($medicine["availability"]); ?>" class="qty-input">
                    <input type="submit" value="Add to Cart" class="btn btn-success">
                </form>
            <?php elseif (!isset($_SESSION["isLoggedIn"])): ?>
                <a href="login.php" class="btn">Login to Buy</a>
            <?php elseif (intval($medicine["availability"]) <= 0): ?>
                <span class="stock-out">Out of Stock</span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
