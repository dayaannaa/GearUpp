<?php
include ('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Delete receipt based on ID
    $id = $_GET["id"];
    $sql = "DELETE FROM receipt WHERE receipt_id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: receipt_admin_manage_list.php");
    } else {
        echo "Error deleting receipt: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
