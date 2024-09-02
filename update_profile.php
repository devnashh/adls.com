<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your actual database password
$dbname = "archangels";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize user inputs
function sanitize($input) {
    global $conn;
    return htmlspecialchars(strip_tags(mysqli_real_escape_string($conn, $input)));
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

// Retrieve data from POST request
$userId = $_POST['userId'];
$email = sanitize($_POST['email']);
$phone = sanitize($_POST['phone']);
$address = sanitize($_POST['address']);

// Update user information
$sql = "UPDATE accounts SET email = ?, phone_number = ?, address = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $email, $phone, $address, $userId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
}

$stmt->close();
$conn->close();
?>