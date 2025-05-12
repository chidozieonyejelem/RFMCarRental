<?php
require_once "../includes/header.php";
require_once "../src/require_user.php";
require_once "../src/common.php";
require_once "../src/db_connect.php";

$name = $_SESSION['name'] ?? '';
$email = $_SESSION['email'] ?? '';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = escape($_POST['name'] ?? '');
    $email = escape($_POST['email'] ?? '');
    $message = escape($_POST['message'] ?? '');

    if ($name && $email && $message) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (userID, name, email, message) VALUES (:userID, :name, :email, :message)");
            $stmt->execute([
                'userID' => $_SESSION['user_id'],
                'name' => $name,
                'email' => $email,
                'message' => $message
            ]);

            $_SESSION['popup'] = "Your message has been sent successfully!";
            header("Location: contact.php");
            exit;
        } catch (PDOException $e) {
            $error = "Failed to send message: " . escape($e->getMessage());
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<main class="form-container">
    <h1>Contact Us</h1>

    <?php if (!empty($_SESSION['popup'])): ?>
        <div class="flash-success">
            <?= escape($_SESSION['popup']); unset($_SESSION['popup']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= escape($name) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= escape($email) ?>" required>

        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="5" required><?= escape($message) ?></textarea>

        <button type="submit" class="btn">Send Message</button>
    </form>
</main>

<?php require_once "../includes/footer.php"; ?>