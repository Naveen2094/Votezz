<?php
session_start();
include 'db_connect.php';

// Check if the user is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php?error=Unauthorized access");
    exit();
}

// Fetch candidates and votes
$result = mysqli_query($conn, "SELECT * FROM candidates");
$candidates = [];
while ($row = mysqli_fetch_assoc($result)) {
    $candidates[] = $row;
}

// Convert data to JSON for JavaScript
$names_json = json_encode(array_column($candidates, 'name'));
$votes_json = json_encode(array_column($candidates, 'votes'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
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

    <h2>Voting Results</h2>
    <div class="chart-container">
        <canvas id="voteChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('voteChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= $names_json ?>,
                datasets: [{
                    label: 'Votes',
                    data: <?= $votes_json ?>,
                    backgroundColor: ['blue', 'green', 'orange', 'purple', 'yellow'],
                    borderColor: 'black',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 10,
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
