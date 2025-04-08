<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $age = $_POST['age'];
    $voter_id = $_POST['voter_id']; // Get voter ID from input
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href='register.php';</script>";
        exit();
    }

    // Validate Voter ID (exactly 10 characters)
    if (strlen($voter_id) !== 10) {
        echo "<script>alert('Voter ID must be exactly 10 characters!'); window.location.href='register.php';</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if voter ID already exists
    $check_query = $conn->prepare("SELECT * FROM users WHERE voter_id = ?");
    $check_query->bind_param("s", $voter_id);
    $check_query->execute();
    $check_result = $check_query->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('This Voter ID is already registered!'); window.location.href='register.php';</script>";
        exit();
    }

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (name, mobile, age, voter_id, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $mobile, $age, $voter_id, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed! Try again.'); window.location.href='register.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
