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
        margin-left: 450px;
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
      <h2>Inventory Management</h2>
      <ol>
        <li><a href="admin_dash.php">Home</a></li>
        <li>Inventory</li>
      </ol>
    </div>
    </div>
</section>

<table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Price</th>>
                <th class="text-center">Image</th>
                <th class="text-center">Quantity</th>
                <th><a href="inventory_create.php" class="btn btn-secondary mr-2 bg-black">Create</a></th>
                <th><a href="inventory_update.php" class="btn btn-secondary mr-2 bg-black">Update</a></th>
            </tr>
        </thead>
            <tbody>
            <?php
                $query = "SELECT p.ProductID, p.ProductName, p.Price, p.Description, p.productImage, i.Quantity
                FROM products p
                INNER JOIN inventory i ON p.ProductID = i.ProductID";
                $result = mysqli_query($conn, $query);
            
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo "<td class=text-center>" . $row["ProductID"] . "</td>";
                                        echo "<td class=text-center>" . $row["ProductName"] . "</td>";
                                        echo "<td class=text-center>" . $row["Price"] . "</td>";
                                        echo '<td style="display: flex; justify-content: space-between; align-items: center;">';
                                        $imageFilenames = explode(',', $row['productImage']);
                                        foreach ($imageFilenames as $filename) {
                                            echo '<img src="../GearUp/uploads/' . $filename . '" width="100" height="100"  style="margin-right: 5px;">';
                                        }
                                        echo "<td class=text-center>" . $row["Price"] . "</td>";                           
                                        echo '</td>';
                                        echo '<td colspan="3" class=text-center><a href="inventory_delete.php?id=' . $row["ProductID"] . '" class="btn btn-secondary mr-2 bg-danger">Delete</a></td>';
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td class=text-center colspan='8'>No records found</td></tr>";
                                }
                                mysqli_close($conn);
                    ?>
                    <tr>
                    </tr>
            </tbody>
        </table>
</body>
</html>