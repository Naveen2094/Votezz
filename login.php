<?php
session_start();
include 'db_connect.php'; // Ensure this file correctly establishes a database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure all fields are set before accessing them
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';

    if (empty($username) || empty($password) || empty($mobile)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Check if Admin
        if ($username === "naveen" && $password === "123" && $mobile === "8667263491") {
            $_SESSION['admin'] = true;
            header("Location: admin.php");
            exit();
        }

        // Check Normal User in Database
        $query = "SELECT * FROM users WHERE NAME = ? AND mobile = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $mobile);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['PASSWORD'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['NAME'];
            header("Location: voting.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Votezz</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .login-container {
            background-color: red;
            padding: 20px;
            width: 300px;
            margin: 100px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px white;
        }
        input {
            display: block;
            width: 90%;
            padding: 10px;
            margin: 10px auto;
            border: none;
            border-radius: 5px;
        }
        button {
            width: 95%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="mobile" placeholder="Mobile Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
