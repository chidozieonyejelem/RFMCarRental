<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
require_once "../src/db_connect.php";
require_once "../src/common.php";

$userID = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT m.message, m.reply, m.reply_at, a.name AS admin_name, m.created_at
    FROM messages m
    LEFT JOIN users a ON m.replied_by = a.userID
    WHERE m.userID = :id
    ORDER BY m.created_at DESC
");
$stmt->execute(['id' => $userID]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="form-container" style="max-width: 800px;">
    <h2>My Sent Messages</h2>

    <?php if (isset($_SESSION['popup'])): ?>
        <div class="flash-message flash-blue">
            <?= escape($_SESSION['popup']); unset($_SESSION['popup']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($messages)): ?>
        <p>You haven't sent any messages yet.</p>
    <?php else: ?>
        <?php foreach ($messages as $msg): ?>
            <div class="message-card">
                <p><strong>Message:</strong> <?= escape($msg['message']) ?></p>
                <p class="timestamp">Sent on <?= escape($msg['created_at']) ?></p>

                <?php if ($msg['reply']): ?>
                    <p><strong>Admin Reply:</strong> <?= escape($msg['reply']) ?></p>
                    <p class="timestamp">
                        Replied by <?= escape($msg['admin_name'] ?? 'Admin') ?> on <?= escape($msg['reply_at']) ?>
                    </p>
                <?php else: ?>
                    <p><em>No reply yet from admin.</em></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="dashboard.php" class="btn">&larr; Back to Dashboard</a>
</main>

<?php require_once "../includes/footer.php"; ?>