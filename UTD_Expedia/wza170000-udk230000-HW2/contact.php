<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo 'Please log in to submit a comment.';
    exit;
}

// Retrieve form data
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$phone = htmlspecialchars($_POST['phone']);
$email = htmlspecialchars($_POST['email']);
$gender = htmlspecialchars($_POST['gender']);
$comment = htmlspecialchars($_POST['comment']);

// Assign a unique contact ID (e.g., using the current timestamp and a random number)
$contactId = uniqid();

$xmlFile = 'contacts.xml';

// Load existing XML or create a new XML structure
if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
} else {
    $xml = new SimpleXMLElement('<contacts/>');
}

// Add new contact entry
$contact = $xml->addChild('contact');
$contact->addChild('contact-id', $contactId);
$contact->addChild('firstname', $firstname);
$contact->addChild('lastname', $lastname);
$contact->addChild('phone', $phone);
$contact->addChild('email', $email);
$contact->addChild('gender', $gender);
$contact->addChild('comment', $comment);

// Save XML file
$xml->asXML($xmlFile);

echo 'Data saved successfully!';
?>
