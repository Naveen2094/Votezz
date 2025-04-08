<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {    header("Location: login.php");
    exit();
}

// Add Candidate
if (isset($_POST['add_candidate'])) {
    $id = $_POST['candidate_id'];
    $name = $_POST['candidate_name'];
    $party = $_POST['party_name'];
    $insert = "INSERT INTO candidates (id, name, party, votes) VALUES ('$id', '$name', '$party', 0)";
    mysqli_query($conn, $insert);
}

// Remove Candidate
if (isset($_POST['remove_candidate'])) {
    $id = $_POST['remove_id'];
    mysqli_query($conn, "DELETE FROM candidates WHERE id='$id'");
}

// Fetch Candidates
$candidate_result = mysqli_query($conn, "SELECT * FROM candidates");
$candidates = [];
while ($row = mysqli_fetch_assoc($candidate_result)) {
    $candidates[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Manage Candidates</title>
    <style>
    /* Background Animation */
    body {
        background: linear-gradient(-45deg, #200000, #400000, #600000, #800000);
        background-size: 400% 400%;
        animation: gradientBG 8s ease infinite;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
        color: white;
        text-align: center;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    h2 {
        margin-top: 20px;
    }

    input, button {
        padding: 8px;
        margin: 5px;
        border: none;
        border-radius: 5px;
    }

    input {
        width: 150px;
    }

    button, .remove-btn {
        background-color: red;
        color: white;
        cursor: pointer;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #111;
    }

    th, td {
        padding: 12px;
        border: 1px solid red;
    }

    th {
        background-color: black;
        color: red;
    }

    td {
        color: white;
    }

    canvas {
        margin: 30px auto;
        display: block;
        max-width: 80%;
    }

    .logout {
        position: fixed;
        top: 10px;
        right: 10px;
        background-color: red;
        padding: 5px 10px;
        border-radius: 5px;
        color: white;
        text-decoration: none;
    }

</style>

</head>
<body>

<a class="logout" href="logout.php">Logout</a>

<h2>Admin Panel - Manage Candidates</h2>

<form method="POST">
    <input type="text" name="candidate_id" placeholder="Candidate ID" required>
    <input type="text" name="candidate_name" placeholder="Candidate Name" required>
    <input type="text" name="party_name" placeholder="Party Name" required>
    <button type="submit" name="add_candidate">Add Candidate</button>
</form>

<table>
    <tr>
        <th>Candidate ID</th>
        <th>Candidate Name</th>
        <th>Party</th>
        <th>Votes</th>
        <th>Action</th>
    </tr>
    <?php foreach ($candidates as $candidate): ?>
    <tr>
        <td><?php echo $candidate['id']; ?></td>
        <td><?php echo $candidate['name']; ?></td>
        <td><?php echo $candidate['party']; ?></td>
        <td><?php echo $candidate['votes']; ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="remove_id" value="<?php echo $candidate['id']; ?>">
                <button class="remove-btn" type="submit" name="remove_candidate">Remove</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Vote Count Chart</h2>
<canvas id="voteChart" width="600" height="300"></canvas>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('voteChart').getContext('2d');

    const candidates = <?php echo json_encode($candidates); ?>;
    const names = candidates.map(c => c.name);
    const votes = candidates.map(c => parseInt(c.votes));

    const maxVotes = Math.max(...votes);
    const leaderIndex = votes.indexOf(maxVotes);
    const barColors = votes.map((v, i) => i === leaderIndex && maxVotes > 0 ? 'green' : 'red');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: names,
            datasets: [{
                label: 'Votes',
                data: votes,
                backgroundColor: barColors,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: 'white' }
                },
                x: {
                    ticks: { color: 'white' }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                }
            }
        }
    });
</script>

</body>
</html>
