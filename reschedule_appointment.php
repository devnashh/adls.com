<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = ""; // Update with your actual database password
$dbname = "archangels";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    // Handle rescheduling logic, such as displaying a form to select a new date and time.
    // For now, we'll just redirect to a reschedule page (you'll need to create this page).
    header("Location: reschedule_form.php?booking_id=" . $booking_id);
    exit();
} else {
    header("Location: bookings.php");
    exit();
}
?>
