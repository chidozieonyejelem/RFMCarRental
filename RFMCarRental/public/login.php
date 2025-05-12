<?php

require_once "../includes/header.php";
require_once "../src/config.php";
require_once "../src/db_connect.php";
require_once "../src/common.php";
require_once "../classes/User.php";
require_once "../classes/UserManager.php";

if (isset($_SESSION['popup'])) {
    echo "<script>alert('" . escape($_SESSION['popup']) . "');</script>";
    unset($_SESSION['popup']);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = escape($_POST['email'] ?? '');
    $password = escape($_POST['password'] ?? '');

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            $user = new User(
                $userData['name'],
                $userData['email'],
                $userData['password'],
                $userData['phoneNumber'],
                $userData['isAdmin']
            );

            $_SESSION['user_id'] = $userData['userID'];
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['isAdmin'] = $user->isAdmin();

            $redirect = $user->isAdmin() ? "/public/admin/dashboard.php" : "/public/dashboard.php";
            header("Location: $redirect");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "Login error: " . escape($e->getMessage());
    }
}
?>

<main class="form-container">
    <?php if (isset($_GET['login_required'])): ?>
        <script>alert("Please login to continue.");</script>
    <?php endif; ?>

    <h1>Login</h1>

    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required placeholder="youremail@gmail.com">

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required placeholder="Password">

        <button type="submit" class="btn">Login</button>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </form>
</main>

<?php require_once "../includes/footer.php"; ?>