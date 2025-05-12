<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$userID = $_GET['id'] ?? null;

if ($userID && is_numeric($userID)) {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE userID = :id");
        $stmt->execute(['id' => $userID]);

        $_SESSION['popup'] = "User deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['popup'] = "Error deleting user: " . escape($e->getMessage());
    }
} else {
    $_SESSION['popup'] = "Invalid user ID.";
}

header("Location: readUser.php");
exit;