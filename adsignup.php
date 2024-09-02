<?php
session_start();
include '../php/db_connection.php'; // File to connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $code = $_POST['code'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate that passwords match
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the query
        $stmt = $conn->prepare("INSERT INTO admin_acc (username, code, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $code, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            header("Location: adlogin.php");
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
            <form action="adsignup.php" method="POST">            
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="code">Clinic Code</label>
                    <input type="text" class="form-control" id="code" name="code" required>
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
            <p class="mt-3 text-center">Already have an account? <a href="adlogin.php">Login here</a>.</p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
