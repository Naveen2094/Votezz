<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Votezz</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="register-container">
        <h2>Register for <span class="highlight">Votezz</span></h2>
        <form action="register_process.php" method="POST" onsubmit="return validateForm()">
            <input type="text" name="name" id="name" placeholder="Full Name" required>
            <input type="text" name="mobile" id="mobile" placeholder="Mobile Number" required>
            <input type="number" name="age" id="age" placeholder="Age" required>
            <input type="text" name="voter_id" id="voter_id" placeholder="Enter your Original Voter ID" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
            
            <button type="submit" class="btn">Register</button>
        </form>
        
        <p class="new-user-message">Already have an account? <a href="login.php">Login</a></p>
    </div>

    <script>
        function validateForm() {
            let mobile = document.getElementById("mobile").value;
            let age = document.getElementById("age").value;
            let voterId = document.getElementById("voter_id").value;
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirm_password").value;

            // Mobile number validation (10-digit)
            if (!/^\d{10}$/.test(mobile)) {
                alert("Please enter a valid 10-digit mobile number.");
                return false;
            }

            // Age validation (must be 18+)
            if (age < 18) {
                alert("You must be at least 18 years old to register.");
                return false;
            }

            // Voter ID validation (must be exactly 10 characters)
            if (voterId.length !== 10) {
                alert("Voter ID must be exactly 10 characters.");
                return false;
            }

            // Password match validation
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>
