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
  form {
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
          <h2>Create Account</h2>
          <ol>
            <li><a href="admin_dash.php">Home</a></li>
            <li>Admins</li>
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
							<form action="admin_create.php" class="signin-form" enctype="multipart/form-data" method="POST">
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Email </label>
							<input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
						        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
		            </div>
                <div class="mb-3">
                    <label class="form-label">Images</label>
                    <input type="file" name="admin_image[]" id="admin_image" accept=".jpg, .jpeg, .png" multiple>
                </div>
		            <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary rounded submit px-3">Create</button>
		            </div>
    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        if ($_FILES['admin_image']['error'][0] === 4) {
          echo "<script> alert('Images do not exist'); </script>";
      } else {
      $imageFilenames = array();
  
      foreach ($_FILES['admin_image']['tmp_name'] as $key => $tmpName) {
          $filename = $_FILES['admin_image']['name'][$key];
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

        if (!empty($email) && !empty($password && !empty($imageString))) {
            $sql = "INSERT INTO admin_account (email, password, admin_image) VALUES (?, ?, ?)";
           
			$stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $email, $password, $imageString);

            if ($stmt->execute()) {
				      echo '<div class="alert alert-success" role="alert">Account Created!</div>';
              echo "<script> window.location.href = 'manage_supplier.php';</script>";
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
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