<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grandTotal = $_POST['grandTotal'];
    $currentReceiptId = $_POST['currentReceiptId'];
    $selectedProductId = $_POST['selectedProductId'];

    if (!empty($grandTotal) && !empty($currentReceiptId) && !empty($selectedProductId)) {
        require 'connection.php';

        $sql = "UPDATE receipt SET amount_paid = ?, status = 'Success' WHERE receipt_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $grandTotal, $currentReceiptId);

        if ($stmt->execute()) {
            echo "Receipt updated successfully.";
        } else {
            echo "Error updating receipt: " . $stmt->error;
        }

        if ($stmt->execute()) {
            echo "Inventory updated successfully.";
        } else {
            echo "Error updating inventory: " . $stmt->error;
        }

        $insertSql = "INSERT INTO receipt (receipt_date, amount_paid, receipt_image, status, user_id) VALUES (NULL, NULL, NULL, NULL, NULL)";

        if ($conn->query($insertSql) === TRUE) {
            echo "New record inserted successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid data received.";
    }
} else {
    echo "Invalid request method.";
}

?>
