<div class="form-wrapper wide-form">
    <form action="medicineSave.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend><?php echo $medicine ? "Edit Medicine" : "Add New Medicine"; ?></legend>
            <input type="hidden" name="id" value="<?php echo $medicine["id"] ?? 0; ?>">
            <table class="form-table">
                <tr><td>Medicine Name</td><td><input type="text" name="name" value="<?php echo htmlspecialchars($medicine["name"] ?? ""); ?>"></td></tr>
                <tr><td>Category</td><td><select name="category_id">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category["id"]; ?>" <?php echo isset($medicine) && intval($medicine["category_id"]) === intval($category["id"]) ? "selected" : ""; ?>><?php echo htmlspecialchars($category["name"]); ?></option>
                    <?php endforeach; ?>
                </select></td></tr>
                <tr><td>Vendor Name</td><td><input type="text" name="vendor_name" value="<?php echo htmlspecialchars($medicine["vendor_name"] ?? ""); ?>"></td></tr>
                <tr><td>Price (BDT)</td><td><input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($medicine["price"] ?? ""); ?>"></td></tr>
                <tr><td>Stock / Availability</td><td><input type="number" min="0" name="availability" value="<?php echo htmlspecialchars($medicine["availability"] ?? "0"); ?>"></td></tr>
                <tr><td>Description</td><td><textarea name="description"><?php echo htmlspecialchars($medicine["description"] ?? ""); ?></textarea></td></tr>
                <tr><td>Image</td><td><input type="file" name="image" accept="image/jpeg,image/png"></td></tr>
                <tr><td></td><td><input type="submit" value="Save Medicine" class="btn"></td></tr>
            </table>
        </fieldset>
    </form>
</div>
