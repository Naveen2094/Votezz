<?php
$host = "localhost";  // Server name
$user = "root";       // Default XAMPP username
$pass = "";           // Default XAMPP password (empty)
$dbname = "votezz_db"; // Your database name

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check if connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
