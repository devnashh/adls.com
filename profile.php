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
            max-width: 600px;
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745; /* Updated to a green shade from Archangels theme */
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }
        h2 {
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group label {
            color: #495057;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-weight: 500;
        }
        .btn-secondary a {
            color: #ffffff;
            text-decoration: none;
        }
        .btn-secondary a:hover {
            color: #e2e6ea;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Account</h1>
        <div>
            <h2>Change Password</h2>
        </div>
        <div id="changePasswordForm">
            <div class="form-group">
                <label for="currentPassword">Current Password:</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="changePassword()">Send Verification</button>
                <button type="button" class="btn btn-secondary"><a href="aflogin.php">Back</a></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Your custom JavaScript -->
    <script src="script.js"></script>
</body>
</html>
