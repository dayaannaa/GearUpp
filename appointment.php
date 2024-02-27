<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Appointment</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

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
  <?php
  include "header.html";
  ?>

  <main id="main">

    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Schedule an Appointment</h2>
          <ol>
            <li><a href="ui.php">Home</a></li>
            <li>Appointment</li>
          </ol>
        </div>

      </div>
    </section>

    <section class="inner-page">
      <div class="container">
        <p>
        <div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3 border p-4 shadow bg-light">
            <div class="col-12">
                <h3 class="fw-normal text-secondary fs-4 text-uppercase mb-4">Appointment form SAMPLE P LANG TO</h3>
            </div>
            <form action="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="First Name">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="col-md-6">
                        <input type="tel" class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" placeholder="Enter Email">
                    </div>
                    <div class="col-md-6">
                        <input type="date" class="form-control" placeholder="Enter Date">
                    </div>
                    <div class="col-md-6">
                        <input type="time" class="form-control" placeholder="Enter Email">
                    </div>
                    <div class="col-12">
                        <select class="form-select">
                            <option selected>Purpose Of Appointment</option>
                            <option value="1">Web Design</option>
                            <option value="2">Web Development</option>
                            <option value="3">IOS Developemt</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <textarea class="form-control" placeholder="Message"></textarea>
                    </div>
                    <div class="col-12 mt-5">                        
                        <button type="submit" class="btn btn-primary float-end">Book Appointment</button>
                        <button type="button" class="btn btn-outline-secondary float-end me-2">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div></p>
    </div>
</section>

  </main>

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