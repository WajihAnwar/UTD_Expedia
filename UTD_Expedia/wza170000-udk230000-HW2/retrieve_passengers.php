<?php
// Start the session
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

header('Content-Type: application/json');

// Check if flight_booking_id is provided
if (isset($_POST['flight_booking_id']) && !empty($_POST['flight_booking_id'])) {
    $flight_booking_id = $_POST['flight_booking_id'];

    // Query to fetch passengers for the given flight_booking_id
    $query = "
        SELECT 
            p.ssn,
            p.first_name, 
            p.last_name, 
            p.category
        FROM 
            tickets t 
        INNER JOIN 
            passenger p 
        ON 
            t.ssn = p.ssn 
        WHERE 
            t.flight_booking_id = ?
    ";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $flight_booking_id); // Bind the flight_booking_id parameter

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $passengers = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $passengers[] = [
                        'ssn' => $row['ssn'], // Include SSN
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'category' => $row['category'],
                    ];
                }

                // Return the passengers as JSON
                echo json_encode($passengers);
            } else {
                echo json_encode(['error' => 'No passengers found for the given Flight Booking ID.']);
            }
        } else {
            echo json_encode(['error' => 'Error executing query.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error preparing query.']);
    }
} else {
    echo json_encode(['error' => 'Flight Booking ID is required.']);
}

// Close the database connection
$conn->close();
?>
