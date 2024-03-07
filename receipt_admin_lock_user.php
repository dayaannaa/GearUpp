<?php
// Check if the request is sent via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via AJAX
    $userId = $_POST['userId'];
    $receiptId = $_POST['receiptId'];
    
    // Validate received data (you may need more validation depending on your requirements)
    if (!empty($userId) && !empty($receiptId)) {
        // Database connection
        require 'connection.php';

        // SQL query to update user_id in the receipt table
        $sql = "UPDATE receipt SET user_id = ? WHERE receipt_id = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $receiptId);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Receipt updated successfully.";
        } else {
            echo "Error updating receipt: " . $stmt->error;
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
