<?php
require_once "../src/session.php";

session_start();

$session = new Session();
$session->forgetSession();