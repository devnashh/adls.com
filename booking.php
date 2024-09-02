<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointmentTime = $_POST['appointmentTime'];
    $appointmentDate = $_POST['appointmentDate'];
    $serviceType = $_POST['serviceType'];
    $otherConcerns = $_POST['otherConcerns'] ?? '';
    $uploadDirectory = 'uploads/';

    // Create the uploads directory if it doesn't exist
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $medicalDocuments = '';
    if (isset($_FILES['medicalDocuments']) && $_FILES['medicalDocuments']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['medicalDocuments']['tmp_name'];
        $fileName = $_FILES['medicalDocuments']['name'];
        $destination = $uploadDirectory . basename($fileName);

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $medicalDocuments = $destination;
        } else {
            echo "Error moving the uploaded file.";
        }
    }

    // Here you would typically save the data to a database
    // For simplicity, we're just displaying the details
    echo "<h3>Appointment Details</h3>";
    echo "Time: $appointmentTime<br>";
    echo "Date: $appointmentDate<br>";
    echo "Service Type: $serviceType<br>";
    echo "Other Concerns: $otherConcerns<br>";
    if ($medicalDocuments) {
        echo "Medical Documents: <a href='$medicalDocuments'>Download</a><br>";
    } else {
        echo "No medical documents uploaded.<br>";
    }
} else {
    echo "Invalid request.";
}
?>
