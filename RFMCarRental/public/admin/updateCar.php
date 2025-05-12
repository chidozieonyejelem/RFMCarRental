<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: readCar.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM cars WHERE carID = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo '<p class="center-text error">Car not found.</p>';
    require_once "../../includes/footer.php";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make   = escape($_POST['make'] ?? '');
    $model  = escape($_POST['model'] ?? '');
    $year   = (int) ($_POST['year'] ?? 0);
    $price  = (float) ($_POST['rentalPrice'] ?? 0);
    $desc   = escape($_POST['description'] ?? '');
    $status = (int) ($_POST['availabilityStatus'] ?? 0);
    $image  = $car['image'];

    if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../../images/" . $image);
    }

    try {
        $stmt = $pdo->prepare(
            "UPDATE cars SET make = :make, model = :model, year = :year,
             rentalPrice = :rentalPrice, description = :description,
             availabilityStatus = :availabilityStatus, image = :image
             WHERE carID = :id"
        );
        $stmt->execute([
            'make' => $make,
            'model' => $model,
            'year' => $year,
            'rentalPrice' => $price,
            'description' => $desc,
            'availabilityStatus' => $status,
            'image' => $image,
            'id' => $id
        ]);

        $_SESSION['popup'] = "Car updated successfully!";
        header("Location: readCar.php");
        exit;
    } catch (PDOException $e) {
        $error = "Error updating car: " . escape($e->getMessage());
    }
}
?>

<main class="form-container narrow-form">
    <h2>Edit Car</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="make">Make:</label>
        <input type="text" name="make" id="make" value="<?= escape($car['make']) ?>" required>

        <label for="model">Model:</label>
        <input type="text" name="model" id="model" value="<?= escape($car['model']) ?>" required>

        <label for="year">Year:</label>
        <input type="number" name="year" id="year" value="<?= escape($car['year']) ?>" required>

        <label for="rentalPrice">Rental Price (€):</label>
        <input type="number" step="0.01" name="rentalPrice" id="rentalPrice" value="<?= escape($car['rentalPrice']) ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4"><?= escape($car['description']) ?></textarea>

        <label for="availabilityStatus">Status:</label>
        <select name="availabilityStatus" id="availabilityStatus">
            <option value="0" <?= $car['availabilityStatus'] == 0 ? 'selected' : '' ?>>Available</option>
            <option value="1" <?= $car['availabilityStatus'] == 1 ? 'selected' : '' ?>>Rented</option>
        </select>

        <label for="image">Change Image:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <?php if (!empty($car['image'])): ?>
            <div class="top-margin center-text">
                <p>Current Image:</p>
                <img src="/images/<?= escape($car['image']) ?>" alt="Current Car Image" class="thumbnail-image">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn">Update Car</button>
    </form>

    <div class="top-margin">
        <a href="readCar.php" class="btn">&larr; Back to Manage Cars</a>
    </div>
</main>

<?php require_once "../../includes/footer.php"; ?>