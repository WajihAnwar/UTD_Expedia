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
    die("Connection failed: " . $conn->connect_error);
}

// Query to get flights with at least 1 infant and 2 children
$sql = "
    SELECT 
        fb.flight_booking_id, 
        f.flight_id, 
        f.origin, 
        f.destination, 
        f.departure_date, 
        f.arrival_date, 
        f.departure_time, 
        f.arrival_time, 
        f.available_seats, 
        f.price, 
        fb.total_price,
        SUM(CASE WHEN p.category = 'infant' THEN 1 ELSE 0 END) AS infant_count,
        SUM(CASE WHEN p.category = 'child' THEN 1 ELSE 0 END) AS child_count
    FROM flight_booking fb
    JOIN tickets t ON fb.flight_booking_id = t.flight_booking_id
    JOIN passenger p ON t.ssn = p.ssn
    JOIN flights f ON fb.flight_id = f.flight_id
    GROUP BY fb.flight_booking_id, f.flight_id, f.origin, f.destination, f.departure_date, 
             f.arrival_date, f.departure_time, f.arrival_time, f.available_seats, f.price, fb.total_price
    HAVING infant_count >= 1 AND child_count >= 2;  
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $flights = [];
    while ($row = $result->fetch_assoc()) {
        // Ensure at least 1 infant and 2 children exist
        if ($row['infant_count'] >= 1 && $row['child_count'] >= 2) {
            $flights[] = $row;
        }
    }

    // Return results as JSON
    echo json_encode($flights); 
} else {
    // No matching flights found
    echo json_encode(['error' => 'No flights found with at least 1 infant and 2 children.']);
}

$conn->close();
?>
