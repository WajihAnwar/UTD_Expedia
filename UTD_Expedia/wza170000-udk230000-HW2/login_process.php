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

$phone = $_POST['phone'];
$userPassword = $_POST['password'];

$sql = "SELECT * FROM users WHERE phone='$phone' AND password='$userPassword'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['loggedin'] = true;
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['lastname'] = $user['lastname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_admin'] = ($user['phone'] === '222-222-2222'); // Check if admin

    header("Location: my-account.php");
} else {
    header("Location: login.php?error=1");
}

$conn->close();
?>
