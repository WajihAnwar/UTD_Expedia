<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the hotel_booking_id from POST data
$hotel_booking_id = $_POST['hotel_booking_id'] ?? '';

if (empty($hotel_booking_id)) {
    echo json_encode(['error' => 'Hotel booking ID is required.']);
    $conn->close();
    exit;
}

// SQL query to retrieve hotel booking information
$sql = "
    SELECT hb.hotel_booking_id, h.hotel_id, h.hotel_name, h.city, hb.check_in_date, 
           hb.check_out_date, hb.number_of_rooms, hb.total_price
    FROM hotel_booking hb
    JOIN hotels h ON hb.hotel_id = h.hotel_id
    WHERE hb.hotel_booking_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hotel_booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'No hotels found for the provided booking ID.']);
}

$stmt->close();
$conn->close();
?>
