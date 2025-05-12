<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
require_once "../src/db_connect.php";
require_once "../src/common.php";

$bookingID = $_GET['id'] ?? null;
$userID = $_SESSION['user_id'];

if ($bookingID && is_numeric($bookingID)) {
    try {
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'Cancelled' WHERE bookingID = :bookingID AND userID = :userID");
        $stmt->execute([
            'bookingID' => $bookingID,
            'userID' => $userID
        ]);
        $_SESSION['popup'] = "Booking #$bookingID was successfully cancelled.";
    } catch (PDOException $e) {
        $_SESSION['popup'] = "Error cancelling booking: " . escape($e->getMessage());
    }
} else {
    $_SESSION['popup'] = "Invalid booking ID.";
}

header("Location: viewBooking.php");
exit;