<?php
    session_start();

    //check session
    if(!isset($_SESSION['user_id'])){
        header("Location: login.html");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>ePSM BPSM - Galeri</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="ePSM, EPSM, Bahagian Sumber Manusia SUK, SUK Kedah" name="keywords">
        <meta content="ePSM BPSM adalah satu sistem yang ditubuhkan kepada BPSM SUK Negeri Kedah" name="description">
        <link rel="icon" href="cropped-kedah-baru.png">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="text-primary"><img src="cropped-kedah-baru.png" alt="Logo Negeri Kedah" class="me-3" style="height:40px;"></i>e-PSM BPSM</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">                        
                        <?php
                            include "navbar.php";
                        ?>
                        <!-- <a href="logout.php">logout</a>-->
                    </div>  
                </div>
            </nav>

            <!-- Header Start -->
            <div class="container-fluid bg-breadcrumb">
                <div class="container text-center py-5" style="max-width: 900px;">
                    <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">GALERI</h4>
                    <!--
                      <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                          <li class="breadcrumb-item"><a href="#">Pages</a></li>
                          <li class="breadcrumb-item active text-primary">News & Blog</li>
                      </ol>
                    -->     
                </div>
            </div>
            <!-- Header End -->
        </div>
        <!-- Navbar & Hero End -->

        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h4 class="modal-title mb-0" id="exampleModalLabel">Search by keyword</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text btn border p-3"><i class="fa fa-search text-white"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->

<!-- Gallery Start -->
<div class="container-fluid py-5 bg-light mt-5">
  <div class="container py-5">
    <div class="text-center mx-auto pb-5" style="max-width: 800px;">
      <h4 class="text-uppercase text-primary">Galeri Rasmi</h4>
      <h1 class="display-5 text-capitalize mb-3">Dokumentasi Aktiviti & Program</h1>
      <p class="mb-0">
        Lihat semula momen penting melalui koleksi gambar rasmi program, bengkel, dan aktiviti kami.
      </p>
    </div>

    <!-- Filter (optional) -->
    <div class="text-center mb-5">
      <button class="btn btn-outline-primary mx-2 active" data-filter="all">Semua</button>
      <button class="btn btn-outline-primary mx-2" data-filter="program">Program</button>
      <button class="btn btn-outline-primary mx-2" data-filter="aktiviti">Aktiviti</button>
      <button class="btn btn-outline-primary mx-2" data-filter="lawatan">Lawatan</button>
      <button class="btn btn-outline-primary mx-2" data-filter="bengkel">Bengkel</button>
    </div>

    <div class="row g-4 portfolio-container">
      <!-- Item 1 -->
      <div class="col-lg-4 col-md-6 portfolio-item program wow fadeInUp" data-wow-delay="0.1s">
        <div class="card border-2 shadow">
          <img src="cropped-kedah-baru.png" class="card-img-top" alt="Program Inovasi 2025">
          <div class="card-body text-center">
            <h5 class="card-title">Program Inovasi 2025</h5>
            <p class="text-muted mb-2">Anjuran bersama agensi tempatan</p>
            <a href="img/gallery-1.jpg" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#galleryModal1">
              Lihat Gambar
            </a>
          </div>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="col-lg-4 col-md-6 portfolio-item aktiviti wow fadeInUp" data-wow-delay="0.2s">
        <div class="card border-2 shadow">
          <img src="cropped-kedah-baru.png" class="card-img-top" alt="Aktiviti Gotong-Royong">
          <div class="card-body text-center">
            <h5 class="card-title">Aktiviti Gotong-Royong</h5>
            <p class="text-muted mb-2">Bersama komuniti setempat</p>
            <a href="img/gallery-2.jpg" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#galleryModal2">
              Lihat Gambar
            </a>
          </div>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="col-lg-4 col-md-6 portfolio-item lawatan wow fadeInUp" data-wow-delay="0.3s">
        <div class="card border-2 shadow">
          <img src="cropped-kedah-baru.png" class="card-img-top" alt="Lawatan Rasmi">
          <div class="card-body text-center">
            <h5 class="card-title">Lawatan Rasmi</h5>
            <p class="text-muted mb-2">Ke Jabatan Luar</p>
            <a href="img/gallery-3.jpg" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#galleryModal3">
              Lihat Gambar
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Gallery End -->

<!-- Modal Gambar -->
<div class="modal fade" id="galleryModal1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <img src="img/gallery-1.jpg" class="img-fluid rounded" alt="">
    </div>
  </div>
</div>

<div class="modal fade" id="galleryModal2" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <img src="img/gallery-2.jpg" class="img-fluid rounded" alt="">
    </div>
  </div>
</div>

<div class="modal fade" id="galleryModal3" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <img src="img/gallery-3.jpg" class="img-fluid rounded" alt="">
    </div>
  </div>
</div>


        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                        <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="container text-center">
                    <p class="text-white mb-0">© 2025 ePSM Helpdesk. Semua Hak Terpelihara.</p>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        



        <!-- Back to Top -->
        <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>