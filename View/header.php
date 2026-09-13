<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Medicine Store Management System</title>
    <link rel="stylesheet" href="../Assets/style.css">
    <script src="../Assets/script.js"></script>
</head>
<body>
    <div class="topbar">
        <div class="brand"><a href="home.php">MediShop</a></div>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <?php if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true): ?>
                <a href="dashboard.php">Dashboard</a>
                <?php if (($_SESSION["role"] ?? "") === "customer"): ?>
                    <a href="cart.php">Cart</a>
                    <a href="orderHistory.php">My Orders</a>
                <?php elseif (($_SESSION["role"] ?? "") === "admin"): ?>
                    <a href="users.php">Users</a>
                    <a href="categories.php">Categories</a>
                <?php elseif (($_SESSION["role"] ?? "") === "pharmacist"): ?>
                    <a href="medicines.php">Medicines</a>
                <?php elseif (($_SESSION["role"] ?? "") === "order_manager"): ?>
                    <a href="orderRequests.php">Purchase Requests</a>
                    <a href="orderHistoryManager.php">Order History</a>
                <?php endif; ?>
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Registration</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="page-container">
        <?php if (isset($_SESSION["message"])): ?>
            <div class="alert <?php echo ($_SESSION["messageType"] ?? "success") === "error" ? "alert-error" : "alert-success"; ?>">
                <?php echo htmlspecialchars($_SESSION["message"]); ?>
            </div>
            <?php unset($_SESSION["message"], $_SESSION["messageType"]); ?>
        <?php endif; ?>
