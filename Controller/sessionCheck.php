<?php
function isLoggedIn()
{
    return isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true;
}

function requireLogin()
{
    if (!isLoggedIn()) {
        Header("Location: login.php");
        exit();
    }
}

function requireRole($roles)
{
    requireLogin();
    if (!is_array($roles)) {
        $roles = array($roles);
    }

    $currentRole = $_SESSION["role"] ?? "";
    if (!in_array($currentRole, $roles)) {
        $_SESSION["message"] = "You do not have permission to access that page.";
        $_SESSION["messageType"] = "error";
        Header("Location: dashboard.php");
        exit();
    }
}

function setMessage($message, $type = "success")
{
    $_SESSION["message"] = $message;
    $_SESSION["messageType"] = $type;
}

function goToDashboard()
{
    Header("Location: dashboard.php");
    exit();
}
?>
