@extends('layouts.apps')

@section('title',' - Galeri')

{{-- Add gallery-specific CSS --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/galeriStyles.css') }}">
@endpush

@section('content')

@include('components.spinnerLoading')

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

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="gabarito-regular text-white display-4 mb-4">
                {{ $pageTitle ?? 'GALERI' }}
            </h4>
        </div>
    </div>
    <!-- Header End -->
</div>
<!-- Navbar & Hero End -->

<!-- Gallery Start -->
<div class="container-fluid gallery-section py-5 bg-light mt-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h4 class="gabarito-regular text-uppercase text-primary">Galeri Rasmi</h4>
            <h1 class="gabarito-regular display-5 text-capitalize mb-3">Dokumentasi Aktiviti & Program</h1>
            <p class="mb-0">
                Lihat semula momen penting melalui koleksi gambar rasmi program, bengkel, dan aktiviti kami.
            </p>
            {{-- Statistics --}}
            <div class="gallery-stats mt-4">
                <span class="badge bg-primary me-2">
                    <i class="fa fa-calendar-alt me-1"></i> {{ $totalEvents }} Program
                </span>
                <span class="badge bg-secondary">
                    <i class="fa fa-images me-1"></i> {{ $totalImages }} Gambar
                </span>
            </div>
        </div>

        @if($galeriAcara->count() > 0)
            <!-- Events Gallery -->
            @foreach($galeriAcara as $acara)
                @if(isset($galeriImages[$acara->ID]) && $galeriImages[$acara->ID]->count() > 0)
                <div class="event-gallery-wrapper mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <!-- Event Header -->
                    <div class="event-header mb-4">
                        <h3 class="event-title gabarito-regular">{{ $acara->eg_tajuk }}</h3>
                        <div class="event-meta">
                            <span class="event-date">
                                <i class="fa fa-calendar me-2"></i>
                                {{ $acara->eg_tarikh ? \Carbon\Carbon::parse($acara->eg_tarikh)->format('d F Y') : 'Tarikh tidak dinyatakan' }}
                            </span>
                            @if($acara->eg_lokasi)
                            <span class="event-location ms-3">
                                <i class="fa fa-map-marker-alt me-2"></i>
                                {{ $acara->eg_lokasi }}
                            </span>
                            @endif
                            <span class="event-count ms-3">
                                <i class="fa fa-image me-2"></i>
                                {{ $galeriImages[$acara->ID]->count() }} gambar
                            </span>
                        </div>
                    </div>

                    <!-- Event Images Grid -->
                    <div class="row g-4 gallery-grid">
                        @foreach($galeriImages[$acara->ID] as $index => $image)
                        <div class="col-lg-4 col-md-6 gallery-item">
                            <div class="gallery-card">
                                <div class="gallery-img-wrapper">
                                    <img src="{{ asset('uploads/galeri/' . $image->gal_fail) }}" 
                                        class="gallery-img" 
                                        alt="{{ $image->gal_caption ?? 'Gambar ' . ($index + 1) }}"
                                        loading="lazy"
                                        onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22 viewBox=%220 0 400 300%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22400%22 height=%22300%22/%3E%3Ctext fill=%22%23999%22 font-family=%22Arial, sans-serif%22 font-size=%2218%22 x=%2250%25%22 y=%2245%25%22 text-anchor=%22middle%22%3EGambar Tidak Tersedia%3C/text%3E%3Ctext fill=%22%23666%22 font-family=%22Arial, sans-serif%22 font-size=%2214%22 x=%2250%25%22 y=%2255%25%22 text-anchor=%22middle%22%3E{{ $image->gal_fail }}%3C/text%3E%3Cg transform=%22translate(200,150)%22%3E%3Ccircle fill=%22%23ddd%22 r=%2230%22/%3E%3Cpath fill=%22%23999%22 d=%22M-15,-10 L-15,10 L5,10 L5,5 L15,5 L15,-15 L-10,-15 L-10,-10 Z%22/%3E%3Ccircle fill=%22%23666%22 cx=%22-5%22 cy=%22-5%22 r=%223%22/%3E%3C/g%3E%3C/svg%3E';">
                                    <div class="gallery-overlay">
                                        <button class="btn btn-light btn-sm view-image-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#galleryModal{{ $image->ID }}">
                                            <i class="fa fa-search-plus"></i> Lihat
                                        </button>
                                    </div>
                                </div>
                                @if($image->gal_caption && trim($image->gal_caption) != '')
                                <div class="gallery-caption">
                                    <p class="mb-0">{{ $image->gal_caption }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Modal for each image -->
                        <div class="modal fade" id="galleryModal{{ $image->ID }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">{{ $image->gal_caption ?? $acara->eg_tajuk }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <img src="{{ asset('uploads/galeri/' . $image->gal_fail) }}" 
                                            class="img-fluid w-100" 
                                            alt="{{ $image->gal_caption ?? 'Gambar' }}"
                                            onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22600%22 viewBox=%220 0 800 600%22%3E%3Crect fill=%22%23f8f9fa%22 width=%22800%22 height=%22600%22/%3E%3Ctext fill=%22%23666%22 font-family=%22Arial, sans-serif%22 font-size=%2224%22 x=%2250%25%22 y=%2248%25%22 text-anchor=%22middle%22%3EGambar Tidak Dapat Dipaparkan%3C/text%3E%3Ctext fill=%22%23999%22 font-family=%22Arial, sans-serif%22 font-size=%2216%22 x=%2250%25%22 y=%2254%25%22 text-anchor=%22middle%22%3EFail: {{ $image->gal_fail }}%3C/text%3E%3Cg transform=%22translate(400,300)%22%3E%3Ccircle fill=%22%23e9ecef%22 r=%2260%22/%3E%3Cpath fill=%22%23adb5bd%22 d=%22M-30,-20 L-30,20 L10,20 L10,10 L30,10 L30,-30 L-20,-30 L-20,-20 Z%22/%3E%3Ccircle fill=%22%23868e96%22 cx=%22-10%22 cy=%22-10%22 r=%226%22/%3E%3C/g%3E%3C/svg%3E';">
                                    </div>
                                    @if($image->gal_sumber)
                                    <div class="modal-footer border-0">
                                        <small class="text-muted">Sumber: {{ $image->gal_sumber }}</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach

            {{-- Pagination --}}
            <div class="pagination-wrapper mt-5">
                <nav aria-label="Gallery pagination">
                    {{ $galeriAcara->links('pagination::bootstrap-5') }}
                </nav>
                
                {{-- Pagination Info --}}
                <div class="text-center mt-3">
                    <p class="text-muted">
                        Memaparkan {{ $galeriAcara->firstItem() ?? 0 }} hingga {{ $galeriAcara->lastItem() ?? 0 }} 
                        daripada {{ $galeriAcara->total() }} program
                    </p>
                </div>
            </div>
        @else
            <!-- No Gallery Items -->
            <div class="text-center py-5">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" class="mb-4">
                        <rect fill="#f0f0f0" width="120" height="120" rx="10"/>
                        <g transform="translate(60,60)">
                            <circle fill="#ddd" r="35"/>
                            <path fill="#999" d="M-20,-10 L-20,15 L10,15 L10,8 L20,8 L20,-20 L-12,-20 L-12,-10 Z"/>
                            <circle fill="#666" cx="-8" cy="-8" r="4"/>
                        </g>
                    </svg>
                    <h4 class="text-muted gabarito-regular">Tiada galeri tersedia buat masa ini</h4>
                    <p class="text-muted">Sila semak semula kemudian</p>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Gallery End -->

<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="container text-center">
            <p class="text-white mb-0">© 2025 ePSM Helpdesk. Semua Hak Terpelihara.</p>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top">
    <i class="fa fa-arrow-up"></i>
</a>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for pagination
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Scroll to top of gallery section smoothly
            setTimeout(() => {
                const gallerySection = document.querySelector('.gallery-section');
                if (gallerySection) {
                    gallerySection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        });
    });

    // Image loading error handling with better feedback
    const galleryImages = document.querySelectorAll('.gallery-img');
    galleryImages.forEach(img => {
        img.addEventListener('error', function() {
            console.warn('Failed to load image:', this.src);
        });
    });

    // Optional: Lazy loading fallback for older browsers
    if ('loading' in HTMLImageElement.prototype) {
        console.log('Lazy loading supported');
    } else {
        console.log('Lazy loading not supported, images will load immediately');
    }
});
</script>
@endpush