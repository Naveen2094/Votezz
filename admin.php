<?php
session_start();
include 'db_connect.php';

// Check if the user is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php?error=Unauthorized access");
    exit();
}

// Handle adding candidates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_candidate'])) {
    $name = mysqli_real_escape_string($conn, $_POST['candidate_name']);
    $query = "INSERT INTO candidates (name, votes) VALUES ('$name', 0)";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Candidate added successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to add candidate.";
    }
    header("Location: admin.php");
    exit();
}

// Handle removing candidates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_candidate'])) {
    $id = intval($_POST['candidate_id']);
    $query = "DELETE FROM candidates WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Candidate removed successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to remove candidate.";
    }
    header("Location: admin.php");
    exit();
}

// Fetch candidates (force fresh data)
$result = mysqli_query($conn, "SELECT * FROM candidates");
$candidates = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 60%;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: red;
        }
        input, button {
            padding: 8px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
        }
        button {
            background-color: red;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: darkred;
        }
        .delete-btn {
            background-color: darkred;
            color: white;
            padding: 5px;
            border: none;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: red;
        }
        .chart-container {
            width: 60%;
            margin: auto;
            background-color: rgba(255, 0, 0, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" style="color: red;">Logout</a>

        <h3>Candidate List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Votes</th>
                <th>Action</th>
            </tr>
            <?php foreach ($candidates as $candidate) : ?>
                <tr>
                    <td><?= $candidate['id'] ?></td>
                    <td><?= htmlspecialchars($candidate['name']) ?></td>
                    <td><?= $candidate['votes'] ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="candidate_id" value="<?= $candidate['id'] ?>">
                            <button type="submit" name="remove_candidate" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Add Candidate</h3>
        <form method="POST">
            <input type="text" name="candidate_name" placeholder="Candidate Name" required>
            <button type="submit" name="add_candidate">Add</button>
        </form>

        <h3>Vote Count</h3>
        <div class="chart-container">
            <canvas id="voteChart"></canvas>
        </div>

    </div>

    <script>
        const names = <?= json_encode(array_column($candidates, 'name')) ?>;
        const votes = <?= json_encode(array_column($candidates, 'votes')) ?>;

        const ctx = document.getElementById('voteChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: names,
                datasets: [{
                    label: 'Votes',
                    data: votes,
                    backgroundColor: 'white',
                    borderColor: 'black',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        ticks: { color: 'white' }
                    },
                    x: {
                        ticks: { color: 'white' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: 'white' }
                    }
                }
            }
        });
    </script>

</body>
</html>
