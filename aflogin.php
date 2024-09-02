
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archangels Diagnostics and Laboratory Clinic</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Additional styling for better spacing */
        .contact-info i {
            margin-right: 10px;
        }
        .contact-info li {
            list-style: none;
            margin-bottom: 10px;
        }
        #backToTopBtn {
        display: none; /* Hidden by default */
        position: fixed; /* Fixed position */
        bottom: 20px; /* Place at the bottom */
        right: 30px; /* Place on the right */
        z-index: 99; /* Make sure it does not overlap */
        border: none; /* Remove borders */
        outline: none; /* Remove outline */
        background-color: blue; /* Set a background color */
        color: white; /* Text color */
        cursor: pointer; /* Add a mouse pointer on hover */
        padding: 10px 20px; /* Some padding */
        border-radius: 10px; /* Rounded corners */
        font-size: 18px; /* Increase font size */
    }

    #backToTopBtn:hover {
        background-color: navy; /* Add a dark-grey background on hover */
    }
    </style>
</head>
<body>
    <button id="backToTopBtn" class="btn btn-primary" title="Back to Top">Back to Top</button>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="../images/logo2.png" alt="Archangels Clinic Logo" height="30" class="mr-2" style="width: 150px;height: 100px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="my_appointments.php">My Appointment's</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cscheds.php">Check Schedules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item" style="padding-right:50px">
                    <a class="nav-link" href="#contact">Contacts</a>
                </li>
                <!-- Logout Button -->
                <li class="nav-item" style="padding-right:10px">
                    <form action="../logout.php" method="post" class="form-inline my-2 my-lg-0">
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="display-4">Welcome to Archangels Diagnostics and Laboratory Clinic</h1>
            <p class="lead">Providing high-quality healthcare services with advanced diagnostics.</p>
            <a href="booking.php" class="btn btn-primary btn-lg">Book Now</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>About Us</h2>
                    <p>Welcome to Archangels Diagnostics and Laboratory, your trusted partner in healthcare diagnostics. Founded in [year], we are committed to providing accurate and timely diagnostic services to healthcare providers and patients.

                        At Archangels, we combine cutting-edge technology with compassionate care to deliver superior laboratory services. Our team of dedicated professionals ensures that every sample is processed with precision and accuracy, adhering to the highest standards of quality.
                        
                        Whether you're a healthcare professional seeking reliable diagnostic results or a patient in need of diagnostic testing, Archangels Diagnostics and Laboratory is here to support you every step of the way.</p>
                </div>
                <div class="col-md-6">
                    <img src="../images/imgs1.jpg" alt="About Us" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center">Our Services</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Diagnostic Imaging</h5>
                            <p class="card-text">Diagnostic imaging plays a crucial role in modern healthcare by utilizing advanced technologies such as X-rays, CT scans, MRIs, and ultrasound to visualize internal structures of the body. It helps healthcare professionals accurately diagnose and monitor conditions ranging from fractures and tumors to cardiovascular diseases, enabling timely and effective treatment planning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Laboratory Tests</h5>
                            <p class="card-text">Laboratory tests involve analyzing samples of blood, urine, tissue, or other bodily fluids to assess various aspects of health, including organ function, disease markers, and overall wellness. These tests provide essential diagnostic insights, aiding in the detection, monitoring, and management of diseases such as diabetes, infections, and metabolic disorders.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Health Screenings</h5>
                            <p class="card-text">Health screenings are preventive measures that involve testing individuals for early signs of diseases before symptoms manifest. These screenings typically include blood pressure checks, cholesterol levels, mammograms, and pap smears. Regular health screenings are crucial for early detection and intervention, promoting better health outcomes and reducing the risk of complications from treatable conditions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Contact Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <h5>Contact Information</h5>
                    <p>Blk 4 Lot 34 Tandoc St, Pecsonville Subd.</p>
                    <p>Email: archangelslab@gmail.com</p>
                    <p>Phone: 0932-290-0443</p>
                </div>
                <div class="col-md-6">
                    <h5>Our Location</h5>
                    <!-- Google Map Embed -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.673235799817!2d144.96305831531768!3d-37.81621897975126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf19b2bace61d2b0!2s123%20Main%20St%2C%20Melbourne%20VIC%203000%2C%20Australia!5e0!3m2!1sen!2sus!4v1603178473528!5m2!1sen!2sus" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Archangels Diagnostics and Laboratory Clinic. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Font Awesome for icons -->
    <!-- Back to Top Button -->
    <script>
        // Get the button
        var backToTopBtn = document.getElementById("backToTopBtn");
    
        // Show the button when the user scrolls down 20px from the top
        window.onscroll = function() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopBtn.style.display = "block";
            } else {
                backToTopBtn.style.display = "none";
            }
        };
    
        // When the user clicks on the button, scroll to the top of the document
        backToTopBtn.onclick = function() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
        };
        window.history.pushState(null, "", window.location.href);
window.onpopstate = function() {
    window.history.pushState(null, "", window.location.href);
};

    </script>
    <i class="fas fa-arrow-up"></i>
</button>

</body>
</html>
