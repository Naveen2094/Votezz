<?php
session_start();
include 'db_connect.php';

$name = $_POST['name'];
$voter_id = $_POST['voter_id'];
$password = $_POST['password'];

// Prevent SQL injection
$name = mysqli_real_escape_string($conn, $name);
$voter_id = mysqli_real_escape_string($conn, $voter_id);

// Check for admin login
if ($name === "Naveen" && $voter_id === "CXSPN9373C" && $password === "54321") {
    $_SESSION['admin'] = true;
    header("Location: admin.php");
    exit();
}

// Fetch user by voter ID and name
$sql = "SELECT * FROM users WHERE name='$name' AND voter_id='$voter_id'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verify hashed password
    if (password_verify($password, $row['password'])) {
        $_SESSION['voter_id'] = $voter_id;
        header("Location: vote.php");
        exit();
    } else {
        echo "<script>alert('Incorrect password!'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Invalid login credentials!'); window.location.href='login.php';</script>";
}

$conn->close();
?>
