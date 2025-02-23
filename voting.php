<?php
session_start();
include("db_connect.php"); // Ensure you have this file for DB connection

// Fetch candidates from the database
$query = "SELECT * FROM candidates";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote for a Candidate</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            text-align: center;
            color: white;
        }

        .vote-container {
            background-color: #e60000;
            color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.5);
            text-align: center;
            max-width: 400px;
            margin: 50px auto;
        }

        .candidate {
            margin: 15px 0;
            font-size: 18px;
        }

        .vote-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .vote-btn:hover {
            background-color: white;
            color: black;
            box-shadow: 0 0 10px white;
        }

        .error-msg {
            color: yellow;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="vote-container">
    <h2>Vote for a Candidate</h2>
    <form action="process_vote.php" method="POST">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="candidate">
                <input type="radio" name="candidate_id" value="<?= $row['id']; ?>" required>
                <?= htmlspecialchars($row['name']); ?>
                <?php if (isset($row['party'])) { ?>
                    (<?= htmlspecialchars($row['party']); ?>)
                <?php } ?>
            </div>
        <?php } ?>

        <button type="submit" class="vote-btn">Vote</button>
    </form>

    <?php
    // Check for errors and display messages
    if (isset($_SESSION['error_message'])) {
        echo "<div class='error-msg'>" . $_SESSION['error_message'] . "</div>";
        unset($_SESSION['error_message']); // Clear message after displaying
    }
    ?>
</div>

</body>
</html>
