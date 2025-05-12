<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$bookingID = $_GET['id'] ?? null;

if ($bookingID && is_numeric($bookingID)) {
    $stmt = $pdo->prepare("SELECT carID FROM bookings WHERE bookingID = ?");
    $stmt->execute([$bookingID]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($booking) {
        $reset = $pdo->prepare("UPDATE cars SET availabilityStatus = 0 WHERE carID = ?");
        $reset->execute([$booking['carID']]);

        $delete = $pdo->prepare("DELETE FROM bookings WHERE bookingID = ?");
        $delete->execute([$bookingID]);

        $_SESSION['booking_updated'] = "Booking deleted successfully!";
    }
} else {
    $_SESSION['popup'] = "Invalid booking ID.";
}

header("Location: readBooking.php");
exit;