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
                <option value="IT">IT</option>
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
                {{-- SAMPLE DATA — nanti guna foreach --}}
                <tr>
                    <td>Ahmad Bakri</td>
                    <td>990101-01-2211</td>
                    <td>ahmad@example.com</td>
                    <td>013-2233445</td>
                    <td>Pentadbiran</td>
                    <td>Staff</td>
                </tr>

                <tr>
                    <td>Nurin Sofia</td>
                    <td>010202-02-1122</td>
                    <td>nurin@gmail.com</td>
                    <td>011-8877665</td>
                    <td>IT</td>
                    <td>Admin</td>
                </tr>

                <tr>
                    <td>Faris Ilham</td>
                    <td>000303-02-3311</td>
                    <td>faris@gmail.com</td>
                    <td>012-4222331</td>
                    <td>Kewangan</td>
                    <td>Guest</td>
                </tr>
            </tbody>
        </table>

    </main>
</div>

@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
    <script src="{{ asset("assets/js/adminUserList.js") }}"></script>
@endpush