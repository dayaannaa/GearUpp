<?php
    include "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {

        $id = $_GET["id"];

        $sql = "DELETE FROM products WHERE ProductID = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script> alert('Product has deleted successfully.'); </script>";
            echo "<script> window.location.href = 'manage_inventory.php';</script>";
        } else {
            echo '<div class="container mt-5">';
            echo '<div class="alert alert-danger" role="alert">Error deleting record: ' . mysqli_error($conn) . '</div>';
            echo '<a href="manage_inventory.php" class="btn btn-primary bg-black">Return</a>';
            echo '</div>';
        }
    }

    mysqli_close($conn);
?>