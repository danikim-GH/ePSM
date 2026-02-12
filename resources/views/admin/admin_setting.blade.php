{{-- resources/views/admin/admin_setting.blade.php --}}
@extends('layouts.apps')

@section('title', '- Admin Settings')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/adminSettingDashboard.css') }}">
@endpush

@section('content')
@include('components.spinnerLoading')

<div class="admin-panel">
    @include('partials.sidebarAdmin')
    
    <div class="admin-content">
        <div class="content-header wow fadeInUp" data-wow-duration="1.3s">
            <h1 class="gabarito-regular">Admin Settings</h1>
            <p>Urus setting dan konfigurasi system ePSM</p>
        </div>

        <div class="admin-container">
            <!-- Settings Dashboard -->
            <div class="settings-dashboard">
                <div class="settings-grid">
                    
                    <!-- Carousel Settings Card -->
                    <div class="setting-card enable" data-feature="carousel" onclick="openFeature('carousel')">
                        <div class="setting-icon enable">
                            <i class="bi bi-highlights"></i>
                        </div>
                        <div class="setting-content">
                            <h3 class="gabarito-regular">Carousel Settings</h3>
                            <p>Gambar Slider di halaman utama </p>
                        </div>
                        <button class="btn-setting">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Gallery Settings Card -->
                    <div class="setting-card" data-feature="gallery" onclick="openFeature('gallery')">
                        <div class="setting-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="setting-content">
                            <h3 class="gabarito-regular">Gallery Settings</h3>
                            <p>Urus gambar galeri dan album</p>
                        </div>
                        <button class="btn-setting" >
                        </button>
                    </div>

                    <!-- Menu Settings Card -->
                    <div class="setting-card" data-feature="menu" onclick="openFeature('menu')" >
                        <div class="setting-icon">
                            <i class="fas fa-bars"></i>
                        </div>
                        <div class="setting-content">
                            <h3 class="gabarito-regular">Menu Settings</h3>
                            <p>Urus arah atau ubah navigasi menu</p>
                        </div>
                        <button class="btn-setting" >
                        </button>
                    </div>

                    <!-- Email Settings Card -->
                    <div class="setting-card" data-feature="email"  onclick="openFeature('email')">
                        <div class="setting-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="setting-content">
                            <h3 class="gabarito-regular">Email Settings</h3>
                            <p>Setting notifikasi emel</p>
                        </div>
                        <button class="btn-setting">
                        </button>
                    </div>

                </div>
            </div>

            <!-- Carousel Feature Container (Hidden by default) -->
            <div id="carouselFeatureContainer" class="feature-container" style="display: none;">
                <div class="feature-header">
                    <button class="btn-back" onclick="closeFeature()">
                        <i class="fas fa-arrow-left"></i> Back to Settings
                    </button>
                </div>
                
                <!-- This will be populated by AJAX when carousel is clicked -->
                <div id="carouselContent"></div>
            </div>

        </div>
        @include('admin.components.mobile_bottom_nav')
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="{{ asset('assets/js/adminSettingDashboard.js') }}"></script>
@endpush


