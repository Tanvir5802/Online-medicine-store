<div class="form-wrapper">

    <form action="regValidation.php" method="POST">

        <fieldset>

            <legend>Registration</legend>

            <table class="form-table">

                <tr>
                    <td>Full Name</td>

                    <td>
                        <input type="text"
                               name="name"
                               value="<?php echo htmlspecialchars($nameValue); ?>">
                    </td>

                    <td>
                        <span class="errorText">
                            <?php echo htmlspecialchars($nameError); ?>
                        </span>
                    </td>
                </tr>


                <tr>
                    <td>Email</td>

                    <td>
                        <input type="text"
                               name="email"
                               value="<?php echo htmlspecialchars($emailValue); ?>">
                    </td>

                    <td>
                        <span class="errorText">
                            <?php echo htmlspecialchars($emailError); ?>
                        </span>
                    </td>
                </tr>


                <tr>
                    <td>Password</td>

                    <td>
                        <input type="password"
                               name="password">
                    </td>

                    <td>
                        <span class="errorText">
                            <?php echo htmlspecialchars($passwordError); ?>
                        </span>
                    </td>
                </tr>


                <tr>
                    <td>Confirm Password</td>

                    <td>
                        <input type="password"
                               name="confirm_password">
                    </td>

                    <td>
                        <span class="errorText">
                            <?php echo htmlspecialchars($confirmPasswordError); ?>
                        </span>
                    </td>
                </tr>


                <tr>
                    <td>Address</td>

                    <td>
                        <textarea name="address"><?php echo htmlspecialchars($addressValue); ?></textarea>
                    </td>

                    <td>
                        <span class="errorText">
                            <?php echo htmlspecialchars($addressError); ?>
                        </span>
                    </td>
                </tr>


                <tr>
                    <td>Phone</td>

                    <td>
                        <input type="text"
                               name="phone"
                               value="<?php echo htmlspecialchars($phoneValue); ?>">
                    </td>

                    <td>
                        <span class="errorText">
                            <?php echo htmlspecialchars($phoneError); ?>
                        </span>
                    </td>
                </tr>


                <tr>
                    <td></td>

                    <td>
                        <input type="submit"
                               value="Register"
                               class="btn">
                    </td>

                    <td></td>
                </tr>

            </table>


            <p>
                Already have an account?
                <a href="login.php">Login</a>
            </p>

        </fieldset>

    </form>

</div>