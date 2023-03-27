<?php

session_start(); // Start session
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // User is not logged in, redirect to login page
    header("location: login.php");
    exit;
}
if (!isset($_SESSION["email"]) || !isset($_SESSION["drid"])) {
    // User is not logged in, redirect to login page
    header("location: login.php");
    exit;
}

?>