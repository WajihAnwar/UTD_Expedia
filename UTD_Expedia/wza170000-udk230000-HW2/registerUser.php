<?php
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

// Create `users` table if it doesn't exist
$tableSql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10),
    email VARCHAR(100) NOT NULL UNIQUE
)";
if (!$conn->query($tableSql)) {
    die("Error creating table: " . $conn->error);
}

// Get user input
$phone = $_POST['phone'];
$userPassword = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';

// Check if the phone number is the reserved admin number
if ($phone === '222-222-2222') {
    echo "This phone number is reserved for the admin and cannot be used.";
} else {
    // Check if phone number already exists
    $sql = "SELECT * FROM users WHERE phone='$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Phone number already exists.";
    } else {
        // Insert user data
        $sql = "INSERT INTO users (phone, password, firstname, lastname, dob, gender, email)
        VALUES ('$phone', '$userPassword', '$firstname', '$lastname', '$dob', '$gender', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
