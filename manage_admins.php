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

    <link href="assets/css/style.css" rel="stylesheet">
</head>
<style>
    table {
        margin-left: 100px;
    }
    body {
        overflow-x: hidden;
        overflow-y: hidden;
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
 <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Admin Accounts</h2>
          <ol>
            <li><a href="admin_dash.php">Home</a></li>
            <li>Admins</li>
          </ol>
        </div>

      </div>
    </section>
</div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</th>>
                <th>Profile Picture</th>>
                <td><a href="admin_create.php" class="btn btn-secondary mr-2 bg-black">Create</a></td>
            </tr>
        </thead>
            <tbody>
                <?php
                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
                            $id = $_GET["id"];
                    
                            $sql = "DELETE FROM admins WHERE admin_id=$id";
                            if (mysqli_query($conn, $sql)) {
                                echo '<tr><td colspan="9" style="text-align: center; background-color: #d4edda; color: #155724; padding: 10px;">Record deleted successfully</td></tr>';
                            } else {
                                echo "Error deleting record: " . mysqli_error($conn);
                            }
                        }
                    $sql = "SELECT * FROM admin_account";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["admin_id"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["password"] . "</td>";
                            echo "<td>" . $row["password"] . "</td>";
                            echo '<td><a href="admin_update.php" class="btn btn-secondary mr-2 bg-black">Update</a></td>';
                            echo '<td><a href="admin_delete.php?id=' . $row["admin_id"] . '" class="btn btn-secondary mr-2 bg-black">Delete</a></td>';
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