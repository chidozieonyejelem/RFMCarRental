<?php
require_once "../../includes/adminHeader.php";
require_once "../../src/require_admin.php";
require_once "../../src/db_connect.php";
require_once "../../src/common.php";

$stmt = $pdo->query("SELECT userID, name, email, phoneNumber FROM users ORDER BY userID DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="form-container wide-form">
    <h2>Manage Users</h2>

    <?php if (isset($_SESSION['popup'])): ?>
        <div class="flash-message flash-success">
            <?= escape($_SESSION['popup']); unset($_SESSION['popup']); ?>
        </div>
    <?php endif; ?>

    <table class="data-table">
        <thead>
        <tr class="table-header">
            <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= escape($user['userID']) ?></td>
                <td><?= escape($user['name']) ?></td>
                <td><?= escape($user['email']) ?></td>
                <td><?= escape($user['phoneNumber']) ?></td>
                <td>
                    <a href="deleteUser.php?id=<?= escape($user['userID']) ?>"
                       onclick="return confirm('Are you sure you want to delete this user?');"
                       class="delete-link">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn top-margin">&larr; Back to Admin Dashboard</a>
</main>

<?php require_once "../../includes/footer.php"; ?>