<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Return Hotel data 
$sql = "SELECT hotel_id, hotel_name, city, price_per_night, check_in_date, check_out_date FROM hotels";
$result = $conn->query($sql);

$hotels = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hotels[] = [
            'hotel-id' => $row['hotel_id'],
            'hotel-name' => $row['hotel_name'],
            'city' => $row['city'],
            'price-per-night' => $row['price_per_night'],
            'check-in-date' => $row['check_in_date'],
            'check-out-date' => $row['check_out_date']
        ];
    }
    echo json_encode(['hotels' => $hotels]);
} else {
    echo json_encode(['error' => 'No hotels found']);
}

// Close the connection
$conn->close();
?>
