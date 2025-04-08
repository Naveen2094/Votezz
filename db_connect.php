<?php
$host = "localhost"; // Change if using a remote server
$username = "root"; // Default for XAMPP
$password = ""; // Default is empty in XAMPP
$dbname = "votez2_db"; // Make sure this matches your actual database name

// Create connection
$conn = new mysqli("localhost", "root", "", "votez2_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
