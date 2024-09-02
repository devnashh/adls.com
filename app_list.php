<?php


// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password is set
$dbname = "archangels";

// Initialize variables
$errorMessage = '';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle updating status of a booking
    if (isset($_POST['action']) && $_POST['action'] == 'update_status' && isset($_POST['booking_id']) && isset($_POST['new_status'])) {
        $booking_id = $_POST['booking_id'];
        $new_status = $_POST['new_status'];

        // Update the booking status in the database
        $updateQuery = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([$new_status, $booking_id]);

        // Set session variables for success message
        $_SESSION['update_success'] = true;
        $_SESSION['update_message'] = "Status updated successfully.";

        // Redirect back to appointment_list.php after updating status
        header("Location: app_list.php");
        exit();
    }

    // Query to fetch all bookings with associated account information
    $query = "SELECT b.id AS booking_id, b.user_id, b.appointment_date, b.appointment_time, b.service_type, b.status,
                     a.id AS account_id, a.username, a.full_name, a.email, a.phone_number, a.date_of_birth, a.address, a.gender, a.medical_history
              FROM bookings b
              INNER JOIN accounts a ON b.user_id = a.id";
    $stmt = $pdo->query($query);

} catch (PDOException $e) {
    $errorMessage = "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            width: 250px;
            background-color: blue;
            padding-top: 20px;
            border-radius: 0 10px 10px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar a {
            font-size: 16px;
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .sidebar a:hover {
            background-color: navy;
            text-decoration: none;
        }
        .sidebar a.active {
            background-color: navy;
            font-weight: bold;
        }
        .main-content {
            margin-left: 270px; /* width of the sidebar + some margin */
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="app_list.php" class="active">Appointment List</a>
        <a href="users.php">Registered Users</a>
        <a href="calendar.php">Calendar</a>
        <form action="../logout.php" method="post" class="form-inline my-2 my-lg-0" style="padding-top:300px; padding-left:12px">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" style="background-color:red;color:white">Logout</button>
        </form>
        <!--<a href="settings.php">Settings</a>-->
    </div>
    <div class="container mt-4">
    <h2>All Bookings</h2>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['delete_success']) && $_SESSION['delete_success']): ?>
        <div class="alert alert-success"><?php echo $_SESSION['delete_message']; ?></div>
        <?php unset($_SESSION['delete_success']); ?>
        <?php unset($_SESSION['delete_message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['update_success']) && $_SESSION['update_success']): ?>
        <div class="alert alert-success"><?php echo $_SESSION['update_message']; ?></div>
        <?php unset($_SESSION['update_success']); ?>
        <?php unset($_SESSION['update_message']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Service Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm mr-2" data-toggle="modal" data-target="#viewModal<?php echo $row['booking_id']; ?>">View</button>
                            <form action="../admin/delete_booking.php" method="post" class="d-inline">
                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm mr-2">Delete</button>
                            </form>
                            <form action="../admin/appointment_list.php" method="post" class="d-inline">
                                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                <select name="new_status" class="form-control form-control-sm mb-2">
                                    <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Approved" <?php echo ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="Rejected" <?php echo ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                <button type="submit" name="action" value="update_status" class="btn btn-primary btn-sm">Update Status</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Modal for each booking -->
                    <div class="modal fade" id="viewModal<?php echo $row['booking_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo $row['booking_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel<?php echo $row['booking_id']; ?>">Booking Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Appointment Date: <?php echo htmlspecialchars($row['appointment_date']); ?></p>
                                    <p>Appointment Time: <?php echo htmlspecialchars($row['appointment_time']); ?></p>
                                    <p>Service Type: <?php echo htmlspecialchars($row['service_type']); ?></p>
                                    <p>Status: <?php echo htmlspecialchars($row['status']); ?></p>
                                    <hr>
                                    <h6>User Details</h6>
                                    <p>Username: <?php echo htmlspecialchars($row['username']); ?></p>
                                    <p>Full Name: <?php echo htmlspecialchars($row['full_name']); ?></p>
                                    <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                                    <p>Phone Number: <?php echo htmlspecialchars($row['phone_number']); ?></p>
                                    <p>Date of Birth: <?php echo htmlspecialchars($row['date_of_birth']); ?></p>
                                    <p>Address: <?php echo htmlspecialchars($row['address']); ?></p>
                                    <p>Gender: <?php echo htmlspecialchars($row['gender']); ?></p>
                                    <p>Medical History: <?php echo htmlspecialchars($row['medical_history']); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS and dependencies (optional if needed) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>