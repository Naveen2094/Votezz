<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Votezz</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login_process.php" method="POST" onsubmit="return validateLoginForm()">
    <input type="text" name="name" id="name" placeholder="Enter your Name" required>
    <input type="text" name="voter_id" id="voter_id" placeholder="Enter your Voter ID" required>
    <input type="password" name="password" id="password" placeholder="Enter your Password" required>
    <button type="submit" class="btn">Login</button>
</form>

    </div>

</body>
</html>
