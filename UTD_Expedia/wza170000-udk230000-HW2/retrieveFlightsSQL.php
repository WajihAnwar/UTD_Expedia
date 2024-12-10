<?php
header('Content-Type: application/xml');

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

$sql = "SELECT * FROM flights";
$result = $conn->query($sql);

$xml = new SimpleXMLElement('<flights/>');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flight = $xml->addChild('flight');
        $flight->addChild('flight-id', $row['flight_id']);
        $flight->addChild('origin', $row['origin']);
        $flight->addChild('destination', $row['destination']);
        $flight->addChild('departure-date', $row['departure_date']);
        $flight->addChild('arrival-date', $row['arrival_date']);
        $flight->addChild('departure-time', $row['departure_time']);
        $flight->addChild('arrival-time', $row['arrival_time']);
        $flight->addChild('available-seats', $row['available_seats']);
        $flight->addChild('price', $row['price']);
    }
} else {
    echo "0 results";
}

$conn->close();
echo $xml->asXML();
?>
