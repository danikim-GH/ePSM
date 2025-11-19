@extends('layouts.apps')

@section('title',' - Statistik Kehadiran')

@section('content')

    @include('components.spinnerLoading')

    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <h1 class="text-primary righteous-regular"><img src="assets/img/cropped-kedah-baru.png" alt="Logo Negeri Kedah" class="me-3" style="height:40px;"></i>
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
        <!-- Carousel Start -->
        <div class="carousel-header">
            <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="assets/img/statistic_graph.jpg" class="img-fluid w-100" alt="Image" style="height: 700px; object-fit: cover;">
                        <div class="carousel-caption-1">
                            <div class="carousel-caption-1-content" style="max-width: 900px;">
                                <h4 class="text-white text-uppercase fw-bold mb-4 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;" style="letter-spacing: 3px;">Importance life</h4>
                                <h1 class="display-2 text-capitalize text-white mb-4 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1.3s" style="animation-delay: 1.3s;">Always Want Safe Water For Healthy Life</h1>
                                <p class="mb-5 fs-5 text-white fadeInLeft animated" data-animation="fadeInLeft" data-delay="1.5s" style="animation-delay: 1.5s;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                                </p>
                                <div class="carousel-caption-1-content-btn fadeInLeft animated" data-animation="fadeInLeft" data-delay="1.7s" style="animation-delay: 1.7s;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/img/kedah_scenery2.jpg" class="img-fluid w-100" alt="Image" style="height: 700px; object-fit: cover;">
                        <div class="carousel-caption-2">
                            <div class="carousel-caption-2-content" style="max-width: 900px;">
                                <h4 class="text-white text-uppercase fw-bold mb-4 fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;" style="letter-spacing: 3px;">Importance life</h4>
                                <h1 class="display-2 text-capitalize text-white mb-4 fadeInRight animated" data-animation="fadeInRight" data-delay="1.3s" style="animation-delay: 1.3s;">Always Want Safe Water For Healthy Life</h1>
                                <p class="mb-5 fs-5 text-white fadeInRight animated" data-animation="fadeInRight" data-delay="1.5s" style="animation-delay: 1.5s;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                                </p>
                                <div class="carousel-caption-2-content-btn fadeInRight animated" data-animation="fadeInRight" data-delay="1.7s" style="animation-delay: 1.7s;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon btn btn-primary fadeInLeft animated" aria-hidden="true" data-animation="fadeInLeft" data-delay="1.1s" style="animation-delay: 1.3s;"> <i class="fa fa-angle-left fa-3x"></i></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                    <span class="carousel-control-next-icon btn btn-primary fadeInRight animated" aria-hidden="true" data-animation="fadeInLeft" data-delay="1.1s" style="animation-delay: 1.3s;"><i class="fa fa-angle-right fa-3x"></i></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->
    </div>
    <!-- Navbar & Hero End -->

    <div class="container py-5">
        <div class="card shadow-sm border-0 border-rounded">
            <div class="card-body">
                <h4 class="text-center fw-bold mb-4 text-uppercase">
                    data rekod pencapaian kehadiran kursus
                </h4>
                
                <!--dropwdown tahun apa semua-->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8 text-center">
                        <div class="d-inline-block me-3">
                            <label for="tahun" class="fw-semibold me-1">Tahun:</label>
                            <div class="btn-group">
                                <button type="button" id="tahunDropdown" name="tahun" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    2025
                                </button>
                                <ul class="dropdown-menu" id="tahunMenu">
                                    <li><a href="#" class="dropdown-item" data-value="2025">2025</a></li>
                                    <li><a href="#" class="dropdown-item" data-value="2024">2024</a></li>
                                    <li><a href="#" class="dropdown-item" data-value="2023">2023</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-inline-block me-3">
                            <label for="perjawatan" class="fw-semibold me-1">Bagi Perjawatan:</label>
                            <div class="btn-group">
                                <button type="button" name="lantikan" id="lantikanDropdown" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    PERJAWATAN
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-value="Tetap" >Tetap</a></li>
                                    <li><a class="dropdown-item" href="#" data-value="Kontrak">Kontrak</a></li>
                                    <li><a class="dropdown-item" href="#" data-value="Sementara" >Sementara</a></li>
                                </ul>
                            </div>
                        </div>

                        <button class="btn btn-primary" id="btnHantar">Hantar</button>
                    </div>
                </div>

                <!-- Pilihan Jabatan -->
                <div class="d-flex flex-column align-items-center mb-4">
                    <label for="jabatanDropdown" class="fw-semibold mb-2 text-dark">
                        Sila buat pilihan jabatan:
                    </label>
                    <div class="dropdown-center">
                        <button name="jabatan" class="btn btn-outline-primary dropdown-toggle text-uppercase" type="button" id="jabatanDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            KLIK SINI UNTUK PILIHAN JABATAN
                        </button>
                        <ul class="dropdown-menu" id="jabatanList">
                            <li><a class="dropdown-item" href="#" data-value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH</a></li>
                            <li><a class="dropdown-item" href="#" data-value="BAHAGIAN KEWANGAN NEGERI KEDAH">BAHAGIAN KEWANGAN NEGERI KEDAH</a></li>
                            <li><a class="dropdown-item" href="#" data-value="BAHAGIAN SUMBER MANUSIA NEGERI KEDAH">BAHAGIAN SUMBER MANUSIA NEGERI KEDAH</a></li>
                            <li><a class="dropdown-item" href="#" data-value="BAHAGIAN PENTADBIRAN NEGERI KEDAH">BAHAGIAN PENTADBIRAN NEGERI KEDAH</a></li>
                            <li><a class="dropdown-item" href="#" data-value="BAHAGIAN PERANCANGAN STRATEGIK NEGERI KEDAH">BAHAGIAN PERANCANGAN STRATEGIK NEGERI KEDAH</a></li>
                        </ul>
                    </div>
                </div>

                <!--NEW-->
                <div id="resultContainer" class="mt-4 text-center">
                    <!--fetch table here-->
                </div>

                {{-- Footer Container--}}
                <div class="text-center mt-4 small text-muted">
                    Hubungi BSM<br>
                    Copyright © 2014 | PTMK
                </div>
            </div>
        </div>
    </div><!--end main-->

    <!--FOoter-->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container text-center">
            <p class="text-white mb-0">© 2025 ePSM BPSM. Semua Hak Terpelihara.</p>
        </div>
    </div>
    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top">
        <i class="fa fa-arrow-up"></i>
    </a>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/statistik_kehadiran.js')}}"></script>
@endpush