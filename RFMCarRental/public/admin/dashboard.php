<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/common.php";
?>

<main class="container dashboard-container">
    <?php if (!empty($_SESSION['popup'])): ?>
        <div class="flash-message flash-blue">
            <?= escape($_SESSION['popup']); unset($_SESSION['popup']); ?>
        </div>
    <?php endif; ?>

    <h2>Admin Dashboard</h2>

    <div class="dashboard-links">
        <a href="readCar.php" class="dashboard-card">Manage Cars</a>
        <a href="readBooking.php" class="dashboard-card">Manage Bookings</a>
        <a href="readUser.php" class="dashboard-card">Manage Users</a>
        <a href="readMessage.php" class="dashboard-card">View User Messages</a>
    </div>

    <a href="../../public/dashboard.php" class="btn back-btn">← Back to Home</a>
</main>

<?php require_once "../../includes/adminFooter.php"; ?>