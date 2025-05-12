<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    $_SESSION['popup'] = "Invalid car ID.";
    header("Location: readCar.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM cars WHERE carID = :id");
    $stmt->execute(['id' => $id]);

    $_SESSION['popup'] = "Car deleted successfully!";
} catch (PDOException $e) {
    $_SESSION['popup'] = "Error deleting car: " . escape($e->getMessage());
}

header("Location: readCar.php");
exit;