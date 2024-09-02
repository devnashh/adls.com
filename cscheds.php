<?php
error_reporting(0);

function build_calendar($month, $year) {
    $mysqli = new mysqli('localhost', 'root', '', 'archangels');
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to fetch the count of approved bookings per day
    $stmt = $mysqli->prepare("SELECT appointment_date, COUNT(*) as booking_count FROM bookings WHERE MONTH(appointment_date) = ? AND YEAR(appointment_date) = ? AND status = 'Approved' GROUP BY appointment_date");
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[$row['appointment_date']] = $row['booking_count'];
            }
        }
        $stmt->close();
    }

    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $datetoday = date('Y-m-d');

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-xs btn-success' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a> ";
    $calendar .= " <a class='btn btn-xs btn-danger' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
    $calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";

    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    $currentDay = 1; // Properly initialize $currentDay
    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }
        
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $today = $date == date('Y-m-d') ? "today" : "";

        if ($date < date('Y-m-d')) {
            $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>N/A</button>";
        } else {
            $bookingCount = isset($bookings[$date]) ? $bookings[$date] : 0;
            if ($bookingCount >= 10) {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-lock'></span> Full</button>";
            } else {
                // Redirect to booking.php with the selected date
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='booking.php?date=$date' class='btn btn-success btn-xs'>Book Now</a>";
            }
        }

        $calendar .= "</td>";
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($l = 0; $l < $remainingDays; $calendar .= "<td class='empty'></td>", $l++);
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";
    echo $calendar;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <title>Archangels Diagnostics and Laboratory Clinic</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Increased text size for better readability */
        body {
            background: #eee;
            font-size: 18px;
           
        }
        h1, h2, h3, h4 {
            font-size: 24px;
        }
        p {
            font-size: 18px;
        }
        .navbar-brand {
            height: 85px;
            margin-bottom:25px;
        }
        .navbar-brand img {
            width: 150px;
            height: 100px;
        }
        .nav-link {
            font-size: 18px;
        }
        .alert h1 {
            font-size: 28px;
        }
        .table {
            font-size: 18px;
        }
        .btn-xs {
            font-size: 16px;
        }
        .contact-info i {
            margin-right: 10px;
        }
        .contact-info li {
            list-style: none;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .today {
            background: #eee;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="../images/logo2.png" alt="Archangels Clinic Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-bottom:15px">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="aflogin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="my_appointments.php">My Appointment's</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Check Schedules <span class="sr-only">(current)</span></a>
            </ul>
        </div>
    </nav>
    <div class="container alert alert-default" style="background:#fff;margin-bottom: 40px">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" style="background:lightblue;border:none;color:white">
                    <h1>Calendar</h1>
                </div>
                <?php
                    $dateComponents = getdate();
                    if (isset($_GET['month']) && isset($_GET['year'])) {
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                    } else {
                        $month = $dateComponents['mon'];
                        $year = $dateComponents['year'];
                    }
                    build_calendar($month, $year);
                ?>
            </div>
        </div>
    </div>
<script>
function loadBookingForm(date) {
    // Use AJAX to load booking.php with the selected date parameter
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bookingFormContainer").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "booking.php?date=" + encodeURIComponent(date), true);
    xhttp.send();
}
</script>
    
    <!-- Footer -->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Font Awesome for icons -->
</body>
</html>
