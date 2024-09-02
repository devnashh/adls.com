<?php
// Database connection details
$host = 'localhost';
$dbname = 'archangels';
$username = 'root';
$password = '';

// Establish PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Example: Fetch user information (replace with your actual query)
    $userId = 1; // Example user ID, replace with authenticated user's ID

    $stmt = $pdo->prepare("SELECT username, email, full_name, phone_number, date_of_birth, address, gender, medical_history FROM accounts WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($userInfo);
    exit();
} catch (PDOException $e) {
    // Handle database connection error
    echo json_encode(array('error' => 'Database connection error: ' . $e->getMessage()));
    exit();
}
?>
