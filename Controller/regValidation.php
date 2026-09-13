<?php
session_start();

include_once "../Model/User.php";


$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

/* Registration করলে role সবসময় customer হবে */
$role = "customer";

$address = trim($_POST["address"] ?? "");
$phone = trim($_POST["phone"] ?? "");


/* Form values session এ রাখছি */
$_SESSION["nameValue"] = $name;
$_SESSION["emailValue"] = $email;
$_SESSION["addressValue"] = $address;
$_SESSION["phoneValue"] = $phone;


$hasError = false;


/* ================= NAME CHECK ================= */

if (!$name)
{
    $_SESSION["nameError"] = "Name is required";
    $hasError = true;
}
else
{
    unset($_SESSION["nameError"]);
}


/* ================= EMAIL CHECK ================= */

if (!$email)
{
    $_SESSION["emailError"] = "Email is required";
    $hasError = true;
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $_SESSION["emailError"] = "Please enter a valid email";
    $hasError = true;
}
else
{
    unset($_SESSION["emailError"]);
}


/* ================= PASSWORD CHECK ================= */

if (!$password)
{
    $_SESSION["passwordError"] = "Password is required";
    $hasError = true;
}
elseif (strlen($password) < 8)
{
    $_SESSION["passwordError"] = "Password should be at least 8 characters";
    $hasError = true;
}
else
{
    unset($_SESSION["passwordError"]);
}


/* ================= CONFIRM PASSWORD CHECK ================= */

if (!$confirmPassword)
{
    $_SESSION["confirmPasswordError"] = "Confirm password is required";
    $hasError = true;
}
elseif ($password !== $confirmPassword)
{
    $_SESSION["confirmPasswordError"] = "Password does not match";
    $hasError = true;
}
else
{
    unset($_SESSION["confirmPasswordError"]);
}


/* ================= ADDRESS CHECK ================= */

if (!$address)
{
    $_SESSION["addressError"] = "Address is required";
    $hasError = true;
}
else
{
    unset($_SESSION["addressError"]);
}


/* ================= PHONE CHECK ================= */

if (!$phone)
{
    $_SESSION["phoneError"] = "Phone is required";
    $hasError = true;
}
else
{
    unset($_SESSION["phoneError"]);
}


/* ================= EMAIL ALREADY EXISTS CHECK ================= */

$userModel = new User();

if ($email && $userModel->findByEmail($email))
{
    $_SESSION["emailError"] = "Email already exists";
    $hasError = true;
}


/* ================= ERROR THAKLE ================= */

if ($hasError)
{
    Header("Location: register.php");
    exit();
}


/* ================= CREATE USER ================= */

if ($userModel->create(
    $name,
    $email,
    $password,
    $role,
    $address,
    $phone
))
{
    unset(
        $_SESSION["nameValue"],
        $_SESSION["emailValue"],
        $_SESSION["addressValue"],
        $_SESSION["phoneValue"]
    );

    $_SESSION["message"] = "Registration successful. Please login.";
    $_SESSION["messageType"] = "success";

    Header("Location: login.php");
    exit();
}


/* ================= FAILED ================= */

$_SESSION["message"] = "Registration failed.";
$_SESSION["messageType"] = "error";

Header("Location: register.php");
exit();

?>