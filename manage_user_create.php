<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>
<?php
    include "sidebar.html";
    include "connection.php";
    session_start();

    if (!isset($_SESSION['admin_id'])) {
        header("Location: user_login.php");
        exit();
    }
?>

<div class="form-group">
    <label for="first_name">First Name:</label>
    <input type="tet" class="form-control" id="first_name" name="first_name">
</div>

</body>
</html>