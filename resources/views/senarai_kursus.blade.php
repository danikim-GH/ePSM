@extends('layouts.apps')

@section('title', ' - Senarai Kursus')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/senaraiKursus.css') }}">
@endpush

@section('content')

    @include('components.spinnerLoading')
    @include('components.navbar_wrapper',['navbarClass'=>'navbar-light-secondary bg-secondary shadow'])

    <div class="senarai-container">
        <!-- Header Section -->
        <div class="senarai-header">
            <div class="header-content">
                <h1 class="page-title gabarito-regular">
                    Senarai Kehadiran Kursus
                </h1>
                <p class="page-subtitle">Rekod lengkap kursus dan latihan yang telah dihadiri</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number righteous-regular">{{ $totalKursus }}</h3>
                    <p class="stat-label">Jumlah Kursus</p>
                </div>
            </div>
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number righteous-regular">{{ $totalJam }}</h3>
                    <p class="stat-label">Jumlah Jam</p>
                </div>
            </div>
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number righteous-regular">{{ $totalHari }}</h3>
                    <p class="stat-label">Jumlah Hari</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="filter-section">
            <form action="{{route('senarai.index')}}" method="GET" class="filter-form">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari tajuk, kategori, tempat atau anjuran..." 
                        class="search-input"
                    >
                    @if($search)
                        <a href="{{route('senarai.index')}}" class="clear-search">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
                
                <div class="filter-controls">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-sort"></i> Susun mengikut
                        </label>
                        <select name="sortBy" class="filter-select" onchange="this.form.submit()">
                            <option value="kursus_thmula" {{$sortBy=='kursus_thmula'?'selected':''}}>Tarikh</option>
                            <option value="kursus_tajuk" {{$sortBy=='kursus_tajuk'?'selected':''}}>Tajuk</option>
                            <option value="kursus_biljam" {{$sortBy=='kursus_biljam'?'selected':''}}>Jumlah Jam</option>
                            <option value="kursus_bilhari" {{$sortBy=='kursus_bilhari'?'selected':''}}>Jumlah Hari</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-arrow-down-up"></i> Urutan
                        </label>
                        <select name="order" class="filter-select" onchange="this.form.submit()">
                            <option value="desc" {{$order == 'desc'?'selected':''}}>Menurun</option>
                            <option value="asc" {{$order == 'asc'?'selected':''}}>Menaik</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-search">
                        <i class="fas fa-filter"></i> Tapis
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        @if($search)
            <div class="results-info">
                <i class="fas fa-info-circle"></i>
                Menunjukkan hasil carian untuk "<strong>{{ $search }}</strong>" - 
                <strong>{{ $kursus->total() }}</strong> rekod dijumpai
            </div>
        @endif

        <!-- Table Section -->
        @if($kursus->count() > 0)
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table-kursus">
                        <thead>
                            <tr>
                                <th class="col-bil">Bil</th>
                                <th class="col-kategori">Kategori</th>
                                <th class="col-tajuk">Tajuk Kursus</th>
                                <th class="col-tarikh">Tarikh</th>
                                <th class="col-tempat">Tempat</th>
                                <th class="col-jam">Bil Jam</th>
                                <th class="col-hari">Bil Hari</th>
                                <th class="col-status">Status</th>
                                <th class="col-action">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kursus as $index => $k)
                                <tr class="table-row" data-id="{{ $k->kursus_ID }}">
                                    <td class="text-center">{{ $kursus->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge-kategori">
                                            {{ $k->kursus_idprogram ?? 'Tiada' }}
                                        </span>
                                    </td>
                                    <td class="td-tajuk">
                                        <div class="tajuk-content">
                                            <strong>{{ $k->kursus_tajuk }}</strong>
                                            @if($k->kursus_sijil == 1)
                                                <span class="badge-sijil">
                                                    <i class="fas fa-certificate"></i> Sijil
                                                </span>
                                            @endif
                                        </div>
                                        @if($k->kursus_anjuran)
                                            <small class="text-muted anjuran">
                                                <i class="fas fa-building"></i> {{ $k->infoAnjuran->Anjuran ?? $k->kursus_anjuran }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="td-tarikh">
                                        <div class="tarikh-content">
                                            <i class="fas fa-calendar"></i>
                                            <span>
                                                {{ \Carbon\Carbon::parse($k->kursus_thmula)->format('d/m/Y') }}
                                                @if($k->kursus_thtamat && $k->kursus_thtamat != $k->kursus_thmula)
                                                    <br><small>-</small><br>
                                                    {{ \Carbon\Carbon::parse($k->kursus_thtamat)->format('d/m/Y') }}
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                        {{ $k->kursus_tempat }}
                                    </td>
                                    <td class="text-center td-number">
                                        <span class="badge-number">{{ $k->kursus_biljam ?? 0 }}</span>
                                    </td>
                                    <td class="text-center td-number">
                                        <span class="badge-number">{{ $k->kursus_bilhari ?? 0 }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-status {{ $k->kursus_sah == 1 ? 'status-approved' : 'status-pending' }}">
                                            {{ $k->kursus_sah == 1 ? 'Disahkan' : 'Belum Disahkan' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn-detail-table" onclick="toggleRowDetails({{ $k->kursus_ID }})">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Expandable Row Details -->
                                <tr class="row-details" id="details-{{ $k->kursus_ID }}">
                                    <td colspan="9">
                                        <div class="details-content">
                                            <div class="details-grid">
                                                @if($k->kursus_jenistempat)
                                                    <div class="detail-item-table">
                                                        <strong><i class="fas fa-location-dot"></i> Jenis Tempat:</strong>
                                                        <span>{{ $k->kursus_jenistempat }}</span>
                                                    </div>
                                                @endif
                                                @if($k->kursus_namanegeri)
                                                    <div class="detail-item-table">
                                                        <strong><i class="fas fa-map"></i> Negeri:</strong>
                                                        <span>{{ $k->kursus_namanegeri }}</span>
                                                    </div>
                                                @endif
                                                @if($k->kursus_rujukan)
                                                    <div class="detail-item-table">
                                                        <strong><i class="fas fa-file-alt"></i> Rujukan:</strong>
                                                        <span>{{ $k->kursus_rujukan }}</span>
                                                    </div>
                                                @endif
                                                @if($k->kursus_msmula || $k->kursus_msakhir)
                                                    <div class="detail-item-table">
                                                        <strong><i class="fas fa-clock"></i> Masa:</strong>
                                                        <span>
                                                            {{ $k->kursus_msmula ? \Carbon\Carbon::parse($k->kursus_msmula)->format('h:i A') : '' }}
                                                            {{ $k->kursus_msakhir ? ' - ' . \Carbon\Carbon::parse($k->kursus_msakhir)->format('h:i A') : '' }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="detail-item-table">
                                                    <strong><i class="fas fa-calendar-plus"></i> Tarikh Daftar:</strong>
                                                    <span>{{ \Carbon\Carbon::parse($k->kursus_daftar)->format('d/m/Y h:i A') }}</span>
                                                </div>
                                                @if($k->kursus_tarikhsijil)
                                                    <div class="detail-item-table">
                                                        <strong><i class="fas fa-certificate"></i> Tarikh Sijil:</strong>
                                                        <span>{{ \Carbon\Carbon::parse($k->kursus_tarikhsijil)->format('d/m/Y h:i A') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($kursus->hasPages())
                <div class="pagination-wrapper">
                    {{ $kursus->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3 class="gabarito-regular">Tiada Rekod Kursus</h3>
                <p>
                    @if($search)
                        Tiada rekod kursus yang sepadan dengan carian anda.
                    @else
                        Anda belum mendaftarkan sebarang kursus lagi.
                    @endif
                </p>
                <a href="{{ route('kursus.create') }}" class="btn-register">
                    <i class="fas fa-plus-circle add-icon"></i> Daftar Kursus Baharu
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
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
    <script src="{{ asset('assets/js/senaraiKursus.js') }}"></script>
@endpush