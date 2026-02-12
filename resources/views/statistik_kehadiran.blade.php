@extends('layouts.apps')

@section('title',' - Statistik Kehadiran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/statistikKehadiran.css') }}">
@endpush

@section('content')

@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light-secondary bg-secondary shadow'])

    <div class="stat-kehadiran-wrapper">

        <!-- Enhanced Header Section with Gradient & Icons -->
        <div class="stat-kehadiran-hero">
            <div class="stat-hero-content">
                <h1 class="stat-hero-title gabarito-regular">
                    Statistik Kehadiran Kursus
                </h1>
                <p class="stat-hero-subtitle">
                    Pantau dan analisis data kehadiran kursus dengan mudah
                </p>
            </div>
        </div>
        
        <!--Enhanced Card Search Section-->
        <div class="stat-main-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                    </svg>
                </div>
                <h4 class="stat-card-title gabarito-regular">
                    Data Rekod Pencapaian Kehadiran Kursus
                </h4>
            </div>
            

            <div class="stat-card-body">
                <!--Enhanced Filter Section-->
                <div class="stat-filter-grid">
                    <div class="stat-filter-item">
                        <label class="stat-filter-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            Tahun
                        </label>
                        <div class="stat-dropdown-wrapper">
                            <button type="button" id="tahunDropdown" name="tahun" class="stat-dropdown-btn" data-bs-toggle="dropdown">
                                <span class="stat-dropdown-value">2025</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu stat-dropdown-menu" id="tahunMenu">
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2026">2026</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2025">2025</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2024">2024</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2023">2023</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2022">2022</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2021">2021</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2020">2020</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2019">2019</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2018">2018</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2017">2017</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2016">2016</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2015">2015</a></li>
                                <li><a href="#" class="dropdown-item stat-dropdown-item" data-value="2014">2014</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="stat-filter-item">
                        <label class="stat-filter-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            Perjawatan
                        </label>
                        <div class="stat-dropdown-wrapper">
                            <button type="button" name="lantikan" id="lantikanDropdown" class="stat-dropdown-btn" data-bs-toggle="dropdown">
                                <span class="stat-dropdown-value">PERJAWATAN</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu stat-dropdown-menu">
                                <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="Tetap">Tetap</a></li>
                                <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="Kontrak">Kontrak</a></li>
                                <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="Sementara">Sementara</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="stat-filter-submit">
                        <button class="stat-submit-btn" id="btnHantar">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Search
                        </button>
                    </div>
                </div>

                <!-- Enhanced Department Selection -->
                <div class="stat-department-section">
                    <label class="stat-department-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
                            <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z"/>
                        </svg>
                        Sila buat pilihan jabatan
                    </label>
                    <div class="stat-dropdown-wrapper-center">
                        <button name="jabatan" class="stat-department-btn" type="button" id="jabatanDropdown" data-bs-toggle="dropdown">
                            <span class="stat-department-text">KLIK SINI UNTUK PILIHAN JABATAN</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu stat-dropdown-menu-wide" id="jabatanList">
                            <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH</a></li>
                            <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="BAHAGIAN KERAJAAN TEMPATAN">BAHAGIAN KERAJAAN TEMPATAN</a></li>
                            <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="BAHAGIAN PENGURUSAN SUMBER MANUSIA NEGERI KEDAH">BAHAGIAN PENGURUSAN SUMBER MANUSIA NEGERI KEDAH</a></li>
                            <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="SURUHANJAYA PERKHIDMATAN AWAM">SURUHANJAYA PERKHIDMATAN AWAM</a></li>
                            <li><a class="dropdown-item stat-dropdown-item" href="#" data-value="BAHAGIAN PERANCANG EKONOMI NEGERI KEDAH">BAHAGIAN PERANCANG EKONOMI NEGERI KEDAH</a></li>
                        </ul>
                    </div>
                </div>

                <!--Result Container-->
                <div id="resultContainer" class="stat-result-area">
                    <!--fetch table here from statistik_kehadiran.js-->
                </div>

                {{-- Footer Container--}}
                <div class="stat-card-footer">
                    <p class="stat-footer-text">Hubungi Penyelaras</p>
                    <p class="stat-footer-copyright">Copyright © 2025 | ePSM | BTMK</p>
                </div>
            </div>
        </div>
    </div><!--end main-->
    <!--Footer-->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container text-center">
            <p class="text-white mb-0">© 2025 ePSM. Semua Hak Terpelihara.</p>
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