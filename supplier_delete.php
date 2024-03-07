<?php
    include "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {

        $id = $_GET["id"];

        $sql = "DELETE FROM supplier WHERE SupplierID = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script> alert('Admin Accunt has deleted successfully.'); </script>";
            echo "<script> window.location.href = 'manage_supplier.php';</script>";
        } else {
            echo '<div class="container mt-5">';
            echo '<div class="alert alert-danger" role="alert">Error deleting record: ' . mysqli_error($conn) . '</div>';
            echo '<a href="manage_admins.php" class="btn btn-primary bg-black">Return</a>';
            echo '</div>';
        }
    }

    mysqli_close($conn);
?>