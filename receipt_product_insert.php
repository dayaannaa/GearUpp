<?php
// Check if the request is sent via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via AJAX
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];
    
    // Validate received data (you may need more validation depending on your requirements)
    if (!empty($productId) && !empty($quantity) && !empty($cost)) {
        // Database connection
        include('connection.php');

        // Fetch the latest receipt ID
        $latestReceiptQuery = "SELECT MAX(receipt_id) AS latest_receipt_id FROM receipt";
        $latestReceiptResult = mysqli_query($conn, $latestReceiptQuery);
        $latestReceiptRow = mysqli_fetch_assoc($latestReceiptResult);
        $receiptId = $latestReceiptRow['latest_receipt_id'];

        // SQL query to insert data into the receipt_products table
        $sql = "INSERT INTO receipt_products (receipt_id, ProductID, quantity, cost) VALUES (?, ?, ?, ?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $receiptId, $productId, $quantity, $cost);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Product added successfully.";
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
