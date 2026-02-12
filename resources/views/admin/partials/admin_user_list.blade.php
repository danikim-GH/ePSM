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
            <h1 class="gabarito-regular">Senarai Pengguna</h1>
            <div class="stats-summary">
                <span class="stat-item total-users">
                    <i class="fas fa-users"></i>
                    <span id="totalUsersStatic" class="total-users-content">0</span> Pengguna
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
                    <option value="">Semua Jabatan</option>
                    <option value="BAHAGIAN PENGURUSAN SUMBER MANUSIA">BAHAGIAN PENGURUSAN SUMBER MANUSIA</option>
                    <option value="BAHAGIAN PERANCANG EKONOMI NEGERI KEDAH">BAHAGIAN PERANCANG EKONOMI NEGERI KEDAH</option>
                    <option value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH</option>
                    <option value="SURUHANJAYA PERKHIDMATAN AWAM">SURUHANJAYA PERKHIDMATAN AWAM</option>
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
            <h3 class="pt-sans-bold">Edit Pengguna</h3>
            <button class="modal-close" id="closeModal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editUserForm">
                <input type="hidden" id="editUserId" name="id">
                
                <div class="form-group">
                    <label for="editName">Nama</label>
                    <input type="text" id="editName" name="name" class="form-control" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="editEmail">Emel</label>
                        <input type="email" id="editEmail" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editPhone">No. Telefon</label>
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
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="editDepartment">Jabatan</label>
                    <select id="editDepartment" name="department" class="form-control">
                        <option value="">Pilih Jabatan</option>
                        <option value="BAHAGIAN PENGURUSAN SUMBER MANUSIA">BAHAGIAN PENGURUSAN SUMBER MANUSIA</option>
                        <option value="BAHAGIAN PERANCANG EKONOMI NEGERI KEDAH">BAHAGIAN PERANCANG EKONOMI NEGERI KEDAH</option>
                        <option value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH</option>
                    </select>
                </div>
                
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="cancelEdit">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3 class="gabarito-regular">Confirm Delete</h3>
        </div>
        <div class="modal-body">
            <div class="delete-icon text-center">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <p class="text-center">Delete Pengguna ini?</p>
            <p class="delete-user-name text-center" id="deleteUserName"></p>
            <p class="text-danger text-center">Tindakan ini tidak boleh diulang semula.</p>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" id="cancelDelete">Batal</button>
            <button class="btn-delete" id="confirmDelete">Delete</button>
        </div>
    </div>
</div>

<div id="toast" class="toast"></div>

@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
    <script src="{{ asset("assets/js/adminUserList.js") }}"></script>
@endpush