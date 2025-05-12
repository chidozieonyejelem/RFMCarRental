<?php

if (!isset($_SESSION['user_id']) || $_SESSION['isAdmin'] != 0) {
    header("Location: login.php");
    exit;
}