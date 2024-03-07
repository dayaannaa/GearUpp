<?php
    include "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {

        $id = $_GET["id"];

        $sql = "DELETE FROM user_info WHERE user_id=$id";
        if (mysqli_query($conn, $sql)) {
            echo "<script> alert('User Account has deleted successfully.'); </script>";
            echo "<script> window.location.href = 'manage_users.php';</script>";
        } else {
            echo '<div class="container mt-5">';
            echo '<div class="alert alert-danger" role="alert">Error deleting record: ' . mysqli_error($conn) . '</div>';
            echo '<a href="manage_users.php" class="btn btn-primary bg-black">Return</a>';
            echo '</div>';
        }
    }

    mysqli_close($conn);
?>