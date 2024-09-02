<?php
session_start(); // Start the session

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

// Function to sanitize user inputs
function sanitize($input) {
    global $conn;
    return htmlspecialchars(strip_tags(mysqli_real_escape_string($conn, $input)));
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return error response if not logged in
    $response = [
        'success' => false,
        'message' => 'User not logged in.'
    ];
    echo json_encode($response);
    exit();
}

$userId = $_SESSION['user_id']; // Get the logged-in user's ID from session

// Validate and sanitize input data
$currentPassword = sanitize($_POST['currentPassword']);
$newPassword = sanitize($_POST['newPassword']);
$confirmPassword = sanitize($_POST['confirmPassword']);

// Check if passwords match
if ($newPassword !== $confirmPassword) {
    // Return error response if passwords do not match
    $response = [
        'success' => false,
        'message' => 'New passwords do not match.'
    ];
    echo json_encode($response);
    exit();
}

// Fetch user's current password from database
$sql = "SELECT password FROM accounts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

    // Verify if current password matches stored password
    if (password_verify($currentPassword, $storedPassword)) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $updateSql = "UPDATE accounts SET password = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $hashedPassword, $userId);
        if ($updateStmt->execute()) {
            // Password updated successfully
            $response = [
                'success' => true,
                'message' => 'Password updated successfully.'
            ];
            echo json_encode($response);
        } else {
            // Error updating password
            $response = [
                'success' => false,
                'message' => 'Failed to update password. Please try again later.'
            ];
            echo json_encode($response);
        }
    } else {
        // Current password does not match
        $response = [
            'success' => false,
            'message' => 'Current password is incorrect.'
        ];
        echo json_encode($response);
    }
} else {
    // User not found
    $response = [
        'success' => false,
        'message' => 'User not found.'
    ];
    echo json_encode($response);
}

$stmt->close();
$conn->close(); // Close MySQL connection
?>
