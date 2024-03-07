<?php
// Check if the request is sent via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via AJAX
    $receiptServiceId = $_POST['receiptServiceId'];
    
    // Validate received data (you may need more validation depending on your requirements)
    if (!empty($receiptServiceId)) {
        // Database connection
        include('connection.php');
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to delete the service from receipt_services table
        $sql = "DELETE FROM receipt_services WHERE id = ?";

        // Prepare and bind parameter
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $receiptServiceId);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Service deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid data received.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>
