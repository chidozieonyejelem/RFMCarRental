<?php
require_once "config.php";

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    $sql = file_get_contents("../data/init.sql");
    $pdo->exec($sql);

    echo "Database and tables were successfully created!";

} catch (PDOException $e) {
    echo "Error creating the database: " . $e->getMessage();
}