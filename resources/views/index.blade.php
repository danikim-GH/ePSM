@extends('layouts.apps')

@section('title', ' - Home')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
@endpush

@section('content')

    @include('components.spinnerLoading')

        
    @guest('lampirana')
        <a href="{{ route('login.show') }}">Login</a>
    @endguest

    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0 wow" data-wow-delay="0ms" style="visibility: visible; animation-delay: 0ms; animation-name: fadeInDown;">
                <h1 class="text-primary righteous-regular"><img src="assets/img/cropped-kedah-baru.png" alt="Logo Negeri Kedah" class="me-3" style="height:40px;">
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
        <!-- Navbar & Hero End -->
        @include('layouts.carousel')
    </div>

    
    <!-- feature Start -->
    <div class="container-fluid feature bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px; visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <h1 class="text-uppercase text-primary gabarito-regular">Pilihan</h1>
                <h3 class="display-5 text-capitalize mb-3 gabarito-regular">Urus Kursus Anda</h3>
                <p class="text-muted">Pilih tindakan di bawah untuk mengurus pendaftaran, maklumat, dan jadual kursus anda.</p>
            </div>

            <!-- Dynamic Menu Cards Container -->
            <div class="row g-4 justify-content-center" id="dynamicMenuContainer">
                <!-- Loading Spinner -->
                <div class="col-12 text-center" id="menuLoadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuatkan menu...</p>
                </div>
                
                <!-- Menu items will be dynamically inserted here -->
            </div>
        </div>
    </div>
    <!-- feature End -->

    <!-- Calendar Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-4 pt-sans-bold">Kalendar Kursus</h2>
            <div id="calendar" class="mb-5  wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">
                <div class="modal fade" id="kursusModal" tabindex="-1" aria-labelledby="modalKursusTitle" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalKursusTitle">Senarai Kursus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="modalKursusBody">
                                <!-- Senarai kursus letak sini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!--takguna-->

    <!-- Footer Start -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5 mb-5 align-items-center">
                <div class="col-lg-7">
                    <div class="position-relative mx-auto">
                        <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Email address to Subscribe">
                        <button type="button" class="btn btn-secondary rounded-pill position-absolute top-0 end-0 py-2 px-4 mt-2 me-2">Subscribe</button>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                        <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-secondary btn-md-square rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <div class="footer-item">
                            <h3 class="text-white mb-4"><i class="fas fa-hand-holding-water text-primary me-3"></i>Acuas</h3>
                            <p class="mb-3">Dolor amet sit justo amet elitr clita ipsum elitr est.Lorem ipsum dolor sit amet, consectetur adipiscing elit consectetur adipiscing elit.</p>
                        </div>
                        <div class="position-relative">
                            <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                            <button type="button" class="btn btn-secondary rounded-pill position-absolute top-0 end-0 py-2 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">About Us</h4>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Why Choose Us</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Free Water Bottles</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Water Dispensers</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Bottled Water Coolers</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Contact us</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Terms & Conditions</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Business Hours</h4>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Mon - Friday:</h6>
                            <p class="text-white mb-0">09.00 am to 07.00 pm</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Saturday:</h6>
                            <p class="text-white mb-0">10.00 am to 05.00 pm</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-0">Vacation:</h6>
                            <p class="text-white mb-0">All Sunday is our vacation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item d-flex flex-column">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <a href="#"><i class="fa fa-map-marker-alt me-2"></i> 123 Street, New York, USA</a>
                        <a href="mailto:info@example.com"><i class="fas fa-envelope me-2"></i> info@example.com</a>
                        <a href="mailto:info@example.com"><i class="fas fa-envelope me-2"></i> info@example.com</a>
                        <a href="tel:+012 345 67890"><i class="fas fa-phone me-2"></i> +012 345 67890</a>
                        <a href="tel:+012 345 67890" class="mb-3"><i class="fas fa-print me-2"></i> +012 345 67890</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    
    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end text-body">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Designed By <a class="border-bottom text-white" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom text-white" href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


@include('components.backToTop')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="{{ asset("assets/js/daftar_kursus.js") }}"></script>

    {{-- Additional JS library --}}
    <script src="{{ asset("assets/lib/easing/easing.min.js") }}"></script>
    <script src="{{ asset("assets/lib/waypoints/waypoints.min.js") }}"></script>
    <script src="{{ asset("assets/lib/counterup/counterup.min.js") }}"></script>
    <script src="{{ asset("assets/js/dynamic-menu.js") }}"></script>
@endpush