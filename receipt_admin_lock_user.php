<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $receiptId = $_POST['receiptId'];
    $receiptDate = $_POST['receiptDate'];
    
    if (!empty($userId) && !empty($receiptId)) {
        require 'connection.php';

        $sql = "UPDATE receipt SET user_id = ? , receipt_date = ? WHERE receipt_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $userId, $receiptDate, $receiptId);

        if ($stmt->execute()) {
            echo "Receipt updated successfully.";
        } else {
            echo "Error updating receipt: " . $stmt->error;
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
