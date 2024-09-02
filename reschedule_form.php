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

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the current booking details
        $query = "SELECT appointment_date, appointment_time FROM bookings WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($booking) {
            $current_date = htmlspecialchars($booking['appointment_date']);
            $current_time = htmlspecialchars($booking['appointment_time']);
        } else {
            echo "Booking not found.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'], $_POST['new_date'], $_POST['new_time'])) {
    $booking_id = $_POST['booking_id'];
    $new_date = $_POST['new_date'];
    $new_time = $_POST['new_time'];

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the booking with the new date and time
        $query = "UPDATE bookings SET appointment_date = ?, appointment_time = ?, status = 'Pending' WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$new_date, $new_time, $booking_id]);

        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Reschedule Appointment</h2>
        <form action="reschedule_form.php" method="post">
            <div class="form-group">
                <label for="new_date">New Appointment Date</label>
                <input type="date" class="form-control" id="new_date" name="new_date" required>
            </div>
            <div class="form-group">
                <label for="new_time">New Appointment Time</label>
                <input type="time" class="form-control" id="new_time" name="new_time" required>
            </div>
            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking_id); ?>">
            <button type="submit" class="btn btn-primary">Reschedule</button>
        </form>
    </div>
</body>
</html>
