<?php
session_start();

// Check if user is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    echo json_encode(["error" => "Unauthorized access."]);
    exit;
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Fetch all flights
$sql = "SELECT * FROM flights";
$result = $conn->query($sql);

$flights = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
}

$conn->close();

// Return the flights as JSON
echo json_encode($flights);
?>
