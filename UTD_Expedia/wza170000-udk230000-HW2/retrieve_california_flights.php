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

// SQL query to fetch flights arriving in California in September and October 2024
$sql = "
    SELECT f.flight_id, f.origin, f.destination, f.departure_date, f.arrival_date, f.departure_time, f.arrival_time, f.price
    FROM flight_booking fb
    JOIN flights f ON fb.flight_id = f.flight_id
    WHERE f.destination IN ('Los Angeles', 'San Francisco', 'San Diego', 'Sacramento') -- Add more cities as needed
      AND f.arrival_date BETWEEN '2024-09-01' AND '2024-10-31';
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
    echo json_encode(['total_flights' => count($flights), 'flights' => $flights]);
} else {
    echo json_encode(['error' => 'No flights to California found.']);
}


$conn->close();
?>
