@extends('layouts.apps')

@section('title',' - Galeri')

@section('content')

  <!-- Navbar & Hero Start -->
  <div class="container-fluid position-relative p-0">
          <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
              <a href="" class="navbar-brand p-0">
                  <h1 class="text-primary"><img src="assets/img/cropped-kedah-baru.png" alt="Logo Negeri Kedah" class="me-3" style="height:40px;"></i>
                      ePSM
                  </h1>
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                  <span class="fa fa-bars"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                  <div class="navbar-nav ms-auto py-0">                        
                      @include('partials.navbar')
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
    <img src="assets/img/cropped-kedah-baru.png" class="card-img-top" alt="Program Inovasi 2025">
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
    <img src="assets/img/cropped-kedah-baru.png" class="card-img-top" alt="Aktiviti Gotong-Royong">
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
    <img src="assets/img/cropped-kedah-baru.png" class="card-img-top" alt="Lawatan Rasmi">
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

@endsection
