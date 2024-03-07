<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account</title>

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
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/table.css">

    <link href="assets/css/style.css" rel="stylesheet">
</head>
<style>
  .table-fill {
    margin-left: 300px;
  }
</style>
<body>
    <?php
    include "connection.php";
    include "sidebar.html";

    session_start();
    if (!isset($_SESSION['admin_id'])) {
        header("Location: user_login.php");
        exit();
    }
    ?>

    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Create Account</h2>
          <ol>
            <li><a href="admin_dash.php">Home</a></li>
            <li>Admins</li>
          </ol>
        </div>
      </div>
    </section>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_id"])) {
            $id = $_POST["update_id"];
            $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
            $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
            $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
            $address = mysqli_real_escape_string($conn, $_POST["address"]);
            $city = mysqli_real_escape_string($conn, $_POST["city"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);

            if ($_FILES['user_image']['error'][0] === 4) {
                $newImagesString = $_POST['current_images'];
            } else {
                $newImages = [];

            foreach ($_FILES['user_image']['tmp_name'] as $key => $tmpName) {
                $filename = $_FILES['user_image']['name'][$key];
                $newImageExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $newImageName = uniqid() . '.' . $newImageExtension;
                $targetPath = '../GearUp/uploads/' . $newImageName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $newImages[] = $newImageName;
                } else {
                    echo "Error moving uploaded image to the destination folder.";
                }
            }
            $newImagesString = implode(',', $newImages);
            }

            $sql = "UPDATE user_info SET first_name=?, last_name=?, phone=?, address=?, city=?, email=?, password=?, user_image=? WHERE user_id=?";
            $stmt = mysqli_prepare($conn, $sql);
    
            mysqli_stmt_bind_param($stmt, "ssssssssi", $first_name, $last_name, $phone, $address, $city, $email, $password, $newImagesString, $id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script> alert('Admin account has been successfully updated.'); </script>";
                echo "<script> window.location.href = 'manage_users.php'; </script>"; 
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
    
            mysqli_stmt_close($stmt);
        }
    ?>

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
        <tbody>
            <?php
                $sql = "SELECT * FROM user_info";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class=text-center>" . $row["user_id"] . "</td>";
                        echo '<form method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="update_id" value="' . $row["user_id"] . '">';
                        echo '<td class=text-center><input type="text" name="first_name" value="' . $row["first_name"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="last_name" value="' . $row["last_name"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="phone" value="' . $row["phone"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="address" value="' . $row["address"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="city" value="' . $row["city"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="email" value="' . $row["email"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="password" value="' . $row["password"] . '"></td>';
                        echo '<td>';
                        $currentImages = explode(',', $row['user_image']);
                        foreach ($currentImages as $currentImage) {
                            echo '<img src="../GearUp/uploads/' . $currentImage . '" width="100" height="100" alt="Image">';
                        }
                        echo '<input type="hidden" name="current_images" value="' . implode(',', $currentImages) . '">';
                        echo '</td>';
                        echo '<td>';
                        echo '<div class="col">';
                        echo '<label class="form-label">New Images (Optional):</label>';
                        echo '<input type="file" name="user_image[]" accept=".jpg, .jpeg, .png" multiple>'; 
                        echo '</div>';
                        echo '</td>';
                        echo '<td colspan="2" class="text-center"><button type="submit" class="btn btn-secondary mr-2 bg-black">Update</button></td>';
                        echo '</form>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }
            ?>
</body>
</html>