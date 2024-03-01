<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Resources</title>
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
          <h2>PRODUCTS</h2>
          <ol>
            <li><a href="ui.php">Home</a></li>
            <li>Products</li>
          </ol>
        </div>

      </div>
    </section>

    <section class="inner-page">
      <div class="container">
        <p>
        </p>
      </div>
    </section>

  </main>

  <?php
  include "footer.html";
  ?>

  <div id="preloader"></div>

  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script src="assets/js/main.js"></script>

  <?php
            include "connection.php";
            $product_id = isset($_GET['id']) ? $_GET['id'] : null; 
            $sql = "SELECT * FROM products WHERE id = $product_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            ?>

<section id="portfolio-details" class="portfolio-details">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="portfolio-details-slider swiper">
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide">
                            <img src="assets/img/portfolio/<?php echo $row['image1']; ?>" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/img/portfolio/<?php echo $row['image2']; ?>" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/img/portfolio/<?php echo $row['image3']; ?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="portfolio-info">
                    <h3>Project information</h3>
                    <ul>
                        <li><strong>Category</strong>: <?php echo $row['category']; ?></li>
                        <li><strong>Client</strong>: <?php echo $row['client']; ?></li>
                        <li><strong>Project date</strong>: <?php echo $row['project_date']; ?></li>
                        <li><strong>Project URL</strong>: <a href="<?php echo $row['project_url']; ?>"><?php echo $row['project_url']; ?></a></li>
                    </ul>
                </div>
                <div class="portfolio-description">
                    <h2><?php echo $row['name']; ?></h2>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
} else {
    echo "Product not found";
}

$conn->close();
?>


</body>

</html>