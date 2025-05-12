<?php
require_once "../includes/header.php";
require_once "../src/config.php";
require_once "../src/db_connect.php";
require_once "../src/common.php";
require_once "../classes/User.php";
require_once "../classes/UserManager.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = escape($_POST['name'] ?? '');
    $email = escape($_POST['email'] ?? '');
    $phone = escape($_POST['phoneNumber'] ?? '');
    $password = escape($_POST['password'] ?? '');

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "That email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user = new User($name, $email, $hashedPassword, $phone);

            $insert = $pdo->prepare(
                "INSERT INTO users (name, email, phoneNumber, password, isAdmin)
                 VALUES (:name, :email, :phone, :password, 0)"
            );
            $insert->execute([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'phone' => $user->getPhoneNumber(),
                'password' => $user->getPassword()
            ]);

            $_SESSION['popup'] = "Registration successful! Please log in.";
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Error signing up: " . escape($e->getMessage());
    }
}
?>

<main class="form-container">
    <h1>Register</h1>
    <?php if (!empty($error)): ?>
        <p class="error"><?= escape($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Full Name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="youremail@gmail.com" required>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" name="phoneNumber" id="phoneNumber" placeholder="1123345678" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <button type="submit" class="btn">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</main>

<?php require_once "../includes/footer.php"; ?>