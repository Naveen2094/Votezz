<?php
include 'db_connect.php';
$name = $_POST['candidate_name'];

$stmt = $conn->prepare("DELETE FROM candidates WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$stmt->close();

echo "<script>alert('Candidate removed successfully!'); window.location.href='admin_dashboard.php';</script>";
?>
