<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
require_once "../src/db_connect.php";
require_once "../src/common.php";

$userID = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT b.bookingID, c.make, c.model, b.startDate, b.endDate, b.totalCost, b.status
                       FROM bookings b
                       JOIN cars c ON b.carID = c.carID
                       WHERE b.userID = ?
                       ORDER BY b.startDate DESC");
$stmt->execute([$userID]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="form-container wide-form">
    <h2>My Bookings</h2>

    <?php if (isset($_SESSION["popup"])): ?>
        <div class="flash-message flash-blue">
            <?= escape($_SESSION["popup"]); unset($_SESSION["popup"]); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($bookings)): ?>
        <p class="center-text">You haven't made any bookings yet.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th><th>Car</th><th>Start</th><th>End</th><th>Total (€)</th><th>Status</th><th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= escape($b["bookingID"]) ?></td>
                    <td><?= escape($b["make"] . " " . $b["model"]) ?></td>
                    <td><?= escape($b["startDate"]) ?></td>
                    <td><?= escape($b["endDate"]) ?></td>
                    <td>€<?= number_format($b["totalCost"], 2) ?></td>
                    <td><?= escape($b["status"]) ?></td>
                    <td>
                        <?php if ($b["status"] !== "Cancelled"): ?>
                            <a href="cancelBooking.php?id=<?= escape($b["bookingID"]) ?>" class="cancel-link"
                               onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a>
                        <?php else: ?>
                            <span class="muted">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="dashboard.php" class="btn">← Back to Dashboard</a>
</main>

<?php require_once "../includes/footer.php"; ?>