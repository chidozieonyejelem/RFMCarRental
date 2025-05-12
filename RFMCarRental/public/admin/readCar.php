<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$stmt = $pdo->query("SELECT * FROM cars ORDER BY carID DESC");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="form-container wide-form">
    <h2>Manage Cars</h2>

    <?php
    $flashTypes = [
        'car_added' => 'flash-success',
        'car_updated' => 'flash-success',
        'car_deleted' => 'flash-danger',
        'popup' => 'flash-blue'
    ];

    foreach ($flashTypes as $key => $class) {
        if (isset($_SESSION[$key])) {
            echo "<div class='flash-message $class'>" . escape($_SESSION[$key]) . "</div>";
            unset($_SESSION[$key]);
        }
    }
    ?>

    <a href="createCar.php" class="btn btn-add">+ Add New Car</a>

    <table class="data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($cars)): ?>
            <tr><td colspan="7" class="center-text">No cars found.</td></tr>
        <?php else: ?>
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= escape($car['carID']) ?></td>
                    <td><?= escape($car['make']) ?></td>
                    <td><?= escape($car['model']) ?></td>
                    <td><?= escape($car['year']) ?></td>
                    <td>€<?= number_format($car['rentalPrice'], 2) ?></td>
                    <td><?= $car['availabilityStatus'] == 0 ? 'Available' : 'Rented' ?></td>
                    <td>
                        <a href="updateCar.php?id=<?= escape($car['carID']) ?>" class="edit-link">Edit</a>
                        <a href="deleteCar.php?id=<?= escape($car['carID']) ?>" class="delete-link"
                           onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn back-btn">&larr; Back to Admin Dashboard</a>
</main>

<?php require_once "../../includes/footer.php"; ?>