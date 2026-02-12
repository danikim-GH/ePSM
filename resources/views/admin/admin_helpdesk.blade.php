@extends('layouts.apps')

@section('title', '- Admin Helpdesk')

@push('styles')
    <link href="{{ asset("assets/css/admin.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/css/adminUserList.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/adminHelpdesk.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="admin-panel">

    @include('../partials/sidebarAdmin')

    {{-- Main Content --}}
    <main class="admin-content">
        <div class="content-header wow fadeInUp" data-wow-duration="1.3s">
            <h1 class="gabarito-regular">Admin - Aduan Helpdesk</h1>
        </div>

        {{-- Gmail-like Helpdesk Interface --}}
        <div class="helpdesk-container">
            {{-- Toolbar --}}
            <div class="helpdesk-toolbar">
                <div class="toolbar-left">
                    <!-- Select All -->
                    <label class="toolbar-item checkbox-item">
                        <span class="toolbar-label">Pilih Semua</span>
                        <span class="checkbox-container">
                            <input type="checkbox" id="select-all">
                            <span class="checkmark"></span>
                        </span>
                    </label>

                    <!-- Divider -->
                    <span class="toolbar-divider"></span>

                    <!-- Refresh -->
                    <button class="toolbar-item toolbar-btn" id="refresh-btn" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                        <span class="toolbar-label">Semula</span>
                    </button>
                </div>
                <div class="toolbar-right">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="search-helpdesk" placeholder="Cari aduan...">
                    </div>
                </div>
            </div>

            {{-- Filter Tabs --}}
            <div class="helpdesk-tabs">
                <button class="tab-btn active" data-status="all">
                    <i class="fas fa-inbox"></i> Semua <span class="count" id="count-all">0</span>
                </button>
                <button class="tab-btn" data-status="pending">
                    <i class="fas fa-clock"></i> Masih Menunggu <span class="count" id="count-pending">0</span>
                </button>
                <button class="tab-btn" data-status="resolved">
                    <i class="fas fa-check-circle"></i> Selesai <span class="count" id="count-resolved">0</span>
                </button>
            </div>

            {{-- Helpdesk List --}}
            <div class="helpdesk-list" id="helpdesk-list">  
                <div class="loading-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Memuatkan aduan...</p>
                </div>
            </div>

            {{-- Detail Panel --}}
            <div class="helpdesk-detail" id="helpdesk-detail">
                <div class="detail-empty">
                    <i class="fas fa-envelope-open-text"></i>
                    <p>Pilih aduan untuk melihat butiran</p>
                </div>
            </div>
        </div>
    </main>    
    <footer>
    </footer>
</div>
@include('components.backToTop')

@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
    <script src="{{ asset("assets/js/adminHelpdesk.js")}}"></script>
@endpush