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

// SQL query to get flights from Texas with no infant passengers
$sql = "
    SELECT fb.flight_booking_id, f.flight_id, f.origin, f.destination, f.departure_date, 
           f.arrival_date, f.departure_time, f.arrival_time, f.available_seats, f.price, fb.total_price
    FROM flight_booking fb
    JOIN flights f ON fb.flight_id = f.flight_id
    WHERE f.origin IN ('Austin', 'Dallas', 'Houston', 'San Antonio')
      AND fb.flight_booking_id NOT IN (
          SELECT DISTINCT fb2.flight_booking_id
          FROM flight_booking fb2
          JOIN tickets t2 ON fb2.flight_booking_id = t2.flight_booking_id
          JOIN passenger p2 ON t2.ssn = p2.ssn
          WHERE p2.category = 'infant'
      )
      AND f.departure_date BETWEEN '2024-09-01' AND '2024-10-31';
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'SQL Error: ' . $conn->error]);
    $conn->close();
    exit;
}

if ($result->num_rows > 0) {
    $flights = [];
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
    echo json_encode($flights);
} else {
    echo json_encode(['error' => 'No flights from Texas without infant passengers found.']);
}

// Close the database connection
$conn->close();
?>
