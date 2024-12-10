<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !$_SESSION['is_admin']) {
    die("Access denied. Admin login required.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['flights_xml'])) {
    $file = $_FILES['flights_xml']['tmp_name'];

    if (file_exists($file)) {
        $xml = simplexml_load_file($file);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cs6314";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create the `flights` table if it doesn't exist
        $createTableSQL = "
            CREATE TABLE IF NOT EXISTS flights (
                flight_id VARCHAR(50) PRIMARY KEY,
                origin VARCHAR(100) NOT NULL,
                destination VARCHAR(100) NOT NULL,
                departure_date DATE NOT NULL,
                arrival_date DATE NOT NULL,
                departure_time TIME NOT NULL,
                arrival_time TIME NOT NULL,
                available_seats INT NOT NULL,
                price DECIMAL(10, 2) NOT NULL
            )
        ";

        if (!$conn->query($createTableSQL)) {
            die("Error creating table: " . $conn->error);
        }

        // Insert flights into the database
        foreach ($xml->flight as $flight) {
            $flight_id = $conn->real_escape_string((string)$flight->{'flight-id'});
            $origin = $conn->real_escape_string((string)$flight->origin);
            $destination = $conn->real_escape_string((string)$flight->destination);
            $departure_date = $conn->real_escape_string((string)$flight->{'departure-date'});
            $arrival_date = $conn->real_escape_string((string)$flight->{'arrival-date'});
            $departure_time = $conn->real_escape_string((string)$flight->{'departure-time'});
            $arrival_time = $conn->real_escape_string((string)$flight->{'arrival-time'});
            $available_seats = (int)$flight->{'available-seats'};
            $price = (float)$flight->price;

            $sql = "INSERT INTO flights (flight_id, origin, destination, departure_date, arrival_date, departure_time, arrival_time, available_seats, price) 
                    VALUES ('$flight_id', '$origin', '$destination', '$departure_date', '$arrival_date', '$departure_time', '$arrival_time', $available_seats, $price)";

            if (!$conn->query($sql)) {
                echo "Error inserting flight $flight_id: " . $conn->error . "<br>";
            }
        }

        echo "Flights uploaded successfully.";
        $conn->close();
    } else {
        echo "Error: File not found.";
    }
}
?>
