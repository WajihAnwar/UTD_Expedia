<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the most expensive flight booking
$sql = "SELECT hb.hotel_booking_id, h.hotel_id, h.hotel_name, h.city, hb.check_in_date, hb.check_out_date, hb.number_of_rooms, hb.price_per_night, hb.total_price
FROM hotel_booking hb
JOIN hotels h ON hb.hotel_id = h.hotel_id
ORDER BY hb.total_price DESC
LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    $flight = $result->fetch_assoc();
    echo json_encode($flight); 
} else {

    echo json_encode(['error' => 'No expensive flights found.']);
}

$conn->close();
?>