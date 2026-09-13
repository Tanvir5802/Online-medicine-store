<div class="section-header">
    <div><h2>Category Management</h2><p>Create, edit and delete medicine categories.</p></div>
    <a href="categoryForm.php" class="btn">+ Add Category</a>
</div>
<table class="data-table">
    <tr><th>ID</th><th>Name</th><th>Type</th><th>Created</th><th>Actions</th></tr>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td><?php echo $category["id"]; ?></td>
            <td><?php echo htmlspecialchars($category["name"]); ?></td>
            <td><?php echo htmlspecialchars($category["category_type"]); ?></td>
            <td><?php echo $category["created_at"]; ?></td>
            <td>
                <a href="categoryForm.php?id=<?php echo $category["id"]; ?>" class="btn btn-small">Edit</a>
                <a href="categoryDelete.php?id=<?php echo $category["id"]; ?>" class="btn btn-danger btn-small" onclick="return confirmDelete('Delete this category?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
