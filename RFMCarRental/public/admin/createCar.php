<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make   = escape($_POST['make'] ?? '');
    $model  = escape($_POST['model'] ?? '');
    $year   = (int) ($_POST['year'] ?? 0);
    $price  = (float) ($_POST['rentalPrice'] ?? 0);
    $desc   = escape($_POST['description'] ?? '');
    $status = (int) ($_POST['availabilityStatus'] ?? 0);
    $image  = $_FILES['image']['name'] ?? '';

    if (!$make || !$model || !$year || !$price) {
        $error = "Please fill in all required fields.";
    } else {
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../../images/" . $image);
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO cars (make, model, year, rentalPrice, description, availabilityStatus, image)
                VALUES (:make, :model, :year, :rentalPrice, :description, :availabilityStatus, :image)
            ");
            $stmt->execute([
                'make' => $make,
                'model' => $model,
                'year' => $year,
                'rentalPrice' => $price,
                'description' => $desc,
                'availabilityStatus' => $status,
                'image' => $image
            ]);

            $_SESSION['popup'] = "Car added successfully!";
            header("Location: readCar.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error adding car: " . escape($e->getMessage());
        }
    }
}
?>

<main class="form-container admin-wide-form">
    <h2>Add New Car</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="make">Make:</label>
        <input type="text" name="make" id="make" placeholder="Make" required>

        <label for="model">Model:</label>
        <input type="text" name="model" id="model" placeholder="Model" required>

        <label for="year">Year:</label>
        <input type="number" name="year" id="year" placeholder="Year" required>

        <label for="rentalPrice">Rental Price (€):</label>
        <input type="number" step="0.01" name="rentalPrice" id="rentalPrice" placeholder="Rental Price (€)" required>

        <label for="description">Car Description:</label>
        <textarea name="description" id="description" placeholder="Car Description" rows="4"></textarea>

        <label for="availabilityStatus">Availability:</label>
        <select name="availabilityStatus" id="availabilityStatus">
            <option value="0">Available</option>
            <option value="1">Rented</option>
        </select>

        <label for="image">Car Image:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit" class="btn">Add Car</button>
    </form>

    <a href="readCar.php" class="btn back-btn">Back to Manage Cars</a>
</main>

<?php require_once "../../includes/footer.php"; ?>