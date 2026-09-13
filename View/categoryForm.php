<div class="form-wrapper">
    <form action="categorySave.php" method="POST">
        <fieldset>
            <legend><?php echo $category ? "Edit Category" : "Add Category"; ?></legend>
            <input type="hidden" name="id" value="<?php echo $category["id"] ?? 0; ?>">
            <table class="form-table">
                <tr><td>Category Name</td><td><input type="text" name="name" value="<?php echo htmlspecialchars($category["name"] ?? ""); ?>"></td></tr>
                <tr>
                    <td>Type</td>
                    <td>
                        <select name="category_type">
                            <option value="solid" <?php echo ($category["category_type"] ?? "") === "solid" ? "selected" : ""; ?>>Solid</option>
                            <option value="liquid" <?php echo ($category["category_type"] ?? "") === "liquid" ? "selected" : ""; ?>>Liquid</option>
                        </select>
                    </td>
                </tr>
                <tr><td></td><td><input type="submit" value="Save Category" class="btn"></td></tr>
            </table>
        </fieldset>
    </form>
</div>
