<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message_id"], $_POST["reply"])) {
    $reply = escape($_POST["reply"]);
    $messageID = (int) $_POST["message_id"];

    try {
        $update = $pdo->prepare("
            UPDATE messages 
            SET reply = :reply, reply_at = NOW(), replied_by = :adminID
            WHERE id = :id
        ");
        $update->execute([
            'reply' => $reply,
            'adminID' => $_SESSION['user_id'],
            'id' => $messageID
        ]);

        $_SESSION['popup'] = "Reply sent successfully!";
        header("Location: readMessage.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['popup'] = "Error replying: " . escape($e->getMessage());
    }
}

$stmt = $pdo->query("
    SELECT m.id, m.message, m.created_at, m.reply, m.reply_at, u.name AS username, u.email, a.name AS admin_name
    FROM messages m
    LEFT JOIN users u ON m.userID = u.userID
    LEFT JOIN users a ON m.replied_by = a.userID
    ORDER BY m.created_at DESC
");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="form-container wide-form">
    <h2>User Messages</h2>

    <?php if (isset($_SESSION['popup'])): ?>
        <div class="flash-message flash-success">
            <?= escape($_SESSION['popup']); unset($_SESSION['popup']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($messages)): ?>
        <p>No messages found.</p>
    <?php else: ?>
        <?php foreach ($messages as $msg): ?>
            <div class="message-card">
                <p><strong>Name:</strong> <?= escape($msg['username']) ?></p>
                <p><strong>Email:</strong> <?= escape($msg['email']) ?></p>
                <p><strong>Message:</strong> <?= escape($msg['message']) ?></p>
                <p class="timestamp">Sent on <?= escape($msg['created_at']) ?></p>

                <p><strong>Admin Reply:</strong> <?= $msg['reply'] ? escape($msg['reply']) : 'No reply yet.' ?></p>

                <?php if ($msg['reply']): ?>
                    <p class="timestamp">
                        Replied by <?= escape($msg['admin_name'] ?? 'Unknown Admin') ?> on <?= escape($msg['reply_at']) ?>
                    </p>
                <?php endif; ?>

                <form method="POST" class="reply-form">
                    <textarea name="reply" placeholder="Write a reply..." rows="2" required><?= escape($msg['reply']) ?></textarea>
                    <input type="hidden" name="message_id" value="<?= escape($msg['id']) ?>">
                    <button type="submit" class="btn btn-reply">Send Reply</button>
                </form>

                <form method="POST" action="deleteMessage.php" onsubmit="return confirm('Are you sure you want to delete this message?')" class="delete-form">
                    <input type="hidden" name="message_id" value="<?= escape($msg['id']) ?>">
                    <button type="submit" class="btn btn-danger">Delete Message</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="dashboard.php" class="btn back-btn">&larr; Back to Admin Dashboard</a>
</main>

<?php require_once "../../includes/adminFooter.php"; ?>