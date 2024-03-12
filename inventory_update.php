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
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);

            if ($_FILES['admin_image']['error'][0] === 4) {
                $newImagesString = $_POST['current_images'];
            } else {
                $newImages = [];

            foreach ($_FILES['admin_image']['tmp_name'] as $key => $tmpName) {
                $filename = $_FILES['admin_image']['name'][$key];
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

            $sql = "UPDATE admin_account SET email=?, password=?, admin_image=? WHERE admin_id=?";
            $stmt = mysqli_prepare($conn, $sql);
    
            mysqli_stmt_bind_param($stmt, "sssi", $email, $password, $newImagesString, $id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script> alert('Admin account has been successfully updated.'); </script>";
                echo "<script> window.location.href = 'manage_admins.php'; </script>"; 
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
    
            mysqli_stmt_close($stmt);
        }
    ?>

    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Image</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Description</th>
                <th class="text-center">Price</th>
                <th class="text-center">Quantity</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT p.ProductID, p.ProductName, p.Price, p.Description, p.productImage, i.Quantity
                FROM products p
                INNER JOIN inventory i ON p.ProductID = i.ProductID";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class=text-center>" . $row["ProductID"] . "</td>";
                        echo '<form method="post" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="update_id" value="' . $row["ProductID"] . '">';
                        echo '<td style="display: flex; justify-content: space-between; align-items: center;">';
                        $currentImages = explode(',', $row['productImage']);
                        foreach ($currentImages as $currentImage) {
                            echo '<img src="../GearUp/uploads/' . $currentImage . '" width="100" height="100" alt="Image">';
                        }
                        echo '<input type="hidden" name="current_images" value="' . implode(',', $currentImages) . '">';
                        echo '<td class=text-center><input type="text" name="ProductName" value="' . $row["ProductName"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="Description" value="' . $row["Description"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="Price" value="' . $row["Price"] . '"></td>';
                        echo '<td class=text-center><input type="text" name="Quantity" value="' . $row["Quantity"] . '"></td>';
                        echo '<td>';
                        echo '</td>';
                        echo '<td>';
                        echo '<div class="col">';
                        echo '<label class="form-label">New Images (Optional):</label>';
                        echo '<input type="file" name="admin_image[]" accept=".jpg, .jpeg, .png" multiple>';
                        echo '</div>';
                        echo '</td>';
                        echo '</form>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }
            ?>
</body>
</html>