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

// Get the flight_booking_id from POST data
$flight_booking_id = $_POST['flight_booking_id'] ?? '';

if (empty($flight_booking_id)) {
    echo json_encode(['error' => 'Flight booking ID is required.']);
    $conn->close();
    exit;
}

// SQL query to retrieve flight booking information
$sql = "
    SELECT fb.flight_booking_id, f.flight_id, f.origin, f.destination, f.departure_date, 
           f.arrival_date, f.departure_time, f.arrival_time, f.price, fb.total_price
    FROM flight_booking fb
    JOIN flights f ON fb.flight_id = f.flight_id
    WHERE fb.flight_booking_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $flight_booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'No flights found for the provided booking ID.']);
}

$stmt->close();
$conn->close();
?>
