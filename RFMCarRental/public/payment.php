<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
require_once "../src/common.php";
require_once "../src/db_connect.php";
require_once "../classes/Booking.php";

$checkout = $_SESSION["checkout_data"] ?? null;
if (!$checkout || !isset($checkout["carID"], $checkout["start_date"], $checkout["end_date"], $checkout["location"])) {
    echo "<p class='error'>Missing rental details.</p>";
    require_once "../includes/footer.php";
    exit;
}

$carID = $checkout["carID"];
$start = $checkout["start_date"];
$end = $checkout["end_date"];
$location = $checkout["location"];

$stmt = $pdo->prepare("SELECT make, model, rentalPrice FROM cars WHERE carID = ?");
$stmt->execute([$carID]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo "<p class='error'>Car not found.</p>";
    require_once "../includes/footer.php";
    exit;
}

$booking = new Booking(null, null, $start, $end, 0);
$total = $booking->calculateTotalCost($car["rentalPrice"]);
?>

<main class="form-container narrow-form">
    <h2>Confirm Booking for <?= escape($car["make"] . " " . $car["model"]) ?></h2>

    <div class="booking-summary">
        <p><strong>Rental Period:</strong> <?= escape($start) ?> ➔ <?= escape($end) ?></p>
        <p><strong>Pickup Location:</strong> <?= escape($location) ?></p>
        <p><strong>Price per Day:</strong> €<?= number_format($car["rentalPrice"], 2) ?></p>
        <p class="total-cost"><strong>Total Cost:</strong> €<?= number_format($total, 2) ?></p>
    </div>

    <?php if (isset($_SESSION["error"])): ?>
        <p class="error"><?= escape($_SESSION["error"]); unset($_SESSION["error"]); ?></p>
    <?php endif; ?>

    <form method="POST" action="confirmBooking.php">
        <input type="hidden" name="carID" value="<?= escape($carID) ?>">
        <input type="hidden" name="start_date" value="<?= escape($start) ?>">
        <input type="hidden" name="end_date" value="<?= escape($end) ?>">
        <input type="hidden" name="location" value="<?= escape($location) ?>">
        <input type="hidden" name="total" value="<?= escape($total) ?>">

        <label for="card_name">Name on Card:</label>
        <input type="text" name="card_name" id="card_name" required>

        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" id="card_number" maxlength="19" required>

        <label for="expiry">Expiry Date:</label>
        <input type="month" name="expiry" id="expiry" required>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" id="cvv" maxlength="4" required>

        <label for="billing_address">Billing Address:</label>
        <input type="text" name="billing_address" id="billing_address" required>

        <button type="submit" class="btn">Pay Now</button>
    </form>
</main>

<?php require_once "../includes/footer.php"; ?>