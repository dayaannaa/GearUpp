<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Accounts Management</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">

    <link href="assets/css/style.css" rel="stylesheet">
</head>
<style>
    .table-fill {
        margin-left: 400px;
        max-width: 800px;
    }
    
</style>
<body>
    <?php
    include "sidebar.html";
    include "connection.php";
    session_start();

    if (!isset($_SESSION['admin_id'])) {
        echo '<script> alert ("Please log in first.")</script>';
        echo '<script> window.location.href = "user_login.php"; </script>';
    exit();
    }
    ?>

    <main id="main">
    <section class="breadcrumbs">
        <div class="container">

        <div class="d-flex justify-content-between align-items-center">
        <h2>Supplier Management</h2>
        <ol>
            <li><a href="admin_dash.php">Home</a></li>
            <li>Supplier</li>
        </ol>
        </div>
        </div>
    </section>

    <div class="container mt-3">
        <form method="GET" action="">
            <div class="mb-3">
                <label for="search" class="form-label">Search Products:</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Enter email or ID">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Image</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>>
                <th class="text-center">Password</th>>
                <th><a href="supplier_create.php" class="btn btn-secondary mr-2 bg-black">Create</a></th>
                <th><a href="supplier_update.php" class="btn btn-secondary mr-2 bg-black">Update</a></th>
            </tr>
        </thead>
            <tbody>
                <?php

                    $search_query = isset($_GET['search']) ? $_GET['search'] : '';

                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
                            $id = $_GET["id"];
                    
                            $sql = "DELETE FROM supplier WHERE SupplierID = $id";
                            if (mysqli_query($conn, $sql)) {
                                echo '<tr><td colspan="9" style="text-align: center; background-color: #d4edda; color: #155724; padding: 10px;">Record deleted successfully</td></tr>';
                            } else {
                                echo "Error deleting record: " . mysqli_error($conn);
                            }
                        }
                    $sql = "SELECT * FROM supplier";
                    if (!empty($search_query)) {
                        $sql .= " WHERE SupplierName LIKE '%$search_query%' OR SupplierEmail LIKE '%$search_query%'";
                    }
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo "<td class=text-center>" . $row["SupplierID"] . "</td>";
                            echo '<td style="display: flex; justify-content: space-between; align-items: center;">';
                            $imageFilenames = explode(',', $row['supplier_image']);
                            foreach ($imageFilenames as $filename) {
                                echo '<img src="../GearUp/uploads/' . $filename . '" width="100" height="100"  style="margin-right: 5px;">';
                            }            
                            echo "<td class=text-center>" . $row["SupplierName"] . "</td>";
                            echo "<td class=text-center>" . $row["SupplierEmail"] . "</td>";
                            echo "<td class=text-center>" . $row["ContactNum"] . "</td>";               
                            echo '</td>';
                            echo '<td colspan="3" class=text-center><a href="supplier_delete.php?id=' . $row["SupplierID"] . '" class="btn btn-secondary mr-2 bg-danger">Delete</a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td class=text-center colspan='7'>No records found</td></tr>";
                    }
                    mysqli_close($conn);
                ?>
            </tbody>
        </table>

</main>
</body>
</html>