<div class="section-header">
    <div><h2>User & Role Management</h2><p>Admin can manage registered users, roles and account status.</p></div>
</div>
<div class="table-wrap">
<table class="data-table">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Action</th></tr>
    <?php foreach ($users as $userItem): ?>
        <tr>
            <td><?php echo $userItem["id"]; ?></td>
            <td><?php echo htmlspecialchars($userItem["name"]); ?></td>
            <td><?php echo htmlspecialchars($userItem["email"]); ?></td>
            <td><?php echo htmlspecialchars($userItem["phone"]); ?></td>
            <td>
                <?php if (intval($userItem["id"]) === intval($_SESSION["userId"])): ?>
                    <?php echo htmlspecialchars($userItem["role"]); ?>
                <?php else: ?>
                    <form action="userRoleUpdate.php" method="POST" class="inline-form">
                        <input type="hidden" name="id" value="<?php echo $userItem["id"]; ?>">
                        <select name="role">
                            <?php foreach (array("customer","admin","pharmacist","order_manager") as $roleOption): ?>
                                <option value="<?php echo $roleOption; ?>" <?php echo $userItem["role"] === $roleOption ? "selected" : ""; ?>><?php echo $roleOption; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" value="Save" class="btn btn-small">
                    </form>
                <?php endif; ?>
            </td>
            <td>
                <?php if (intval($userItem["id"]) === intval($_SESSION["userId"])): ?>
                    <?php echo htmlspecialchars($userItem["status"]); ?>
                <?php else: ?>
                    <form action="userStatusUpdate.php" method="POST" class="inline-form">
                        <input type="hidden" name="id" value="<?php echo $userItem["id"]; ?>">
                        <select name="status">
                            <option value="active" <?php echo $userItem["status"] === "active" ? "selected" : ""; ?>>active</option>
                            <option value="inactive" <?php echo $userItem["status"] === "inactive" ? "selected" : ""; ?>>inactive</option>
                        </select>
                        <input type="submit" value="Save" class="btn btn-small">
                    </form>
                <?php endif; ?>
            </td>
            <td>
                <?php if (intval($userItem["id"]) !== intval($_SESSION["userId"])): ?>
                    <a href="userDelete.php?id=<?php echo $userItem["id"]; ?>" class="btn btn-danger btn-small" onclick="return confirmDelete('Delete this user?');">Delete</a>
                <?php else: ?>
                    Current Admin
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
