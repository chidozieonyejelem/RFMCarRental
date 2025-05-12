<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$stmt = $pdo->query("SELECT b.bookingID, u.name, c.make, c.model, b.startDate, b.endDate, b.totalCost, b.status
                     FROM bookings b
                     JOIN users u ON b.userID = u.userID
                     JOIN cars c ON b.carID = c.carID
                     ORDER BY b.startDate DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="form-container wide-form">
    <h2>Manage All Bookings</h2>

    <?php if (isset($_SESSION['booking_updated'])): ?>
        <div class="flash-message flash-success">
            <?= escape($_SESSION['booking_updated']); unset($_SESSION['booking_updated']); ?>
        </div>
    <?php endif; ?>

    <table class="data-table">
        <thead>
        <tr>
            <th>ID</th><th>User</th><th>Car</th><th>Start</th><th>End</th><th>€</th><th>Status</th><th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= escape($b['bookingID']) ?></td>
                <td><?= escape($b['name']) ?></td>
                <td><?= escape($b['make'] . ' ' . $b['model']) ?></td>
                <td><?= escape($b['startDate']) ?></td>
                <td><?= escape($b['endDate']) ?></td>
                <td>€<?= number_format($b['totalCost'], 2) ?></td>
                <td><?= escape($b['status']) ?></td>
                <td>
                    <a href="updateBooking.php?id=<?= escape($b['bookingID']) ?>" class="edit-link">Edit</a>
                    <a href="deleteBooking.php?id=<?= escape($b['bookingID']) ?>" class="delete-link" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn back-btn">← Back to Admin Dashboard</a>
</main>

<?php require_once "../../includes/footer.php"; ?>