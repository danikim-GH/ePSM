@extends('layouts.apps')

@section('title', 'Admin Panel - Pending Registrations')

@push('styles')
    <link href="{{ asset("assets/css/admin.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/css/adminUserList.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="admin-panel">

    @include('../partials/sidebarAdmin')

    {{-- Main Content --}}
    <main class="admin-content" id="adminContent">
        <div class="content-header wow fadeInUp" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
            <div class="header-top">
                <div class="header-title">
                    <h1 class="gabarito-regular"><i class="fas fa-user-clock header-icon"></i>Daftar Pengguna: Pending & Suspend</h1>
                    <p class="subtitle">Review and approve new user registrations</p>
                </div>
            </div>
            
            <div class="header-stats">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-info">
                        <span class="stat-number js-pending-count">0</span>
                        <span class="stat-label">Pending Users</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fa-solid fa-user-slash"></i>
                    <div class="stat-info">
                        <span class="stat-number js-suspended-count" >0</span>
                        <span class="stat-label">Suspended Users</span>
                    </div>
                </div>
            </div>
        </div>

            @if(count($pending) > 0)
            <div class="filter-bar wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s" style=" visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="filter-group">
                    <i class="fas fa-filter"></i>
                    <select class="filter-select">
                        <option value="all">All Users</option>
                        <option value="new">New Today</option>
                        <option value="old">Pending > 3 Days</option>
                    </select>
                </div>
                <div class="search-box">{{-- letak id searchBox --}}
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search users by name or email..." class="search-input">
                </div>
            </div>
            <div class="cards-grid">
                <div class="user-card-pending bg-dark wow fadeInUp" data-popover="pending" data-popover-content="Klik untuk senarai akaun yang belum disahkan" data-wow-duration="1.8s" role="button" id="openPendingPanel">
                    <div class="card-header">
                        <div class="avatar-pending">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
    
                    <div class="card-info">
                        <div class="info-group">
                            <h3 class="gabarito-regular text-uppercase mb-1">pending users list</h3>
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <span class="js-pending-count">0</span> Orang
                            </span>
                        </div>
                    </div>
                </div>

                <div class="user-card-suspend bg-dark wow fadeInUp" data-wow-duration="1.8s" role="button" data-bs-toggle="modal" data-bs-target="#suspendUserModal">
                    <div class="card-header">
                        <div class="avatar-suspend">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>

                    <div class="card-info">
                        <div class="info-group">
                            <h3 class="gabarito-regular text-uppercase mb-1">suspended users list</h3>
                            <span class="badge bg-danger text-ligth fs-6 px-3 py-2">
                                <span class="js-suspended-count">0</span> Orang
                            </span>
                        </div>
                    </div>
                </div>
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

        {{-- Pending User List Table HIDDEN BY DEFAULT --}}

        @include('admin.partials.admin_pending_user_list')

    </main>
    
            @include('admin.components.mobile_bottom_nav')
            @include('components.backToTop')
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="pt-sans-bold">Edit User</h3>
            <button class="modal-close" id="closeModal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editUserForm">
                <input type="hidden" id="editUserId" name="id">
                
                <div class="form-group">
                    <label for="editName">Name</label>
                    <input type="text" id="editName" name="name" class="form-control" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" id="editEmail" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="text" id="editPhone" name="phone" class="form-control">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editNoKP">No KP</label>
                        <input type="text" id="editNoKP" name="no_kp" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="editLevel">Level</label>
                        <select id="editLevel" name="level" class="form-control" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="editDepartment">Department</label>
                    <select id="editDepartment" name="department" class="form-control">
                        <option value="">Select Department</option>
                        <option value="Pentadbiran">Pentadbiran</option>
                        <option value="Sumber Manusia">Sumber Manusia</option>
                        <option value="Kewangan">Kewangan</option>
                        <option value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">IT</option>
                    </select>
                </div>
                
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="cancelEdit">Cancel</button>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3 class="pt-sans-bold">Confirm Delete</h3>
        </div>
        <div class="modal-body">
            <div class="delete-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <p>Are you sure you want to delete this user?</p>
            <p class="delete-user-name" id="deleteUserName"></p>
            <p class="text-warning">This action cannot be undone.</p>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" id="cancelDelete">Cancel</button>
            <button class="btn-delete" id="confirmDelete">Delete User</button>
        </div>
    </div>
</div>



@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
    <script src="{{ asset("assets/js/adminUserList.js") }}"></script>
    <script src="{{ asset("assets/js/adminPanel.js") }}"></script>
    <script src="{{ asset("assets/lib/waypoints/waypoints.min.js") }}"></script>
    <script src="{{ asset("assets/lib/counterup/counterup.min.js") }}"></script>
@endpush