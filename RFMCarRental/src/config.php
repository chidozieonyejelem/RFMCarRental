<?php
$host = "localhost";
$port = "3307";
$username = "root";
$password = "";
$dbname = "RFMCarRental";

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];