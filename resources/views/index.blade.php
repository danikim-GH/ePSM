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
            @include('layouts.logo-on-navbar')
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
                <h1 class="text-uppercase gabarito-regular">Pilihan</h1>
                <p class="text-muted">Pilih tindakan di bawah untuk mengurus pendaftaran, maklumat, dan berkaitan.</p>
            </div>

            <!-- Dynamic Menu Cards Container -->
            <div class="row g-4 justify-content-center" id="dynamicMenuContainer">
                <!-- Loading Spinner -->
                <div class="col-12 text-center" id="menuLoadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading menu...</p>
                </div>
                
                <!-- Menu items will be dynamically inserted here -->
            </div>
        </div>
    </div>
    <!-- feature End -->

    <!-- Enhanced Calendar Section -->
    <section class="py-5 bg-gradient-light">
        <div class="container calendar-cont">
            <div class="calendar-hero wow fadeInUp" data-wow-delay="0.3s">
                <div class="calendar-hero-content wow fadeInUp" data-wow-delay="0.3s">
                    <h1 class="calendar-hero-title gabarito-regular">
                        Kalendar Kursus
                    </h1>
                </div>
            </div>

            <!-- Calendar Controls -->
            <div class="calendar-controls-wrapper mb-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="calendar-stats">
                            <div class="stat-item">
                                <i class="fas fa-book-open"></i>
                                <span id="totalCoursesCount">0</span>
                                <span class="stat-label">Kursus</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="view-toggle-group">
                            <button class="btn-view-toggle active" data-view="dayGridMonth">
                                <i class="fas fa-calendar"></i>
                                <span>Bulan</span>
                            </button>
                            <button class="btn-view-toggle" data-view="listMonth">
                                <i class="fas fa-list"></i>
                                <span>Senarai</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="calendar-legend">
                            <div class="legend-item">
                                <span class="legend-dot upcoming"></span>
                                <span>Akan Datang</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot ongoing"></span>
                                <span>Sedang Berjalan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Container -->
            <div class="calendar-container wow fadeInUp" data-wow-delay="0.3s">
                <div id="calendar"></div>
            </div>

            <!-- Enhanced Kursus Kalendar Modal -->
            <div class="modal fade" id="kursusModal" tabindex="-1" aria-labelledby="modalKursusTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content modern-modal">
                        <div class="modal-header border-0">
                            <div class="modal-header-content">
                                <i class="fas fa-calendar-day modal-icon"></i>
                                <div>
                                    <h5 class="modal-title gabarito-regular" id="modalKursusTitle">Senarai Kursus</h5>
                                    <p class="modal-subtitle" id="modalKursusDate"></p>
                                </div>
                            </div>
                            <button type="button" class="btn-close-modern" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="modalKursusBody">
                            <!-- Course list will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!--takguna-->
    <!-- Footer -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="footer-text-container text-center">
            <p class="text-white mb-0">© 2025 ePSM BPSM. Semua Hak Terpelihara.</p>
        </div>
    </div>



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