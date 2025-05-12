<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
?>

<main class="dashboard-container">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-success">
            <?= escape($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <h2>Welcome to Your Dashboard</h2>

    <div class="dashboard-links">
        <a href="viewBooking.php" class="dashboard-card">View My Bookings</a>
        <a href="contact.php" class="dashboard-card">Contact Admin</a>
        <a href="viewMessage.php" class="dashboard-card">View Sent Messages</a>
    </div>
</main>

<?php require_once "../includes/footer.php"; ?>