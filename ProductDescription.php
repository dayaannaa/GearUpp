<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Portfolio Details - Gp Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        .portfolio-info-box {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .portfolio-info-box .portfolio-info h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }

        .portfolio-info-box .portfolio-info ul {
            list-style: none;
            padding: 0;
        }

        .portfolio-info-box .portfolio-info ul li {
            margin-bottom: 10px;
        }

        .portfolio-description h3 {
            font-size: 18px;
            margin-top: 20px;
        }
    </style>

    <!-- =======================================================
    * Template Name: Gp
    * Updated: Jan 29 2024 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top header-inner-pages">
        <div class="container d-flex align-items-center justify-content-lg-between">

            <h1 class="logo me-auto me-lg-0"><a href="index.html">Gp<span>.</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto " href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#services">Services</a></li>
                    <li><a class="nav-link scrollto active" href="#portfolio">Portfolio</a></li>
                    <li><a class="nav-link scrollto" href="#team">Team</a></li>
                    <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            <a href="#about" class="get-started-btn scrollto">Get Started</a>

        </div>
    </header><!-- End Header -->

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Products</h2>
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li>Products</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->
 
        <section>
            <?php
            include "connection.php";
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the product name from the URL parameter
            $productName = $_GET['ProductName'];

            // Fetch data from the products table for the selected product
            $sql = "SELECT ProductName, Description, Price, ProductImage FROM products WHERE ProductName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $productName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="row gy-4">
                        <div class="col-lg-8">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row["ProductImage"]); ?>" alt="<?php echo $row["ProductName"]; ?>">
                        </div>
                        <div class="col-lg-4">
                            <div class="portfolio-info-box">
                                <div class="portfolio-info">
                                    <h3>Product Information</h3>
                                    <ul>
                                        <li><strong>Product Name</strong>: <?php echo $row["ProductName"]; ?></li>
                                        <li><strong>Price</strong>: ₱<?php echo $row["Price"]; ?></li>
                                    </ul>
                                </div>
                                <div class="portfolio-description">
                                    <h3><?php echo $row["Description"]; ?></h3>
                                    <!-- If you want to display additional information, you can add it here -->
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "Product not found";
            }

            $conn->close();
            ?>

        </section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <!-- Footer content -->
    </footer><!-- End Footer -->

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
