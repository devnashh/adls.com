<?php
//error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User session not found']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's appointments from the database
$stmt = $conn->prepare("SELECT appointment_date, appointment_time, service_type, other_concerns FROM bookings WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Failed to execute query: ' . $stmt->error]);
    exit();
}

$result = $stmt->get_result();
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($appointments);
?>
