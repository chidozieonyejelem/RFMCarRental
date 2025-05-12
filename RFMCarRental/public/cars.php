<?php
require_once "../src/db_connect.php";
require_once "../src/common.php";
require_once "../includes/header.php";
require_once "../classes/Car.php";

$make = $_GET['make'] ?? '';
$model = $_GET['model'] ?? '';
$minYear = $_GET['minYear'] ?? '';
$maxYear = $_GET['maxYear'] ?? '';
$sortByPrice = isset($_GET['sortPrice']);
$onlyAvailable = isset($_GET['availableOnly']);

$sql = "SELECT * FROM cars WHERE 1";
$params = [];

if ($make) {
    $sql .= " AND make LIKE :make";
    $params[':make'] = "%$make%";
}
if ($model) {
    $sql .= " AND model LIKE :model";
    $params[':model'] = "%$model%";
}
if ($minYear) {
    $sql .= " AND year >= :minYear";
    $params[':minYear'] = $minYear;
}
if ($maxYear) {
    $sql .= " AND year <= :maxYear";
    $params[':maxYear'] = $maxYear;
}
if ($onlyAvailable) {
    $sql .= " AND availabilityStatus = 0";
}
if ($sortByPrice) {
    $sql .= " ORDER BY rentalPrice ASC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$carObjects = [];
foreach ($rows as $row) {
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
    $carObjects[] = ['carID' => $row['carID'], 'object' => $car];
}
?>

<div class="main-container">
    <div class="sidebar-wrapper">
        <a href="index.php" class="btn back-btn">&larr; Back to Home</a>

        <aside class="filter-sidebar">
            <h3>Filter Cars</h3>
            <form method="GET" id="filterForm">
                <label for="make">Make</label>
                <input type="text" name="make" id="make" placeholder="Toyota" value="<?= escape($make) ?>">

                <label for="model">Model</label>
                <input type="text" name="model" id="model" placeholder="Yaris" value="<?= escape($model) ?>">

                <label for="minYear">Min Year</label>
                <input type="number" name="minYear" id="minYear" placeholder="2005" value="<?= escape($minYear) ?>">

                <label for="maxYear">Max Year</label>
                <input type="number" name="maxYear" id="maxYear" placeholder="2025" value="<?= escape($maxYear) ?>">

                <div class="filter-checkbox">
                    <input type="checkbox" name="availableOnly" id="availableOnly" <?= $onlyAvailable ? 'checked' : '' ?>>
                    <label for="availableOnly">Show Only Available</label>
                </div>

                <div class="filter-checkbox">
                    <input type="checkbox" name="sortPrice" id="sortPrice" <?= $sortByPrice ? 'checked' : '' ?>>
                    <label for="sortPrice">Sort by Lowest Price</label>
                </div>

                <button type="submit" class="btn">Search</button>
                <button type="button" class="btn clear-btn" onclick="window.location.href='cars.php';">Clear Filters</button>
            </form>
        </aside>
    </div>

    <section class="cars-grid">
        <?php if (empty($carObjects)): ?>
            <p>No cars found matching your criteria.</p>
        <?php else: ?>
            <?php foreach ($carObjects as $carData): ?>
                <?php $car = $carData['object']; ?>
                <div class="car-card">
                    <h3><?= escape($car->getMake() . ' ' . $car->getModel()); ?></h3>
                    <p>Year: <?= escape($car->getYear()); ?></p>
                    <p>Price: €<?= escape(number_format($car->getRentalPrice(), 2)); ?> / day</p>
                    <p>Status: <?= $car->getAvailabilityStatus() ? 'Available' : 'Rented'; ?></p>
                    <?php if (!empty($car->getImage())): ?>
                        <img src="../images/<?= escape($car->getImage()); ?>" alt="<?= escape($car->getMake()); ?>">
                    <?php endif; ?>
                    <a href="carDetails.php?id=<?= $carData['carID'] ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</div>

<?php require_once "../includes/footer.php"; ?>