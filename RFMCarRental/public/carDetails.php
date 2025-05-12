<?php
require_once "../includes/header.php";
require_once "../src/db_connect.php";
require_once "../src/common.php";
require_once "../classes/Car.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p class='error center-text'>Car not found.</p>";
    require_once "../includes/footer.php";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM cars WHERE carID = :id");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "<p class='error center-text'>Car not found.</p>";
    require_once "../includes/footer.php";
    exit;
}

$car = new Car(
    $row['make'],
    $row['model'],
    $row['year'],
    $row['registrationNumber'] ?? '',
    $row['rentalPrice'],
    $row['availabilityStatus'] == 0,
    $row['image'] ?? '',
    $row['description'] ?? ''
);
?>

<main class="centered-container">
    <img src="/images/<?= escape($car->getImage()) ?>"
         alt="<?= escape($car->getMake() . ' ' . $car->getModel()) ?>"
         class="car-image-full">

    <h2 class="center-text"><?= escape($car->getMake() . ' ' . $car->getModel()) ?></h2>

    <p class="center-text"><strong>Year:</strong> <?= escape($car->getYear()) ?></p>
    <p class="center-text"><strong>Price per day:</strong> €<?= escape(number_format($car->getRentalPrice(), 2)) ?></p>
    <p class="center-text"><strong>Status:</strong> <?= $car->getAvailabilityStatus() ? 'Available' : 'Rented' ?></p>

    <p class="center-text top-margin">
        <strong>Description:</strong><br><?= escape($car->getDescription()) ?>
    </p>

    <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
        <div class="center-text top-margin">
            <button disabled class="btn <?= $car->getAvailabilityStatus() ? 'btn-success' : 'btn-danger' ?>">
                This car is currently <?= $car->getAvailabilityStatus() ? 'available' : 'being rented' ?>.
            </button>
        </div>
    <?php else: ?>
        <div class="center-text top-margin">
            <?php if ($car->getAvailabilityStatus()): ?>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="login.php?login_required=1" class="btn">Book This Car</a>
                <?php else: ?>
                    <a href="/public/checkout.php?car_id=<?= escape($id) ?>" class="btn">Book This Car</a>
                <?php endif; ?>
            <?php else: ?>
                <button disabled class="btn btn-danger">This car is currently being rented.</button>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="center-text top-margin">
        <a href="cars.php" class="btn">&larr; Back to Cars</a>
    </div>
</main>

<?php require_once "../includes/footer.php"; ?>