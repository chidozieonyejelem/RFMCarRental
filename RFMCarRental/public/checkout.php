<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
require_once "../src/common.php";

$carID = $_GET['car_id'] ?? null;
if (!$carID) {
    echo "<p class='error'>Car not found.</p>";
    require_once "../includes/footer.php";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = escape($_POST['start_date'] ?? '');
    $end = escape($_POST['end_date'] ?? '');
    $location = escape($_POST['location'] ?? '');

    if (!$start || !$end || !$location) {
        $error = "All fields are required.";
    } else {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        $days = $startDate->diff($endDate)->days;

        $_SESSION['checkout_data'] = [
            'carID' => $carID,
            'start_date' => $start,
            'end_date' => $end,
            'location' => $location
        ];
        header("Location: payment.php");
        exit;
    }
}

$counties = [
    "Antrim", "Armagh", "Carlow", "Cavan", "Clare", "Cork", "Derry", "Donegal",
    "Down", "Dublin", "Fermanagh", "Galway", "Kerry", "Kildare", "Kilkenny", "Laois",
    "Leitrim", "Limerick", "Longford", "Louth", "Mayo", "Meath", "Monaghan",
    "Offaly", "Roscommon", "Sligo", "Tipperary", "Tyrone", "Waterford", "Westmeath",
    "Wexford", "Wicklow"
];
?>

<main class="form-container form-wide">
    <h2>Choose Your Rental Options</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required>

        <label for="location">Pick-up Location:</label>
        <select name="location" id="location" required>
            <option value="">-- Select County --</option>
            <?php foreach ($counties as $county): ?>
                <option value="<?= escape($county) ?>"><?= escape($county) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn">Continue to Payment</button>

        <div class="centered-btn">
            <a href="cars.php" class="btn">Back to Cars</a>
        </div>
    </form>
</main>

<?php require_once "../includes/footer.php"; ?>