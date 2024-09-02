<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .nav-item:hover {
            background-color: #dfe6ed;
            
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <div class="text-center py-4">
                        <img src="../images/logo2.png" alt="Clinic Logo" class="img-fluid" style="max-width: 100px;margin-bottom:-40px;margin-top: -30px">
                    </div>
                    <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        Dashboard
                    </h5>
                    <ul class="nav flex-column">
                        <!-- Navigation links with icons -->
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadPage('booking.php', 'Book Appointment');">
                                <i class="fas fa-calendar-plus mr-2"></i> Book Appointment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadPage('calendar.php', 'Calendar');">
                                <i class="far fa-calendar-alt mr-2"></i> View Calendar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadPage('my_appointments.php', 'My Appointments');">
                                <i class="fas fa-calendar-check mr-2"></i> My Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadPage('contact.html', 'Contact Us');">
                                <i class="fas fa-envelope mr-2"></i> Contact Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadPage('about.html', 'About Us');">
                                <i class="fas fa-info-circle mr-2"></i> About Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadPage('settings.php', 'Settings');">
                                <i class="fas fa-cog mr-2"></i> Account
                            </a>
                        </li>
                        <!-- Logout button -->
                        <li class="nav-item" style="margin-top: 70px;">
                            <a class="nav-link" href="#" onclick="logout()" style="color: red;">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- /Sidebar -->

            <!-- Main content area -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="content">
                    <!-- Display dynamic notification -->
                    <?php if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['booking_message']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php unset($_SESSION['booking_success']); ?>
                        <?php unset($_SESSION['booking_message']); ?>
                    <?php endif; ?>
                    <!-- Booking Form Container -->
                    <div id="bookingFormContainer">
                        <!-- This div will contain the loaded booking form -->
                    </div>
                    <!-- Content will load dynamically here -->
                </div>
            </main>
            <!-- /Main content area -->
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
    <script>
        // Function to load content dynamically
        function loadPage(pageUrl, pageTitle) {
            fetch(pageUrl)
                .then(response => response.text())
                .then(data => {
                    document.querySelector('#bookingFormContainer').innerHTML = data;
                    document.title = pageTitle;
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                });
        }

        // Function for logout
        function logout() {
            // Perform logout actions, such as clearing session data or cookies
            // Example: Redirect to login page
            window.location.href = '../../adls/logout.php'; // Replace with your actual logout endpoint
        }

        // Load About Us page by default
        document.addEventListener('DOMContentLoaded', function() {
            loadPage('about.html', 'About Us');
        });
    </script>
</body>
</html>