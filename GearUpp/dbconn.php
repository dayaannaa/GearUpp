<?php
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "gearup";

    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die("Could not connect!\n");
    mysqli_select_db($conn, $db_name) or die("Could not select the database $dbname!\n". mysqli_error($conn));
?>