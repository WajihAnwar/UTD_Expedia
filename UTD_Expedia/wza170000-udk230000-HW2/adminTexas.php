<?php
session_start();
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

// Define Texas cities
$texas_cities = ["Austin", "Dallas", "Houston", "San Antonio", "El Paso"];

// Create placeholders for prepared statement
$placeholders = implode(',', array_fill(0, count($texas_cities), '?'));

// Define the query to get booked flights for September 2024 that originate from Texas cities but do not return to Texas cities
$flight_query = "SELECT fb.flight_booking_id, f.flight_id, f.origin, f.destination, f.departure_date, f.arrival_date, f.departure_time, f.arrival_time, f.price
                 FROM flight_booking fb
                 JOIN flights f ON fb.flight_id = f.flight_id
                 WHERE f.departure_date BETWEEN '2024-09-01' AND '2024-09-30'
                 AND f.origin IN ($placeholders) 
                 AND f.destination NOT IN ($placeholders)";

// Define the query to get booked hotels in Texas for September 2024
$hotel_query = "SELECT hb.hotel_booking_id, h.hotel_id, h.hotel_name, h.city, hb.check_in_date, hb.check_out_date, hb.number_of_rooms, hb.price_per_night, hb.total_price
                FROM hotel_booking hb
                JOIN hotels h ON hb.hotel_id = h.hotel_id
                WHERE hb.check_in_date BETWEEN '2024-09-01' AND '2024-09-30'
                AND h.city IN ($placeholders)";

// Prepare and execute flight query
$stmt = $conn->prepare($flight_query);
$stmt->bind_param(str_repeat('s', count($texas_cities) * 2), ...$texas_cities, ...$texas_cities);
$stmt->execute();
$flight_result = $stmt->get_result();

// Display flight bookings
echo "<h4>Flights Booked in September 2024 (From Texas Cities, Excluding Returns)</h4>";
if ($flight_result->num_rows > 0) {
    while ($row = $flight_result->fetch_assoc()) {
        echo "Flight Booking ID: " . $row['flight_booking_id'] . "<br>";
        echo "Flight ID: " . $row['flight_id'] . "<br>";
        echo "Origin: " . $row['origin'] . "<br>";
        echo "Destination: " . $row['destination'] . "<br>";
        echo "Departure Date: " . $row['departure_date'] . "<br>";
        echo "Arrival Date: " . $row['arrival_date'] . "<br>";
        echo "Departure Time: " . $row['departure_time'] . "<br>";
        echo "Arrival Time: " . $row['arrival_time'] . "<br>";
        echo "Price: $" . $row['price'] . "<br><br>";
    }
} else {
    echo "No flights booked from Texas cities (excluding returns) in September 2024.";
}

// Prepare and execute hotel query
$stmt = $conn->prepare($hotel_query);
$stmt->bind_param(str_repeat('s', count($texas_cities)), ...$texas_cities);
$stmt->execute();
$hotel_result = $stmt->get_result();

// Display hotel bookings
echo "<h4>Hotels Booked in September 2024 (In Texas Cities)</h4>";
if ($hotel_result->num_rows > 0) {
    while ($row = $hotel_result->fetch_assoc()) {
        echo "Hotel Booking ID: " . $row['hotel_booking_id'] . "<br>";
        echo "Hotel ID: " . $row['hotel_id'] . "<br>";
        echo "Hotel Name: " . $row['hotel_name'] . "<br>";
        echo "City: " . $row['city'] . "<br>";
        echo "Check-in Date: " . $row['check_in_date'] . "<br>";
        echo "Check-out Date: " . $row['check_out_date'] . "<br>";
        echo "Number of Rooms: " . $row['number_of_rooms'] . "<br>";
        echo "Price per Night: $" . $row['price_per_night'] . "<br>";
        echo "Total Price: $" . $row['total_price'] . "<br><br>";
    }
} else {
    echo "No hotels booked in Texas cities in September 2024.";
}

$conn->close();
?>
