<?php
session_start();

include '../php/db_connection.php'; // File to connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT id, password FROM admin_acc WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: nav.html");
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
        .card {
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }
        .card-title {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .form-group label {
            font-size: 1.2rem;
        }
        .form-control {
            font-size: 1.2rem;
        }
        .btn-primary {
            font-size: 1.2rem;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card">
            <div class="logo">
                <img src="../images/logo2.png" alt="Logo">
            </div>
            <h2 class="card-title text-center mb-4">Admin</h2>
            <p>Warning! This Page are Prohibited and exclusive only for admins.</p>
            <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
            <form action="adlogin.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Login</button>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="adsignup.php">Create one</a></p>
            </div>
            <div class="text-center mt-3">
                <p>Log In As User <a href="../html/login.php">Log In</a></p>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        window.history.pushState(null, "", window.location.href);
window.onpopstate = function() {
    window.history.pushState(null, "", window.location.href);
};
    </script>
</body>
</html>
