@extends('layouts.apps')

@section('title', 'Admin Panel - Pending Registrations')
@push('styles')
    <link href="{{ asset("assets/css/admin.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="admin-panel">

    @include('../partials/sidebarAdmin')

    {{-- Main Content --}}
    <main class="admin-content" id="adminContent">
        <div class="content-header">
            <div class="header-top">
                <div class="header-title">
                    <h1 class="pt-sans-bold"><i class="fas fa-user-clock header-icon"></i>Pending User Registrations</h1>
                    <p class="subtitle">Review and approve new user registrations</p>
                </div>
            </div>
            
            <div class="header-stats">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-info">
                        <span class="stat-number">{{ count($pending) }}</span>
                        <span class="stat-label">Pending Users</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock stat-icon"></i>
                    <div class="stat-info">
                        <span class="stat-number">{{ count($pending) }}</span>
                        <span class="stat-label">Awaiting Review</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="user-cards-container">
            @if(count($pending) > 0)
                <div class="filter-bar">
                    <div class="filter-group">
                        <i class="fas fa-filter"></i>
                        <select class="filter-select">
                            <option value="all">All Users</option>
                            <option value="new">New Today</option>
                            <option value="old">Pending > 3 Days</option>
                        </select>
                    </div>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search users by name or email..." class="search-input">
                    </div>
                </div>
                
                <div class="cards-grid">
                    @foreach ($pending as $user)
                        <div class="user-card" data-user-id="{{ $user->NoKP }}">
                            <div class="card-header">
                                <div class="user-avatar">
                                    <span class="avatar-text">{{ strtoupper(substr($user->Nama, 0, 1)) }}</span>
                                </div>
                                <div class="user-status">
                                    <span class="status-badge pending">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                    <span class="date-badge">
                                        <i class="far fa-calendar"></i> {{ date('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="user-info">
                                <div class="info-group">
                                    <label><i class="fas fa-user info-icon"></i> Name</label>
                                    <p class="info-value">{{ $user->Nama }}</p>
                                </div>
                                <div class="info-group">
                                    <label><i class="fas fa-id-card info-icon"></i> IC Number</label>
                                    <p class="info-value">{{ $user->NoKP }}</p>
                                </div>
                                <div class="info-group">
                                    <label><i class="fas fa-envelope info-icon"></i> Email</label>
                                    <p class="info-value">{{ $user->emel }}</p>
                                </div>
                                <div class="info-group">
                                    <label><i class="fas fa-phone info-icon"></i> Phone</label>
                                    <p class="info-value">{{ $user->hp }}</p>
                                </div>
                            </div>

                            <div class="user-actions">
                                <form action="{{ route('admin.approve', $user->NoKP) }}" method="POST" class="action-form">
                                    @csrf
                                    <div class="form-group position-relative">
                                        <label for="userlevel-{{ $user->NoKP }}" class="form-label">
                                            <i class="fas fa-user-tag"></i> Assign Role
                                        </label>
                                        <select name="userlevel" id="userlevel-{{ $user->NoKP }}" class="level-select" required>
                                            <option value="">Select User Level</option>
                                            <option value="9">Administrator</option>
                                            <option value="8">Lower Admin</option>
                                            <option value="1">Staff Member</option>
                                            <option value="2">Guest User</option>
                                            <option value="3">Custom Role</option>
                                        </select>
                                    </div>
                                    
                                    <div class="action-buttons">
                                        <button class="btn btn-approve btn-act" type="submit">
                                            <i class="fas fa-check-circle"></i> Approve
                                        </button>
                                        <a class="btn btn-edit btn-act-edit" href="{{ route('admin.editUser', $user->NoKP) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button class="btn btn-view btn-view-details btn-act-error" type="button" data-user-id="{{ $user->NoKP }}">
                                            <i class="fa-solid fa-user-slash"></i> Suspend
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>No Pending Registrations</h3>
                    <p>All user registrations have been processed. Check back later for new submissions.</p>
                    <button class="btn btn-refresh">
                        <i class="fas fa-sync-alt"></i> Refresh Page
                    </button>
                </div>
            @endif
        </div>
        {{-- Mobile Bottom Navigation --}}
        @include('admin.components.mobile_bottom_nav')
    </main>
</div>
@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
@endpush