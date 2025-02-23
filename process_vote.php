<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['candidate_id'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "You must be logged in to vote.";
        header("Location: voting.php");
        exit();
    }

    $candidate_id = intval($_POST['candidate_id']);
    $user_id = intval($_SESSION['user_id']);

    // Debugging: Check if candidate ID is received
    error_log("Candidate ID received: " . $candidate_id);

    // Check if the user has already voted
    $stmt = $conn->prepare("SELECT * FROM votes WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "You have already voted!";
    } else {
        // Update vote count in the candidates table
        $update_stmt = $conn->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = ?");
        $update_stmt->bind_param("i", $candidate_id);
        if ($update_stmt->execute()) {
            // Insert vote record to prevent multiple voting
            $insert_stmt = $conn->prepare("INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)");
            $insert_stmt->bind_param("ii", $user_id, $candidate_id);
            $insert_stmt->execute();

            $_SESSION['success_message'] = "Vote cast successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to cast vote.";
        }
    }
} else {
    $_SESSION['error_message'] = "Invalid vote request.";
}

// Redirect to voting page
header("Location: voting.php");
exit();
?>
