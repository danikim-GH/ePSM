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

        <h2 class="pt-sans-bold">All Registered Users</h2>

        {{-- Search + Filter --}}
        <div class="filter-row">
            <input type="text" id="searchBox" placeholder="Search user name / email...">

            <select id="jabatanFilter">
                <option value="">— Filter Jabatan —</option>
                <option value="Pentadbiran">Pentadbiran</option>
                <option value="Sumber Manusia">Sumber Manusia</option>
                <option value="Kewangan">Kewangan</option>
                <option value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">IT</option>
            </select>
        </div>

        {{-- User Table --}}
        <table class="user-table" id="userTable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No KP</th>
                    <th>Email</th>
                    <th>No Telefon</th>
                    <th>Jabatan</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div id="pagination" class="pagination-cotainer"></div>
    </main>
</div>

@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
    <script src="{{ asset("assets/js/adminUserList.js") }}"></script>
@endpush