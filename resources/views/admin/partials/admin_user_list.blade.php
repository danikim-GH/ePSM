@extends('layouts.apps')

@section('title', ' - User List')

@push('styles')
    <link href="{{ asset("assets/css/admin.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/css/adminUserList.css") }}" rel="stylesheet">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="admin-panel">
    @include('partials.sidebarAdmin')

    <main class="admin-content">

        <div class="content-header wow fadeInUp" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
            <h1 class="gabarito-regular">All Registered Users</h1>
            <div class="stats-summary">
                <span class="stat-item">
                    <i class="fas fa-users"></i>
                    <span id="totalUsersStatic">0</span> Users
                </span>
            </div>
        </div>

        {{-- Search + Filter --}}
        <div class="filter-row">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchBox" placeholder="Search user name / email...">
                <button class="clear-search" id="clearSearch" title="Clear search">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="filter-group">
                <select id="jabatanFilter">
                    <option value="">All Departments</option>
                    <option value="Pentadbiran">Pentadbiran</option>
                    <option value="Sumber Manusia">Sumber Manusia</option>
                    <option value="Kewangan">Kewangan</option>
                    <option value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">IT</option>
                </select>
                
                <select id="levelFilter">
                    <option value="">All Levels</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
        </div>

        {{-- User Table --}}
        <div class="table-container">
            <table class="user-table" id="userTable">
                <thead>
                    <tr>
                        <th>Bil.</th>
                        <th>Nama</th>
                        <th>No KP</th>
                        <th>Emel</th>
                        <th>No. Fon</th>
                        <th>Jabatan</th>
                        <th>Level</th>
                        <th class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
            
            <div class="table-footer">
                <div class="table-info">
                    Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalRecords">0</span> Users
                </div>
                <div id="pagination" class="page-container"></div>
            </div>
        </div>

        @include('admin.components.mobile_bottom_nav')
    </main>
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
                            <option value="9">Admin BTMK</option>
                            <option value="8">Admin BSM</option>
                            <option value="1">Staff</option>
                            <option value="2">Staff H</option>
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

<div id="toast" class="toast"></div>

@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
    <script src="{{ asset("assets/js/adminUserList.js") }}"></script>
@endpush