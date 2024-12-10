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

$ssn = $_POST['ssn'] ?? '';

$sql = "SELECT fb.flight_booking_id, f.origin, f.destination, f.departure_date, f.arrival_date, f.departure_time, f.arrival_time, f.price AS flight_price, fb.total_price AS booking_price 
        FROM tickets t 
        JOIN flight_booking fb ON t.flight_booking_id = fb.flight_booking_id 
        JOIN flights f ON fb.flight_id = f.flight_id 
        WHERE t.ssn = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ssn);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h4>Flights booked by SSN: $ssn</h4>";
    while ($row = $result->fetch_assoc()) {
        echo "Flight Booking ID: " . $row['flight_booking_id'] . "<br>";
        echo "Origin: " . $row['origin'] . "<br>";
        echo "Destination: " . $row['destination'] . "<br>";
        echo "Departure Date: " . $row['departure_date'] . "<br>";
        echo "Arrival Date: " . $row['arrival_date'] . "<br>";
        echo "Departure Time: " . $row['departure_time'] . "<br>";
        echo "Arrival Time: " . $row['arrival_time'] . "<br>";
        echo "Flight Price: $" . $row['flight_price'] . "<br>";
        echo "Booking Price: $" . $row['booking_price'] . "<br><br>";
    }
} else {
    echo "No flights found for this SSN.";
}

$conn->close();
?>
