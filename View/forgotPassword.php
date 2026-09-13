<div class="form-wrapper">
    <form action="resetPasswordValidation.php" method="POST">
        <fieldset>
            <legend>Reset Password</legend>
            <?php if ($resetError): ?><p class="form-error"><?php echo htmlspecialchars($resetError); ?></p><?php endif; ?>
            <?php if ($resetSuccess): ?><p class="form-success"><?php echo htmlspecialchars($resetSuccess); ?></p><?php endif; ?>
            <table class="form-table">
                <tr><td>Email</td><td><input type="text" name="email"></td></tr>
                <tr><td>Phone</td><td><input type="text" name="phone"></td></tr>
                <tr><td>New Password</td><td><input type="password" name="password"></td></tr>
                <tr><td>Confirm Password</td><td><input type="password" name="confirm_password"></td></tr>
                <tr><td></td><td><input type="submit" value="Reset Password" class="btn"></td></tr>
            </table>
            <p><a href="login.php">Back to Login</a></p>
        </fieldset>
    </form>
</div>
