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

    <link href="assets/css/style.css" rel="stylesheet">
</head>
<style>
  .form {
    margin-left: 170px;
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
          <h2>Add Products</h2>
          <ol>
            <li><a href="admin_dash.php">Home</a></li>
            <li>Inventory</li>
          </ol>
        </div>
      </div>
    </section>

    <section class="ftco-section">
			<div class="row justify-content-center">
						<div class="login-wrap">
			      	<div class="d-flex">
								<div class="w-100">
								</div>
			      	</div>
					<form action="inventory_create.php" class="signin-form" enctype="multipart/form-data" method="POST">
			      		<div class="form-group mb-3">
			      			<label class="label" for="ProductName">Product Name </label>
							<input type="text" class="form-control" name="ProductName" id="ProductName" placeholder="Enter Product Name" required>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="Price">Price</label>
						        <input type="text" class="form-control" name="Price" id="Price" placeholder="Price" required>
		            </div>
                    <div class="mb-3">
                        <label class="form-label">Images</label>
                        <input type="file" name="productImage[]" id="productImage" accept=".jpg, .jpeg, .png" multiple>
                    </div>
                    <div class="form-group mb-3">
		            	<label class="label" for="Quantity">Quantity</label>
						<input type="text" class="form-control" name="Quantity" id="Quantity" placeholder="Quantity" required>
		            </div>
                    <div class="form-group mb-3">
		            	<label class="label" for="Description">Description</label>
						<input type="text" class="form-control" name="Description" id="Description" placeholder="Enter Description" required>
		            </div>
		            <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary rounded submit px-3">Create</button>
		            </div>
    </section>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productname = isset($_POST['ProductName']) ? $_POST['ProductName'] : '';
            $price = isset($_POST['Price']) ? $_POST['Price'] : '';
            $desc = isset($_POST['Description']) ? $_POST['Description'] : '';
            $qty = isset($_POST['Quantity']) ? $_POST['Quantity'] : '';
            if ($_FILES['productImage']['error'][0] === 4) {
              echo "<script> alert('Images do not exist'); </script>";
          } else {
          $imageFilenames = array();
      
          foreach ($_FILES['productImage']['tmp_name'] as $key => $tmpName) {
              $filename = $_FILES['productImage']['name'][$key];
              $validImageExtension = ['jpg', 'jpeg', 'png'];
              $imageExtension = explode('.', $filename);
              $imageExtension = strtolower(end($imageExtension));
      
              if (!in_array($imageExtension, $validImageExtension)) {
                  echo "<script> alert('Invalid Image Extension'); </script>";
                  exit();
              } else {
                  $newImageName = uniqid() . '.' . $imageExtension;
                  $targetPath = '../GearUp/uploads/' . $newImageName;
      
                  if (!move_uploaded_file($tmpName, $targetPath)) {
                      echo "Error moving uploaded image to the destination folder.";
                      exit();
                  }
      
                  $imageFilenames[] = $newImageName;
              }
          }
      
          $imageString = implode(',', $imageFilenames);
    
            if (!empty($productname) && !empty($price) && !empty($desc && !empty($imageString))) {
                $sql = "INSERT INTO products (ProductName, Price, Description, productImage) VALUES (?, ?, ?, ?)";
               
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $productname, $price, $desc, $imageString);
    
                if ($stmt->execute()) {
                    $ProductID = $conn->insert_id;

                    $qty = isset($_POST['Quantity']) ? $_POST['Quantity'] : '';
                    $inventorysql = "INSERT INTO inventory (ProductID, Quantity) VALUES (?, ?)";
                    $inventoryStmt = mysqli_prepare($conn, $inventorysql);
                    mysqli_stmt_bind_param($inventoryStmt, "ii", $ProductID, $qty);

                    if ($inventoryStmt->execute()) {
                        echo '<div class="alert alert-success" role="alert">Product Added</div>';
                        echo "<script> window.location.href = 'manage_inventory.php';</script>";
                    }
                    else {
                        echo '<div class="alert alert-danger" role="alert">Error inserting into Inventory: ' . $conn->error . '</div>';
                    }
                    mysqli_stmt_close($inventoryStmt);

                } else {
                    echo '<div class="alert alert-danger" role="alert">Error inserting into Products: ' . $conn->error . '</div>';
                }
                $stmt->close();
            } else {
                echo '<div class="alert alert-warning" role="alert">Please fill all the fields.</div>'; 
    
            }

          }
        }
        $conn->close();
    ?>
    
</body>
</html>