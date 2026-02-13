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
    <meta charset="utf-8" />
    <title>ePSM BPSM - Helpdesk Aduan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
  </head>

  <body>
        <!-- Spinner Start -->
        <div id="spinner"class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary"style="width: 3rem; height: 3rem"role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
        <?php 
          $navbarClass = "navbar-light bg-dark shadow"; // putih solid untuk helpdesk
          include "navbar_wrapper.php"; // kita guna wrapper baru
        ?>

    <!-- Helpdesk Form Start -->
    <div class="container-fluid contact bg-light py-5 mt-5">
      <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px">
          <h4 class="text-uppercase text-primary">Sistem Aduan Helpdesk</h4>
          <h1 class="display-5 text-capitalize mb-3">Hantar Aduan Anda</h1>
          <p class="mb-0">
            Sila isikan borang di bawah untuk menghantar aduan atau pertanyaan anda.
            Pihak kami akan menghubungi anda dalam masa terdekat.
          </p>
        </div>

        <form id="helpdeskForm" action="#" method="POST">
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control border-0"
                  id="name"
                  name="name"
                  placeholder="Nama Penuh"
                  required
                />
                <label for="name">Nama Penuh</label>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating">
                <input
                  type="email"
                  class="form-control border-0"
                  id="email"
                  name="email"
                  placeholder="Emel"
                  required
                />
                <label for="email">Alamat Emel</label>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control border-0"
                  id="phone"
                  name="phone"
                  placeholder="No Telefon"
                />
                <label for="phone">No. Telefon</label>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating">
                <select
                  class="form-select border-0"
                  id="kategori"
                  name="kategori"
                  required
                >
                  <option value="" selected disabled>Pilih Kategori Aduan</option>
                  <option value="Teknikal">Isu Teknikal</option>
                  <option value="Akaun">Isu Akaun / Log Masuk</option>
                  <option value="Tempahan">Masalah Tempahan</option>
                  <option value="Lain">Lain-lain</option>
                </select>
                <label for="kategori">Kategori Aduan</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control border-0"
                  id="subject"
                  name="subject"
                  placeholder="Subjek Aduan"
                  required
                />
                <label for="subject">Subjek Aduan</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating">
                <textarea
                  class="form-control border-0"
                  placeholder="Taip mesej di sini"
                  id="message"
                  name="message"
                  style="height: 175px"
                  required
                ></textarea>
                <label for="message">Butiran Aduan</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100 py-3">
                Hantar Aduan
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Helpdesk Form End -->

    <!-- Footer -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
      <div class="container text-center">
        <p class="text-white mb-0">© 2025 ePSM Helpdesk. Semua Hak Terpelihara.</p>
      </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"
      ><i class="fa fa-arrow-up"></i
    ></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
