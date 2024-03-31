<?php
ob_start(); // Turns on output buffering
session_start();

date_default_timezone_set("India/Kolkata");

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $con = new PDO("mysql:dbname=mkplay;host=localhost", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    // Handle connection errors gracefully
    // You might want to log the error instead of displaying it directly to users
    exit("Connection failed: " . $e->getMessage());
}
?>
