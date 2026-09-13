<div class="form-wrapper">
    <form action="loginValidation.php" method="POST">
        <fieldset>
            <legend>Login</legend>
            <?php if ($loginError): ?><p class="form-error"><?php echo htmlspecialchars($loginError); ?></p><?php endif; ?>
            <table class="form-table">
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" value="<?php echo htmlspecialchars($emailValue); ?>"></td>
                    <td><span class="errorText"><?php echo htmlspecialchars($emailError); ?></span></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"></td>
                    <td><span class="errorText"><?php echo htmlspecialchars($passwordError); ?></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label><input type="checkbox" name="remember"> Remember Email</label></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Login" class="btn"></td>
                    <td></td>
                </tr>
            </table>
            <p>Don't have an account? <a href="register.php">Register</a></p>
            <p><a href="forgotPassword.php">Forgot / Reset Password</a></p>
        </fieldset>
    </form>
</div>
