<?php
include_once '../php/db_connection.php'; // Include the database connection file

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the user ID from the URL

    // Prepare the SQL delete statement
    $sql = "DELETE FROM accounts WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id); // Bind the user ID to the statement

        if ($stmt->execute()) {
            // Redirect to users page with a success message
            header("Location: users.php?message=User deleted successfully");
            exit();
        } else {
            // Redirect to users page with an error message
            header("Location: users.php?message=Error deleting user");
            exit();
        }
    }

    $stmt->close();
}

$conn->close();
?>
