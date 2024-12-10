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


$flight_query = "SELECT fb.flight_booking_id, f.flight_id, f.origin, f.destination, f.departure_date, f.arrival_date, f.departure_time, f.arrival_time, f.price
                 FROM flight_booking fb
                 JOIN flights f ON fb.flight_id = f.flight_id
                 WHERE f.departure_date BETWEEN '2024-09-01' AND '2024-09-30'";

$hotel_query = "SELECT hb.hotel_booking_id, h.hotel_id, h.hotel_name, h.city, hb.check_in_date, hb.check_out_date, hb.number_of_rooms, hb.price_per_night, hb.total_price
                FROM hotel_booking hb
                JOIN hotels h ON hb.hotel_id = h.hotel_id
                WHERE hb.check_in_date BETWEEN '2024-09-01' AND '2024-09-30'";

$flight_result = $conn->query($flight_query);


echo "<h4>Flights Booked in September 2024</h4>";
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
    echo "No flights booked in September 2024.";
}


$hotel_result = $conn->query($hotel_query);


echo "<h4>Hotels Booked in September 2024</h4>";
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
    echo "No hotels booked in September 2024.";
}

$conn->close();
?>
