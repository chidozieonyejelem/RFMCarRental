<?php

if (!isset($_SESSION['user_id']) || empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: /public/login.php");
    exit;
}