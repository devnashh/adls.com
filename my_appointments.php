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

    // Retrieve user ID from session
    $user_id = $_SESSION['user_id']; // Assuming 'user_id' is set after successful login

    // Query to fetch booking information for the current user
    $query = "SELECT id, appointment_date, appointment_time, service_type, status FROM bookings WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);

    // Fetch and display bookings
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Bookings</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #eee;
                font-family: Arial, sans-serif;
            }
            .container {
                margin-top: 50px;
            }
            .table-responsive {
                margin-top: 20px;
            }
            .badge {
                font-size: 0.9em;
            }
            .btn-back {
                margin-bottom: 20px;
                color: gray;
                background-color: transparent;
                border: 1px solid gray;
                height: 20px;
            }
            .btn-back:hover {
                background-color: gray;
                text-decoration: underline;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light" style="background:#fff">
            <a class="navbar-brand" href="#">
                <img src="../images/logo2.png" alt="Archangels Clinic Logo" height="30" class="mr-2" style="width: 150px;height: 100px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="aflogin.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="my_appointments.php">My Appointment's</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cscheds.php">Check Schedules</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <h2>Your Bookings</h2>
            <?php
            if ($stmt->rowCount() > 0) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-striped table-bordered">';
                echo '<thead class="thead-dark">
                        <tr>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>';
                echo '<tbody>';

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['appointment_date']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['appointment_time']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['service_type']) . '</td>';
                    echo '<td>';
                    echo '<span class="badge badge-';
                    switch ($row['status']) {
                        case 'Pending':
                            echo 'warning';
                            break;
                        case 'Approved':
                            echo 'success';
                            break;
                        case 'Rejected':
                            echo 'danger';
                            break;
                        default:
                            echo 'secondary';
                            break;
                    }
                    echo '">' . htmlspecialchars($row['status']) . '</span>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form action="cancel_appointment.php" method="post" class="d-inline">';
                    echo '<input type="hidden" name="booking_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="action" value="cancel" class="btn btn-danger btn-sm">Cancel</button>';
                    echo '</form>';
                    echo ' ';
                    echo '<form action="reschedule_appointment.php" method="post" class="d-inline">';
                    echo '<input type="hidden" name="booking_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="action" value="reschedule" class="btn btn-warning btn-sm">Reschedule</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>'; // Close table-responsive
            } else {
                echo '<div class="alert alert-info mt-4">No bookings found for this user.</div>';
            }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
