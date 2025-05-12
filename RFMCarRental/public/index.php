<?php

require_once "../src/db_connect.php";
require_once "../src/common.php";
require_once "../includes/header.php";

$sql = "SELECT * FROM cars WHERE image IS NOT NULL AND image != '' LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$car = $stmt->fetch(PDO::FETCH_ASSOC);
?>

    <div class="welcome-wrapper">
        <div class="welcome-section">
            <div class="welcome-content">
                <h1>Welcome to RF Motors</h1>
                <p>Your journey begins here. Find the perfect car, at the perfect price.</p>
                <a href="cars.php" class="btn">Rent Now</a>
            </div>

            <?php if ($car): ?>
                <div class="featured-image">
                    <img src="/images/<?= escape($car['image']); ?>"
                         alt="<?= escape($car['make'] . ' ' . $car['model']); ?>">
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php require_once "../includes/footer.php"; ?>