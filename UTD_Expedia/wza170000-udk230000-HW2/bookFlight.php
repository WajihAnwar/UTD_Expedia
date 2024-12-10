<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Start session for cumulative bookings
session_start();
if (!isset($_SESSION['bookings'])) {
    $_SESSION['bookings'] = []; 
}

// Read JSON input
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!$data) {
    error_log("JSON Decode Error: " . json_last_error_msg());
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON format.']);
    exit;
}

// Log received data
error_log("Received Data: " . print_r($data, true));

// Calculate total passengers
function calculateTotalPassengers($flight) {
    return $flight['adults'] + $flight['children'] + $flight['infants'];
}

// Update available seats
function updateAvailableSeats($conn, $flightId, $passengerCount) {
    $stmt = $conn->prepare("SELECT available_seats FROM flights WHERE flight_id = ?");
    $stmt->bind_param("s", $flightId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $currentSeats = $row['available_seats'];
        $newSeats = $currentSeats - $passengerCount;

        if ($newSeats < 0) {
            error_log("Error: Not enough available seats for flight ID $flightId");
            echo json_encode(['status' => 'error', 'message' => 'Not enough available seats.']);
            exit;
        }

        $updateStmt = $conn->prepare("UPDATE flights SET available_seats = ? WHERE flight_id = ?");
        $updateStmt->bind_param("is", $newSeats, $flightId);
        if (!$updateStmt->execute()) {
            error_log("Error updating available seats for flight ID $flightId: " . $updateStmt->error);
            die("Error updating available seats.");
        }
    }
}

// Update seats for departing and returning flights
if (isset($data['departingFlight'])) {
    $departingPassengers = calculateTotalPassengers($data['departingFlight']);
    updateAvailableSeats($conn, $data['departingFlight']['flightId'], $departingPassengers);
}

if (isset($data['returningFlight'])) {
    $returningPassengers = calculateTotalPassengers($data['returningFlight']);
    updateAvailableSeats($conn, $data['returningFlight']['flightId'], $returningPassengers);
}

// Insert departing flight booking
$departingBookingId = 'FB-' . uniqid();
$stmt = $conn->prepare("INSERT INTO flight_booking (flight_booking_id, flight_id, total_price) VALUES (?, ?, ?)");
$stmt->bind_param("ssd", $departingBookingId, $data['departingFlight']['flightId'], $data['departingFlight']['totalPrice']);
if (!$stmt->execute()) {
    error_log("Error inserting departing flight booking: " . $stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Error inserting departing flight booking.']);
    exit;
}
$data['departingFlight']['bookingId'] = $departingBookingId;

// Insert returning flight booking if applicable
$returningBookingId = null;
if (isset($data['returningFlight'])) {
    $returningBookingId = 'FB-' . uniqid();
    $stmt = $conn->prepare("INSERT INTO flight_booking (flight_booking_id, flight_id, total_price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $returningBookingId, $data['returningFlight']['flightId'], $data['returningFlight']['totalPrice']);
    if (!$stmt->execute()) {
        error_log("Error inserting returning flight booking: " . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Error inserting returning flight booking.']);
        exit;
    }
    $data['returningFlight']['bookingId'] = $returningBookingId;
}

// Insert passengers and tickets
foreach ($data['passengers'] as $passenger) {
    // Insert passenger
    $stmt = $conn->prepare("INSERT INTO passenger (ssn, first_name, last_name, dob, category) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE ssn=ssn");
    $stmt->bind_param("sssss", $passenger['ssn'], $passenger['firstName'], $passenger['lastName'], $passenger['dob'], $passenger['category']);
    if (!$stmt->execute()) {
        error_log("Error inserting passenger: " . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert passenger.']);
        exit;
    }

    // Ticket for departing flight
    $ticketId = 'TICKET-' . uniqid();
    $ticketPrice = calculateTicketPrice($passenger['category'], $data['departingFlight']['adultTicketPrice']);
    $stmt = $conn->prepare("INSERT INTO tickets (ticket_id, flight_booking_id, ssn, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $ticketId, $departingBookingId, $passenger['ssn'], $ticketPrice);
    if (!$stmt->execute()) {
        error_log("Error inserting departing ticket: " . $stmt->error);
    }

    // Ticket for returning flight
    if ($returningBookingId) {
        $ticketId = 'TICKET-' . uniqid();
        $ticketPrice = calculateTicketPrice($passenger['category'], $data['returningFlight']['adultTicketPrice']);
        $stmt = $conn->prepare("INSERT INTO tickets (ticket_id, flight_booking_id, ssn, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $ticketId, $returningBookingId, $passenger['ssn'], $ticketPrice);
        if (!$stmt->execute()) {
            error_log("Error inserting returning ticket: " . $stmt->error);
        }
    }
}

// Add the new booking to the session
$_SESSION['bookings'][] = $data;

// Return all bookings as a cumulative response
echo json_encode(['status' => 'success', 'data' => $_SESSION['bookings']]);
$conn->close();

// Calculate ticket price
function calculateTicketPrice($category, $adultPrice) {
    if ($category === 'adult') {
        return $adultPrice;
    } elseif ($category === 'child') {
        return 0.7 * $adultPrice;
    } elseif ($category === 'infant') {
        return 0.1 * $adultPrice;
    }
    return 0; // Default
}
?>
