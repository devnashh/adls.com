<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your actual database password
$dbname = "archangels";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize user inputs
function sanitize($input) {
    global $conn;
    return htmlspecialchars(strip_tags(mysqli_real_escape_string($conn, $input)));
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);

    $sql = "UPDATE accounts SET email = ?, phone_number = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $email, $phone, $address, $userId);

    if ($stmt->execute()) {
        $updateMessage = "Profile updated successfully!";
    } else {
        $updateMessage = "Failed to update profile.";
    }

    $stmt->close();
}

// Fetch user details
$sql = "SELECT * FROM accounts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 700px;
            margin-top: 5px;
            margin-bottom: 50px;
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        h2 {
            color: blue;
            text-align: center;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .form-group label {
            color: #495057;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            font-weight: 500;
            border-radius: 5px;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-secondary {
            background-color: gray;
            border-color: gray;
            font-weight: 500;
            border-radius: 5px;
            padding: 10px 20px;
            margin-left: 20px;
            width: 200px;
        }
        .btn-secondary a {
            color: #fff;
            text-decoration: none;
        }
        .btn-secondary a:hover {
            color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div>
    <button type="button" class="btn btn-secondary" onclick="window.location.href='aflogin.php'" style="padding-top:10px;margin-top: 20px">Back</button>
    </div>

    <div class="container">
        <h2>Personal Account</h2>
        <?php if (isset($updateMessage)): ?>
            <div class="alert alert-info"><?php echo $updateMessage; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="userId" value="<?php echo $row['id']; ?>">
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
            </div>
            
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $row['full_name']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone_number']; ?>">
            </div>
            
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row['date_of_birth']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $row['gender']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address"><?php echo $row['address']; ?></textarea>
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <button type="button" class="btn btn-secondary"><a href="profile.php">Change Password</a></button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
} else {
    echo "No user found with ID: $userId";
}

$stmt->close();
$conn->close();
?>
