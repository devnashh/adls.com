<?php
session_start();
include 'db_connection.php'; // File to connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate that passwords match
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the query
        $stmt = $conn->prepare("INSERT INTO accounts (username, password, full_name, email, phone_number, date_of_birth, address, gender, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssssss", $username, $hashedPassword, $fullName, $email, $phoneNumber, $dateOfBirth, $address, $gender);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            header("Location: ../html/login.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .input-group-text {
            cursor: pointer;
        }
        .input-group-text:hover {
            background-color: #007bff;
            color: white;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .card {
            max-width: 700px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <h2 class="card-title text-center mb-4">Signup</h2>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" class="form-control" id="fullName" name="fullName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                </div>
                <div class="form-group">
                    <label for="dateOfBirth">Date of Birth</label>
                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Signup</button>
            </form>
            <p class="mt-3 text-center">Already have an account? <a href="../html/login.php">Login here</a>.</p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
