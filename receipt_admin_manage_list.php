<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Management</title>

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
        margin-left: 250px;
        margin-top: 50px;
    }

    /* table tr {
        height: 20px;
    } */

    body {
        overflow-x: hidden;
    }

    header {
        height: 80px;
        margin-left: 40px;
        z-index: 1;
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
    <!-- <header id="header" class="fixed-top header-inner-pages bg-black">
    </header> -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
            <h2>Receipts</h2>
            <ol>
                <li><a href="admin_dash.php">Home</a></li>
                <li>Receipts</li>
            </ol>
            </div>
        </div>
    </section>

    <div class="container mt-3">
        <form method="GET" action="">
            <div class="mb-3">
                <label for="search" class="form-label">Search Receipt:</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Enter email or ID">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    </div>
        <table class="table-fill">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Details</th>
                    <th class="text-center" colspan="2">Actions</th>
                    <th><a href="receipt_admin_create.php" class="btn btn-secondary mr-2 bg-black">Create</a></th>
                </tr>
            </thead>
            <tbody class="table-hover">
            <?php

            $search_query = isset($_GET['search']) ? $_GET['search'] : '';

            $sql = "SELECT r.receipt_id, r.receipt_date, CONCAT(u.first_name, ' ', u.last_name) AS customer_name, r.receipt_image
                    FROM receipt r
                    INNER JOIN user_info u ON r.user_id = u.user_id";
                    if (!empty($search_query)) {
                        $sql .= " WHERE r.receipt_date LIKE '%$search_query%' OR CONCAT(u.first_name, ' ', u.last_name) LIKE '%$search_query%'";
                    }
            $result = mysqli_query($conn, $sql);

<<<<<<< HEAD
        // Outputting combined details
        $details = rtrim($productDetails . $serviceDetails, ", ");
        echo "<td>" . $details . "</td>";
        
        echo '<td style="display: flex; justify-content: space-between; align-items: center;">';
        echo '<a href="../Gear
        Up/' . $row["receipt_image"] . '" target="_blank">View PDF</a>';
        echo '</td>';
        echo '<td><a href="receipt_admin_edit_list.php?id=' . $row["receipt_id"] . '" class="btn btn-secondary mr-2 bg-black">Edit</a> </td>';
        echo '<td><a href="receipt_admin_delete_list.php?id=' . $row["receipt_id"] . '" class="btn mr-2 bg-danger text-white">Delete</a></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No records found</td></tr>";
}
=======
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class=text-center>" . $row["receipt_id"] . "</td>";
                    echo '<td class=text-center> <a href="../GearUp/' . $row["receipt_image"] . '" target="_blank">View PDF</a></td>';
                    echo "<td class=text-center>" . $row["receipt_date"] . "</td>";
                    echo "<td class=text-center>" . $row["customer_name"] . "</td>";
                    
                    // Fetching details from receipt_products table
                    $productDetails = "";
                    $sqlProducts = "SELECT rp.quantity, p.ProductName, rp.cost
                                    FROM receipt_products rp
                                    INNER JOIN products p ON rp.ProductID = p.ProductID
                                    WHERE rp.receipt_id = " . $row['receipt_id'];
                    $resultProducts = mysqli_query($conn, $sqlProducts);
                    while ($product = mysqli_fetch_assoc($resultProducts)) {
                        $productDetails .= $product['quantity'] . " x " . $product['ProductName'] . " ($" . $product['cost'] . "), ";
                    }
>>>>>>> a6b47e04280b9adf53e005fabcdd9c54da16bc79

                    // Fetching details from receipt_services table
                    $serviceDetails = "";
                    $sqlServices = "SELECT s.ServiceName, rs.cost
                                    FROM receipt_services rs
                                    INNER JOIN services s ON rs.ServiceID = s.ServiceID
                                    WHERE rs.receipt_id = " . $row['receipt_id'];
                    $resultServices = mysqli_query($conn, $sqlServices);
                    while ($service = mysqli_fetch_assoc($resultServices)) {
                        $serviceDetails .= $service['ServiceName'] . " ($" . $service['cost'] . "), ";
                    }

                    // Outputting combined details
                    $details = rtrim($productDetails . $serviceDetails, ", ");
                    echo "<td>" . $details . "</td>";
                    echo '</td>';
                    echo '<td><a href="receipt_admin_edit_list.php?id=' . $row["receipt_id"] . '" class="btn btn-secondary mr-2 bg-black">Edit</a> </td>';
                    echo '<td colspan="2"><a href="receipt_admin_delete_list.php?id=' . $row["receipt_id"] . '" class="btn mr-2 bg-danger text-white">Delete</a></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10' class=text-center>No records found</td></tr>";
            }

            mysqli_close($conn);
            ?>

            </tbody>
        </table>

</body>
</html>