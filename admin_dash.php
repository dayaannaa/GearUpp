<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

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
    h1 {
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .icon-box {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .icon-box .material-symbols-outlined {
      font-size: 30px; 
      order: 2;
    }

    .icon-box-content {
      order: 1; 
    }
    
</style>
<body>

  <?php
  include "connection.php";

    function getCount($conn, $tableName) {
      $sql = "SELECT COUNT(*) AS count FROM " . $tableName;
      $result = $conn->query($sql);

      if ($result && $row = $result->fetch_assoc()) {
          return $row['count'];
      }

      return 0;
    }

    $adminsCount = getCount($conn, "admin_account");
    $usersCount = getCount($conn, "user_info");
    $appointmentsCount = getCount($conn, "appointment");
    $productsCount = getCount($conn, "products");
    $suppliersCount = getCount($conn, "supplier");

    $conn->close();
  ?>

<section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container">

    <div class="row justify-content-center">
        <div>
          <h1>Elevate With GearUp<span>.</span></h1>
        </div>
      </div>

      <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
      <div class="col-xl-3 col-md-4">
        <div class="icon-box">
          <span class="material-symbols-outlined text-warning col-xl-4 col-md-4">dashboard</span>
          <div class="icon-box-content">
            <p class="text-white fs-4"><?php echo $adminsCount; ?></p> 
            <h3><a href="manage_admins.php">Admins</a></h3>
          </div>
        </div>
      </div>
      
      <div class="col-xl-4 col-md-4">
        <div class="icon-box">
          <span class="material-symbols-outlined text-warning col-xl-4 col-md-4">schedule</span>
          <div class="icon-box-content">
            <p class="text-white fs-4"><?php echo $appointmentsCount; ?></p> 
            <h3><a href="">Appointment</a></h3>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-4">
        <div class="icon-box">
          <span class="material-symbols-outlined text-warning col-xl-4 col-md-4">person</span>
          <div class="icon-box-content">
            <p class="text-white fs-4"><?php echo $usersCount; ?></p> 
            <h3><a href="manage_users.php">Users</a></h3>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="icon-box">
          <span class="material-symbols-outlined text-warning">inventory</span>
          <div class="icon-box-content">
            <p class="text-white fs-4"><?php echo $productsCount; ?></p> 
            <h3><a href="">Products</a></h3>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="icon-box">
          <span class="material-symbols-outlined text-warning">group</span>
          <div class="icon-box-content">
            <p class="text-white fs-4"><?php echo $suppliersCount; ?></p> 
            <h3><a href="">Supplier </a></h3>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
  include "sidebar.html";
  include "footer.html";
?>
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