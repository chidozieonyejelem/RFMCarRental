<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../src/common.php";

if (!isset($_SESSION['user_id']) || $_SESSION['isAdmin'] != 1) {
    header("Location: /public/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RF Motors Car Rental</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <a href="/public/index.php"><img src="/images/RFM_Logo.png" alt="RF Motors Logo"></a>
        </div>

        <ul class="nav-links">
            <li><a href="/public/index.php">Home</a></li>
            <li><a href="/public/cars.php">Cars</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['isAdmin'] == 1): ?>
                    <li><a href="/public/admin/dashboard.php">Dashboard</a></li>
                <?php else: ?>
                    <li><a href="/public/dashboard.php">Dashboard</a></li>
                <?php endif; ?>
                <li><a href="/public/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/public/login.php">Login</a></li>
                <li><a href="/public/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>