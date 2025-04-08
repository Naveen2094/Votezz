<?php
session_start();
include('db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['voter_id'])) {
    header('Location: login.php');
    exit();
}

$voter_id = $_SESSION['voter_id'];
$message = "";

// Check if the user already voted
$check_vote = $conn->prepare("SELECT candidate_id FROM votes WHERE voter_id = ?");
$check_vote->bind_param("s", $voter_id);
$check_vote->execute();
$check_vote_result = $check_vote->get_result();

$already_voted = $check_vote_result->num_rows > 0;
$voted_candidate = $already_voted ? $check_vote_result->fetch_assoc()['candidate_id'] : null;

// If vote form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['vote'])) {
    if (!$already_voted) {
        $candidate_id = $_POST['candidate_id'];

        // Insert vote
        $insert_vote = $conn->prepare("INSERT INTO votes (voter_id, candidate_id) VALUES (?, ?)");
        $insert_vote->bind_param("ss", $voter_id, $candidate_id);

        if ($insert_vote->execute()) {
            $message = "<p style='color: lightgreen;'>Your vote has been cast successfully!</p>";
            $already_voted = true;
            $voted_candidate = $candidate_id;
  // Also update the vote count in candidates table
    $update_candidate = $conn->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = ?");
    $update_candidate->bind_param("s", $candidate_id);
    $update_candidate->execute();
    $update_candidate->close();
 
        } else {
            $message = "<p style='color: red;'>Error: Unable to cast vote. Please try again.</p>";
        }
    } else {
        $message = "<p style='color: orange;'>You have already voted!</p>";
    }
}

// Fetch all candidates
$result = $conn->query("SELECT * FROM candidates");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cast Vote - Votezz</title>
    <style>
    /* Glowing Red Background Animation */
    body {
        background: linear-gradient(-45deg, #200000, #400000, #600000, #800000);
        background-size: 400% 400%;
        animation: gradientBG 8s ease infinite;
        height: 100vh;
        color: white;
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    h2 {
        color: white;
        margin-top: 20px;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #111;
    }

    th, td {
        border: 1px solid red;
        padding: 12px;
    }

    th {
        background-color: #000;
        color: red;
    }

    .vote-btn {
        background-color: red;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        font-weight: bold;
    }

    .vote-btn[disabled] {
        background-color: gray;
        cursor: not-allowed;
    }

    .msg {
        font-size: 18px;
        margin-top: 20px;
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
    font-weight: bold;
    box-shadow: 0 0 10px red;
    transition: background-color 0.3s ease;
}
.logout:hover {
    background-color: darkred;
}

</style>

</head>
<body>
<a href="login.php" class="logout">Logout</a>

    <h2>Cast Your Vote</h2>

    <div class="msg"><?= $message ?></div>

    <table>
        <tr>
            <th>Candidate ID</th>
            <th>Name</th>
            <th>Party</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['party']) ?></td>
            <td>
                <?php if (!$already_voted): ?>
                    <form method="post" action="">
                        <input type="hidden" name="candidate_id" value="<?= htmlspecialchars($row['id']) ?>">
                        <button type="submit" name="vote" class="vote-btn">Vote</button>
                    </form>
                <?php elseif ($voted_candidate === $row['id']): ?>
                    <span style="color: lightgreen;">Voted</span>
                <?php else: ?>
                    <button class="vote-btn" disabled>Vote</button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
