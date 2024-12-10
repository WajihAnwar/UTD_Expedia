<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !$_SESSION['is_admin']) {
    die("Access denied. Admin login required.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "cs6314";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create table if it doesn't exist
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS hotels (
            hotel_id VARCHAR(10) PRIMARY KEY,
            hotel_name VARCHAR(255) NOT NULL,
            city VARCHAR(100) NOT NULL,
            available_rooms INT NOT NULL,
            check_in_date DATE NOT NULL,
            check_out_date DATE NOT NULL,
            price_per_night DECIMAL(10, 2) NOT NULL
        );
    ";
    if (!$conn->query($createTableSQL)) {
        die("Error creating table: " . $conn->error);
    }

    // Check if file is uploaded
    if (isset($_FILES['hotel_json']) && $_FILES['hotel_json']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['hotel_json']['tmp_name'];
        $jsonData = file_get_contents($fileTmpPath);
        $hotelsData = json_decode($jsonData, true);

        // Validate JSON
        if (json_last_error() === JSON_ERROR_NONE && isset($hotelsData['hotels'])) {
            $response = "";
            $stmt = $conn->prepare("
                INSERT INTO hotels (hotel_id, hotel_name, city, available_rooms, check_in_date, check_out_date, price_per_night)
                VALUES (?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    hotel_name = VALUES(hotel_name),
                    city = VALUES(city),
                    available_rooms = VALUES(available_rooms),
                    check_in_date = VALUES(check_in_date),
                    check_out_date = VALUES(check_out_date),
                    price_per_night = VALUES(price_per_night)
            ");

            //Insert
            foreach ($hotelsData['hotels'] as $hotel) {
                $stmt->bind_param(
                    "sssissd",
                    $hotel['hotel-id'],
                    $hotel['hotel-name'],
                    $hotel['city'],
                    $hotel['available-rooms'],
                    $hotel['check-in-date'],
                    $hotel['check-out-date'],
                    $hotel['price-per-night']
                );

                if ($stmt->execute()) {
                    $response .= "Hotel " . $hotel['hotel-id'] . " uploaded successfully.\n";
                } else {
                    $response .= "Error uploading hotel " . $hotel['hotel-id'] . ": " . $stmt->error . "\n";
                }
            }

            $stmt->close();
            echo nl2br($response);
        } else {
            echo "Invalid JSON format.";
        }
    } else {
        echo "Error uploading file.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
