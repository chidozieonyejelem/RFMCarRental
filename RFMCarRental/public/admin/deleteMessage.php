<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$messageID = $_POST['message_id'] ?? null;

if ($messageID && is_numeric($messageID)) {
    try {
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id");
        $stmt->execute(['id' => $messageID]);
        $_SESSION['popup'] = "Message deleted successfully.";
    } catch (PDOException $e) {
        $_SESSION['popup'] = "Error deleting message: " . escape($e->getMessage());
    }
} else {
    $_SESSION['popup'] = "Invalid message ID.";
}

header("Location: readMessage.php");
exit;