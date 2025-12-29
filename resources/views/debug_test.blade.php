@extends('layouts.apps')

@section('title', ' - Debug Test Page')

@section('content')
    <!-- feature Start -->
    <div class="container-fluid feature bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px; visibility: visible; animation-delay: 0.2s; animation-name: jackInTheBox;">
                <h1 class="text-uppercase text-primary righteous-regular">Pilihan</h1>
                <h3 class="display-5 text-capitalize mb-3 pt-sans-bold">Urus Kursus Anda</h3>
                <p class="text-muted">Pilih tindakan di bawah untuk mengurus pendaftaran, maklumat, dan jadual kursus anda.</p>
            </div>

            <div class="row g-4 justify-content-center ">
                <!-- Card 1: Daftar Kursus -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <a href="{{ route('kursus.store') }}" class="text-decoration-none">
                        <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between" data-bs-toggle="#" data-bs-target="#" style="cursor:pointer;">
                            <div>
                                <div class="feature-icon mb-3 mx-auto wow" style="visibility: visible; animation-delay: 0.5s; animation-name: jackInTheBox;"><i class="fas fa-edit text-white fa-3x" ></i></div>
                                <h5 class="mb-3 pt-sans-bold">Daftar Kursus</h5>
                                <p class="mb-0">Isi maklumat kursus baharu.</p>
                            </div>
                        </div>
                    </a>    
                </div>
                <!-- Card 2 -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp; cursor: pointer;">
                    <a href="{{route('senarai.index')}}" class="text-decoration-none">
                        <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                            <div>
                                <div class="feature-icon mb-3 mx-auto wow" style="visibility: visible; animation-delay: 0.5s; animation-name: hinge;"><i class="fas fa-list text-white fa-3x"></i></div>
                                <h5 class="mb-3 pt-sans-bold">Senarai Kursus</h5>
                                <p class="mb-0">Lihat senarai kursus.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Card 3 -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp; cursor: pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="fa fa-list-alt text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Senarai Permohonan Kursus</h5>
                            <p class="mb-0">Lihat senarai permohonan kursus.</p><br>
                        </div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp; cursor: pointer;"> 
                    <a href="{{ route('statistik-kehadiran') }}">
                        <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                            <div>    
                                <div class="feature-icon mb-3 mx-auto"><i class="bi bi-graph-up text-white fa-3x"></i></div>
                                <h5 class="mb-3 pt-sans-bold">Statistik Kehadiran</h5>
                                <p class="mb-0">Lihat kehadiran kursus.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Card 5 -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.6s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-person-lines-fill text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Laporan Penilaian Keberkesanan Kursus</h5>
                            <p class="mb-0">Laporan penilain.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 6 -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-chat-square-text text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Mesej Admin</h5>
                            <p class="mb-0">Mesej admin lebih lanjut.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 7 -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.8s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-file-excel-fill text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Undian</h5>
                            <p class="mb-0">Undian.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 8 -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.9s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-archive-fill text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Arkib</h5>
                            <p class="mb-0">Arkib ePSM.</p>
                        </div>
                    </div>
                </div>
                <!--Card 9-->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.9s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-cup-hot-fill text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Perkhidmatan</h5>
                            <p class="mb-0">Perkhidmatan di ePSM.</p>
                        </div>
                    </div>
                </div>
                <!--Card 9-->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.9s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-chevron-double-up text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Kenaikan Pangkat</h5>
                            <p class="mb-0">Kenaikan.</p>
                        </div>
                    </div>
                </div>
                <!--Card 10-->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.9s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-arrow-repeat text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Pertukaran</h5>
                            <p class="mb-0">Pertukaran tempat.</p>
                        </div>
                    </div>
                </div>
                <!--Card 11-->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.9s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-heart-pulse-fill text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">iRawat</h5>
                            <p class="mb-0">Rawatan.</p>
                        </div>
                    </div>
                </div>
                <!--Card 12-->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.9s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-book-half text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">PSH</h5>
                            <p class="mb-0">Pembelajaran.</p>
                        </div>
                    </div>
                </div>
                <!--Card 12-->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.9s" style="cursor:pointer;">
                    <div class="feature-item h-100 p-4 text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="feature-icon mb-3 mx-auto"><i class="bi bi-person-workspace text-white fa-3x"></i></div>
                            <h5 class="mb-3 pt-sans-bold">Tawaran Kursus</h5>
                            <p class="mb-0">Penawaran kursus kepada pengguna ePSM.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature End -->

    <style>
        .counter-counting:hover{
            color: red;
        }
    </style>

    <div>
        <h1>Counter</h1>
        <div class="counter-item">
            <div class="counter-counting">
                <span data-toggle="counter-up">1000</span>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset("assets/lib/waypoints/waypoints.min.js") }}"></script>
    <script src="{{ asset("assets/lib/counterup/counterup.min.js") }}"></script>
@endpush