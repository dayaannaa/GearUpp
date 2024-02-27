<?php
    session_start();
    include "connection.php";

    if(!isset($_SESSION['user_id'])) {
        header("Location: user_login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM user_info WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "User data not found.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['user_image'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["user_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["user_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES["user_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file)) {
                $update_stmt = $conn->prepare("UPDATE user_info SET user_image = ? WHERE user_id = ?");
                $update_stmt->bind_param("si", $target_file, $user_id);
                $update_stmt->execute();
                header("Location: user_profile.php");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <!-- <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
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
</head>
<body>
    <header id="header" class="fixed-top header-inner-pages bg-black">
        <div class="container d-flex align-items-center justify-content-lg-between">

        <h1 class="logo me-auto me-lg-0"><a href="ui.php">GearUp<span>.</span></a></h1>
        <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
            <li><a class="nav-link scrollto" href="ui.php">Home</a></li>
            <!-- <li><a class="nav-link scrollto" href="#team">About</a></li> -->
            <li><a class="nav-link scrollto" href="#">Products</a></li>
            <li><a class="nav-link scrollto" href="resources.php">Resources</a></li>
            <li class="dropdown"><a href="#"><span>Services</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                <li><a href="#">Maintenance</a></li>
                <li><a href="#">Auto Repair</a></li>
                <li><a href="#">Tune Ups</a></li>
                <!-- <li class="dropdown"><a href="#"><span>Services We Offer</span> <i class="bi bi-chevron-right"></i></a> -->
                    <ul> 
                    </ul>
                </li>
                </ul>
            </li>
            <li><a class="nav-link scrollto" href="#">Reviews</a></li>
            <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
            <li><a class="nav-link scrollto" href="user_profile.php">Profile</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <a href="appointment.php" class="get-started-btn scrollto">Book an Appointment</a>

        </div>
    </header>

    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Profile</h2>
          <ol>
            <li><a href="ui.php">Home</a></li>
            <li>Profile</li>
          </ol>
        </div>

      </div>
    </section>

    <form action="user_profile_update.php" method="post" enctype="multipart/form-data">
        <img src="<?php echo $row['user_image']; ?>" alt="User Image" width="150"><?php echo $row['first_name'] . " " . $row['last_name']; ?><br>

        <label for="user_image" id="upload_label">Upload Profile Picture<i class="fa-solid fa-pen-to-square"></i></label><br>

        <input type="file" name="user_image" id="user_image" style="display: none;"><br>

        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>"><br>
        
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" readonly><br>
        
        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>"><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>"><br>
        
        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" value="<?php echo $row['city']; ?>"><br>
        
        <input type="submit" value="Update Profile" name="submit">
    </form>

    <div>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </div>

    <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>GearUp</span></strong>. All Rights Reserved
      </div>
    </div>
    </footer>

    <div id="preloader"></div>

    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <script src="assets/js/main.js"></script>

</body>
</html>