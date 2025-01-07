<?php
include 'db_config.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get username from request
$username = $_GET['username'] ?? '';

if (empty($username)) {
    echo json_encode(["error" => "Username is required"]);
    exit;
}

// Prepare and execute query
$sql = "SELECT hunger, happiness, energy FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No saved game found for this user"]);
}

$stmt->close();
$conn->close();
?>