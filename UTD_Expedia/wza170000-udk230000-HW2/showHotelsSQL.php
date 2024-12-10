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


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}


$sql = "SELECT * FROM hotels";
$result = $conn->query($sql);

$hotels = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hotels[] = $row;
    }
}

$conn->close();


echo json_encode($hotels);
?>
