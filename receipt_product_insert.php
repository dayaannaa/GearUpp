<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];
    
    if (!empty($productId) && !empty($quantity) && !empty($cost)) {
        include('connection.php');

        $latestReceiptQuery = "SELECT MAX(receipt_id) AS latest_receipt_id FROM receipt";
        $latestReceiptResult = mysqli_query($conn, $latestReceiptQuery);
        $latestReceiptRow = mysqli_fetch_assoc($latestReceiptResult);
        $receiptId = $latestReceiptRow['latest_receipt_id'];

        $sql = "INSERT INTO receipt_products (receipt_id, ProductID, quantity, cost) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $receiptId, $productId, $quantity, $cost);
        
        if ($stmt->execute()) {
            $updateSql = "UPDATE inventory SET Quantity = Quantity - ? WHERE ProductID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ii", $quantity, $productId);
            if ($updateStmt->execute()) {
                echo "Product added successfully.";
            } else {
                echo "Error updating inventory: " . $updateStmt->error;
            }
        } else {
            echo "Error adding product: " . $stmt->error;
        }

        $stmt->close();
        $updateStmt->close();
        $conn->close();
    } else {
        echo "Invalid data received.";
    }
} else {
    echo "Invalid request method.";
}
?>
