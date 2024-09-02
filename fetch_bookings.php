<?php
include '../php/db_connection.php';

$sql = "SELECT appointment_date, appointment_time FROM bookings WHERE status = 'Approved'";
$result = $conn->query($sql);

$bookedSlots = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bookedSlots[] = [
            'date' => $row['appointment_date'],
            'time' => $row['appointment_time']
        ];
    }
}
echo json_encode($bookedSlots);
?>
