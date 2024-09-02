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
<?php
if (isset($_GET['message'])) {
    echo "<div class='alert alert-info text-center'>" . htmlspecialchars($_GET['message']) . "</div>";
}
?>

    <div class="sidebar">
        <a href="app_list.php">Appointment List</a>
        <a href="users.php" class="active">Registered Users</a>
        <a href="calendar.php">Calendar</a>
        <form action="../logout.php" method="post" class="form-inline my-2 my-lg-0" style="padding-top:300px; padding-left:12px">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" style="background-color:red;color:white">Logout</button>
        </form>
        <!--<a href="settings.php">Post Announcement</a>-->
    </div>
    <div class="container">
        <h2 class="my-4">User Accounts List</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Medical History</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once '../php/db_connection.php'; // Include the database connection file

                    // Query to fetch user account information
                    $sql = "SELECT * FROM accounts";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id"] . "</td>
                                    <td>" . $row["username"] . "</td>
                                    <td>" . $row["full_name"] . "</td>
                                    <td>" . $row["email"] . "</td>
                                    <td>" . $row["phone_number"] . "</td>
                                    <td>" . $row["date_of_birth"] . "</td>
                                    <td>" . $row["address"] . "</td>
                                    <td>" . $row["gender"] . "</td>
                                    <td>" . $row["medical_history"] . "</td>
                                    <td>
                                        <a href='../admin/view_user.php?id=" . $row["id"] . "' class='btn btn-info btn-sm'>View</a>
                                        <a href='../admin/edit_user.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='delete_user.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>0 results</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
