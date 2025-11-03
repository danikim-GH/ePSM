{{-- DEBUG --}}
<p style="color:red;">Loaded from: {{ __FILE__ }}</p>

@extends('layouts')


@section('content')
    <!-- Carousel Section -->
    <div class="carousel-header">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <h4 class="text-white text-uppercase fw-bold mb-4">Kursus Pembangunan</h4>
                        <h1 class="display-2 text-capitalize text-white mb-4">Tingkatkan Kecekapan Anda</h1>
                        <p class="mb-5 fs-5 text-white">Sertai kursus anjuran BPSM untuk meningkatkan kemahiran.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <h4 class="text-white text-uppercase fw-bold mb-4">Peluang Latihan</h4>
                        <h1 class="display-2 text-capitalize text-white mb-4">Peluang Belajar & Berkembang</h1>
                        <p class="mb-5 fs-5 text-white">Kursus tersedia sepanjang tahun untuk penjawat awam Kedah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="container-fluid feature bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h4 class="text-uppercase text-primary">Pilihan</h4>
                <h1 class="display-3 text-capitalize mb-3">Urus Kursus Anda</h1>
                <p class="text-muted">Pilih tindakan di bawah untuk mengurus pendaftaran, maklumat, dan jadual kursus anda.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4">
                        <div class="feature-icon mb-3"><i class="fas fa-edit text-white fa-3x"></i></div>
                        <a href="#" class="h4 mb-3">Daftar Kursus</a>
                        <p class="mb-3">Isi maklumat kursus baharu.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4">
                        <div class="feature-icon mb-3"><i class="fas fa-calendar-alt text-white fa-3x"></i></div>
                        <a href="#" class="h4 mb-3">Tarikh Kursus</a>
                        <p class="mb-3">Semak jadual kursus anda.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4">
                        <div class="feature-icon mb-3"><i class="fas fa-info-circle text-white fa-3x"></i></div>
                        <a href="#" class="h4 mb-3">Maklumat Kursus</a>
                        <p class="mb-3">Lihat butiran kursus tertentu.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-item p-4">
                        <div class="feature-icon mb-3"><i class="fas fa-list text-white fa-3x"></i></div>
                        <a href="#" class="h4 mb-3">Senarai Kursus</a>
                        <p class="mb-3">Lihat senarai kursus ditawarkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
