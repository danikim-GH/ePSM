@extends('layouts.apps')

@section('title', '- Admin Pengesahan Kursus')

@push('styles')
    <link href="{{ asset("assets/css/admin.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/css/admin_approve_kursus.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="admin-panel">

    @include('partials.sidebarAdmin')

    <main class="admin-content">
        
        <!-- Header Section -->
        <div class="content-header">
            <div class="header-top">
                <div class="header-title">
                    <div class="header-title-container">
                        <i class="fas fa-clipboard-check header-icon"></i>
                        <h1 class="gabarito-regular">
                            Pengesahan Kursus
                        </h1>
                    </div>
                    <p class="subtitle">Senarai permohonan kursus menunggu kelulusan</p>
                </div>
            </div>
            <div class="header-stats">
                <div class="stat-card">
                    <i class="fas fa-hourglass-half" style="font-size: 32px;"></i>
                    <div>
                        <div style="font-size: 24px; font-weight: bold;" id="pending-count">0</div>
                        <div style="font-size: 14px; opacity: 0.9;">Menunggu Kelulusan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search Bar -->
        <div class="filter-bar">
            <div class="filter-group">
                <label><i class="fas fa-filter"></i> Tapis:</label>
                <select class="filter-select" id="filter-month">
                    <option value="">Semua Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Mac</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Jun</option>
                    <option value="7">Julai</option>
                    <option value="8">Ogos</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Disember</option>
                </select>
                <select class="filter-select" id="filter-year">
                    <option value="">Semua Tahun</option>
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" id="search-input" placeholder="Cari tajuk kursus, nama, atau tempat...">
            </div>
        </div>

        <!-- Course Cards Grid -->
        <div class="cards-grid" id="kursus-cards-container">
            <!-- Cards will be dynamically loaded here -->
            <div class="loading-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Memuatkan data...</p>
            </div>
        </div>

        <!-- Empty State -->
        <div class="empty-state" id="empty-state" style="display: none;">
            <i class="fas fa-inbox empty-icon"></i>
            <h3 class="gabarito-regular">Tiada Kursus Menunggu Kelulusan</h3>
            <p>Semua permohonan kursus telah diproses</p>
        </div>

    </main>

</div>

<!-- Modal for Course Details -->
<div class="modal-overlay" id="course-modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="gabarito-regular">Butiran Kursus</h2>
            <button class="modal-close" onclick="closeCourseModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="modal-body" id="modal-content">
            <!-- Content will be loaded dynamically -->
        </div>
        
        <div class="modal-course-footer">
            <button class="btn-cancel-modal" onclick="closeCourseModal()">
                Tutup
            </button>
            <button class="btn-sahkan-modal" id="approve-btn">
                Sahkan
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
    <script src="{{ asset("assets/js/adminApproveKursus.js")}}"></script>
@endpush