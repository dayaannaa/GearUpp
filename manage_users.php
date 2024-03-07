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
        margin-left: 250px;
        margin-top: 50px;
        margin-bottom: 50px;
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
          <h2>User Accounts</h2>
          <ol>
            <li><a href="admin_dash.php">Home</a></li>
            <li>Users</li>
          </ol>
        </div>
      </div>
</section>
      </div>
        <table class="table-fill">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Home Address</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Image</th>
                    <th class="text-center" colspan="2">Actions</th>

                </tr>
            </thead>
            <tbody class="table-hover">
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {

                        $id = $_GET["id"];

                        $sql = "DELETE FROM user_info WHERE user_id=$id";
                        if (mysqli_query($conn, $sql)) {
                            echo '<tr><td colspan="9" style="text-align: center; background-color: #d4edda; color: #155724; padding: 10px;">Record deleted successfully</td></tr>';
                        } else {
                            echo "Error deleting record: " . mysqli_error($conn);
                            }
                        }
                    $sql = "SELECT * FROM user_info";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class=text-center>" . $row["user_id"] . "</td>";
                            echo "<td class=text-center>" . $row["first_name"] . "</td>";
                            echo "<td class=text-center>" . $row["last_name"] . "</td>";
                            echo "<td class=text-center>" . $row["phone"] . "</td>";
                            echo "<td class=text-center>" . $row["address"] . "</td>";
                            echo "<td class=text-center>" . $row["city"] . "</td>";
                            echo "<td class=text-center>" . $row["email"] . "</td>";
                            echo "<td class=text-center>" . $row["password"] . "</td>";
                            echo '<td style="display: flex; justify-content: space-between; align-items: center;">';
                            $imageFilenames = explode(',', $row['user_image']);
                            foreach ($imageFilenames as $filename) {
                                echo '<img src="../GearUp/' . $filename . '" width="100" height="100"  style="margin-right: 5px;">';
                            }
                            echo '</td>';
                            echo '<td><a href="user_update.php" class="btn btn-secondary mr-2 bg-black">Update</a> </td>';
                            echo '<td><a href="user_delete.php?id=' . $row["user_id"] . '" class="btn mr-2 bg-danger text-white">Delete</a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }


                    mysqli_close($conn);
                ?>
            </tbody>
        </table>

</body>
</html>