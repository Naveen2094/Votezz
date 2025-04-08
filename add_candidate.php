<?php
require 'db_connect.php';

$candidate_id = $_POST['candidate_id'];
$name = $_POST['name'];
$party = $_POST['party'];

// Check if candidate_id already exists
$stmt = $conn->prepare("SELECT * FROM candidates WHERE candidate_id = ?");
$stmt->bind_param("s", $candidate_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Candidate ID already exists!";
    exit();
}

// Insert candidate
$stmt = $conn->prepare("INSERT INTO candidates (candidate_id, name, party) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $candidate_id, $name, $party);
$stmt->execute();

header("Location: admin.php");
exit();
?>
