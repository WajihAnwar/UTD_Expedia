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
        fb.total_price
    FROM flight_booking fb
    JOIN flights f ON fb.flight_id = f.flight_id
    ORDER BY fb.total_price DESC
    LIMIT 1
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    $flight = $result->fetch_assoc();
    echo json_encode($flight); 
} else {
    
    echo json_encode(['error' => 'No expensive flights found.']);
}


$conn->close();
?>
