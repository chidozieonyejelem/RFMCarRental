<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$bookingID = $_GET['id'] ?? null;
if (!$bookingID || !is_numeric($bookingID)) {
    $_SESSION['popup'] = "Invalid booking ID.";
    header("Location: readBooking.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE bookingID = ?");
$stmt->execute([$bookingID]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    $_SESSION['popup'] = "Booking not found.";
    header("Location: readBooking.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStart = $_POST['startDate'];
    $newEnd = $_POST['endDate'];
    $status = $_POST['status'];

    $update = $pdo->prepare("UPDATE bookings SET startDate = ?, endDate = ?, status = ? WHERE bookingID = ?");
    $update->execute([$newStart, $newEnd, $status, $bookingID]);

    if ($status === 'Cancelled') {
        $carReset = $pdo->prepare("UPDATE cars SET availabilityStatus = 0 WHERE carID = ?");
        $carReset->execute([$data['carID']]);
    }

    $_SESSION['booking_updated'] = "Booking updated successfully!";
    header("Location: readBooking.php");
    exit;
}
?>

<main class="form-container narrow-form">
    <h2>Edit Booking #<?= escape($bookingID) ?></h2>

    <form method="POST">
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" id="startDate" value="<?= escape($data['startDate']) ?>" required>

        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" id="endDate" value="<?= escape($data['endDate']) ?>" required>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Confirmed" <?= $data['status'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="Cancelled" <?= $data['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>

        <button type="submit" class="btn">Update Booking</button>
    </form>

    <div class="top-margin">
        <a href="readBooking.php" class="btn">&larr; Back to Bookings</a>
    </div>
</main>

<?php require_once "../../includes/footer.php"; ?>