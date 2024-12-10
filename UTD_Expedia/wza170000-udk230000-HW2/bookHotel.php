<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "cs6314";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve JSON payload
$data = json_decode(file_get_contents('php://input'), true);


if (!$data || !isset($data['bookingDetails'], $data['guestDetails'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input data"]);
    exit;
}

$bookingDetails = $data['bookingDetails'][0];
$guestDetails = $data['guestDetails'];

// Insert into hotel_booking table
$stmt = $conn->prepare("INSERT INTO hotel_booking (hotel_booking_id, hotel_id, check_in_date, check_out_date, number_of_rooms, price_per_night, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "ssssddd",
    $bookingDetails['hotel_booking_id'],
    $bookingDetails['hotel_id'],
    $bookingDetails['check_in_date'],
    $bookingDetails['check_out_date'],
    $bookingDetails['num_rooms'],
    $bookingDetails['price_per_night'],
    $bookingDetails['total_price']
);

if (!$stmt->execute()) {
    echo json_encode(["error" => "Failed to insert hotel booking: " . $stmt->error]);
    exit;
}

// Insert each guest into guesses table
$guestStmt = $conn->prepare("INSERT INTO guesses (ssn, hotel_booking_id, first_name, last_name, date_of_birth, category) VALUES (?, ?, ?, ?, ?, ?)");
$guestStmt->bind_param("ssssss", $ssn, $hotelBookingId, $firstName, $lastName, $dob, $category);

foreach ($guestDetails as $guest) {
    $ssn = $guest['ssn'];
    $hotelBookingId = $guest['hotel_booking_id'];
    $firstName = $guest['first_name'];
    $lastName = $guest['last_name'];
    $dob = $guest['dob'];
    $category = $guest['category'];

    if (!$guestStmt->execute()) {
        echo json_encode(["error" => "Failed to insert guest: " . $guestStmt->error]);
        exit;
    }
}

// Update available rooms in hotels table
$updateStmt = $conn->prepare("UPDATE hotels SET available_rooms = available_rooms - ? WHERE hotel_id = ?");
$updateStmt->bind_param("is", $numRooms, $hotelId);
$numRooms = $bookingDetails['num_rooms'];
$hotelId = $bookingDetails['hotel_id'];

if (!$updateStmt->execute()) {
    echo json_encode(["error" => "Failed to update available rooms: " . $updateStmt->error]);
    exit;
}

echo json_encode(["success" => "Hotel booking completed successfully."]);

// Close connections
$stmt->close();
$guestStmt->close();
$updateStmt->close();
$conn->close();
?>
