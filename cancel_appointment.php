<?php
session_start(); // Start session at the beginning of your script

// Check if user is logged in and session variable is set
if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page or handle authentication as needed
    header("Location: login.php"); // Redirect to your login page
    exit();
}

// Establish database connection
$servername = "localhost";
$username = "root";
$password = ""; // Update with your actual database password
$dbname = "archangels";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted and action is cancel
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'cancel') {
        // Validate and sanitize input
        $booking_id = $_POST['booking_id'];
        $user_id = $_SESSION['user_id'];

        // Delete the booking from database
        $query = "DELETE FROM bookings WHERE id = ? AND user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$booking_id, $user_id]);

        // Check if deletion was successful
        if ($stmt->rowCount() > 0) {
            // Redirect back to bookings page or display a success message
            header("Location: my_appointments.php"); // Redirect to your bookings page
            exit();
        } else {
            // Handle case where booking could not be deleted (e.g., already cancelled or not found)
            echo '<div class="container mt-4">';
            echo '<div class="alert alert-danger">Failed to cancel booking. Please try again.</div>';
            echo '</div>';
        }
    } else {
        // Redirect or handle unauthorized access
        header("Location: my_appointments.php"); // Redirect to bookings page if action is not cancel or no POST request
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
