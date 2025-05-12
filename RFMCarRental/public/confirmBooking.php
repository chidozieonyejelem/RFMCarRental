<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
require_once "../src/db_connect.php";
require_once "../src/common.php";
require_once "../classes/Booking.php";

$userID = $_SESSION['user_id'];
$carID = $_POST['carID'] ?? null;
$start = escape($_POST['start_date'] ?? '');
$end = escape($_POST['end_date'] ?? '');
$location = escape($_POST['location'] ?? '');
$total = floatval($_POST['total'] ?? 0);
$cardName = escape($_POST['card_name'] ?? '');
$cardNum = escape($_POST['card_number'] ?? '');
$expiry = escape($_POST['expiry'] ?? '');
$cvv = escape($_POST['cvv'] ?? '');
$billing = escape($_POST['billing_address'] ?? '');

$stmt = $pdo->prepare("SELECT availabilityStatus FROM cars WHERE carID = ?");
$stmt->execute([$carID]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car || $car['availabilityStatus'] != 0) {
    $_SESSION['error'] = "Selected car is unavailable.";
    header("Location: cars.php");
    exit;
}

$booking = new Booking($userID, $carID, $start, $end, $total);
$booking->confirm();

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO bookings (userID, carID, startDate, endDate, location, totalCost, status)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $booking->getCustomerID(),
        $booking->getCarID(),
        $booking->getStartDate(),
        $booking->getEndDate(),
        $location,
        $booking->getTotalCost(),
        $booking->getStatus()
    ]);

    $update = $pdo->prepare("UPDATE cars SET availabilityStatus = 1 WHERE carID = ?");
    $update->execute([$carID]);

    $pdo->commit();
    unset($_SESSION['checkout_data']);
    $_SESSION['success'] = "Booking confirmed! Thank you for choosing RF Motors.";
    header("Location: dashboard.php");
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Booking failed. Please try again.";
    header("Location: payment.php");
    exit;
}
