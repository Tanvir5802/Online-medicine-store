<div class="form-wrapper wide-form">
    <form action="profileUpdate.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>My Profile</legend>
            <?php if ($profileError): ?><p class="form-error"><?php echo htmlspecialchars($profileError); ?></p><?php endif; ?>
            <?php if (!empty($user["profile_picture"])): ?>
                <p><img src="../uploads/profiles/<?php echo htmlspecialchars($user["profile_picture"]); ?>" class="profile-image" alt="Profile Picture"></p>
            <?php endif; ?>
            <table class="form-table">
                <tr><td>Full Name</td><td><input type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>"></td></tr>
                <tr><td>Email</td><td><input type="text" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>"></td></tr>
                <tr><td>Address</td><td><textarea name="address"><?php echo htmlspecialchars($user["address"]); ?></textarea></td></tr>
                <tr><td>Phone</td><td><input type="text" name="phone" value="<?php echo htmlspecialchars($user["phone"]); ?>"></td></tr>
                <tr><td>Role</td><td><input type="text" value="<?php echo htmlspecialchars($user["role"]); ?>" disabled></td></tr>
                <tr><td>Profile Picture</td><td><input type="file" name="profile_picture" accept="image/jpeg,image/png"></td></tr>
            </table>
            <h3>Change Password (Optional)</h3>
            <table class="form-table">
                <tr><td>Current Password</td><td><input type="password" name="current_password"></td></tr>
                <tr><td>New Password</td><td><input type="password" name="new_password"></td></tr>
                <tr><td>Confirm New Password</td><td><input type="password" name="confirm_password"></td></tr>
                <tr><td></td><td><input type="submit" value="Update Profile" class="btn"></td></tr>
            </table>
        </fieldset>
    </form>

    <form action="profileDelete.php" method="POST" onsubmit="return confirmDelete('Delete your profile permanently?');" class="delete-box">
        <h3>Delete Profile</h3>
        <p>This will permanently delete your account and related records.</p>
        <input type="password" name="password" placeholder="Enter current password" required>
        <input type="submit" value="Delete Profile" class="btn btn-danger">
    </form>
</div>
