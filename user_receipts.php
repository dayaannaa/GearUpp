<?php
    session_start();
    include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">
    <title>Receipt History</title>
</head>
<style>
    .tableReceipts{
        margin-left: 410px;
    }
</style>
<body>
    <?php include "sidebaruser.html"; ?>
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
            <h2>Receipt History</h2>
            <ol>
                <li><a href="admin_dash.php">Home</a></li>
                <li>Receipts</li>
            </ol>
            </div>
        </div>
    </section>
      </div>
    <div class= tableReceipts>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">Receipt Date</th> 
                <th class="text-center">Amount Paid</th> 
            </tr>
        </thead>
        <tbody class="table-hover">
            <?php
            if (!isset($_SESSION['user_id'])) {
                header("Location: user_login.php");
                exit();
            }

            $user_id = $_SESSION['user_id'];

            $sql = "SELECT r.receipt_date, r.amount_paid, r.receipt_image
                    FROM receipt r
                    WHERE r.user_id = $user_id";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $row["receipt_date"] . "</td>";
                    echo "<td class='text-center'>" . $row["amount_paid"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2' class='text-center'>No records found</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
        </div>
</body>
</html>
