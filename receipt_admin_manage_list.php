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
        header("Location: user_login.php");
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
      </div>
        <table class="table-fill">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Details</th>
                    <th>Image</th>
                    <th class="text-center" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody class="table-hover">
            <?php
$sql = "SELECT r.receipt_id, r.receipt_date, CONCAT(u.first_name, ' ', u.last_name) AS customer_name, r.receipt_image
        FROM receipt r
        INNER JOIN user_info u ON r.user_id = u.user_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td class='text-center'>" . $row["receipt_id"] . "</td>";
        echo "<td class='text-center'>" . $row["receipt_date"] . "</td>";
        echo "<td class='text-center'>" . $row["customer_name"] . "</td>";
        
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
        
        echo '<td style="display: flex; justify-content: space-between; align-items: center;">';
        echo '<a href="../GearUp/' . $row["receipt_image"] . '" target="_blank">View PDF</a>';
        echo '</td>';
        echo '<td><a href="receipt_admin_edit_list.php?id=' . $row["receipt_id"] . '" class="btn btn-secondary mr-2 bg-black">Edit</a> </td>';
        echo '<td><a href="receipt_admin_delete_list.php?id=' . $row["receipt_id"] . '" class="btn mr-2 bg-danger text-white">Delete</a></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No records found</td></tr>";
}

mysqli_close($conn);
?>

            </tbody>
        </table>

</body>
</html>