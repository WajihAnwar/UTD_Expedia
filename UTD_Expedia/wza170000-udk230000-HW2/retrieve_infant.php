<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// SQL query to get the most expensive flight booking with an infant
$sql = "
    SELECT DISTINCT fb.flight_booking_id, f.flight_id, f.origin, f.destination, f.departure_date, 
                    f.arrival_date, f.departure_time, f.arrival_time, f.available_seats, f.price, fb.total_price
    FROM flight_booking fb
    JOIN tickets t ON fb.flight_booking_id = t.flight_booking_id
    JOIN passenger p ON t.ssn = p.ssn
    JOIN flights f ON fb.flight_id = f.flight_id
    WHERE p.category = 'infant'
    ORDER BY fb.total_price DESC
    LIMIT 1;
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'SQL Error: ' . $conn->error]);
    $conn->close();
    exit;
}

if ($result->num_rows > 0) {

    $flight = $result->fetch_assoc();
    echo json_encode($flight); 
} else {

    echo json_encode(['error' => 'No flights with infants found.']);
}


$conn->close();
?>
