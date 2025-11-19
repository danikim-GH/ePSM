@extends('layouts.apps')

@section('title', ' - Admin Panel')
@push('styles')
    <link href="{{ asset("assets/css/admin.css") }}" rel="stylesheet">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="admin-panel">

    @include('../partials/sidebarAdmin')

    {{-- Main Content --}}
    <main class="admin-content" id="adminContent">
        <h2 class="pt-sans-bold">Pending User Registrations</h2>

        <div class="user-cards">

            {{-- Example user card --}}
            <div class="user-card">
                <div class="user-info">
                    <p><strong class="text-dark">Nama:</strong> John Dongo Nurmagumedov</p>
                    <p><strong class="text-dark">No KP:</strong> 900101-01-1234</p>
                    <p><strong class="text-dark">Email:</strong> john@example.com</p>
                    <p><strong class="text-dark">Phone:</strong> 012-3456789</p>
                </div>

                <div class="user-actions">
                    <label for="userlevel">User Level</label>
                    <select name="userlevel" id="userlevel">
                        <option value="admin">Admin</option>
                        <option value="lower_admin">Lower Admin</option>
                        <option value="staff">Staff</option>
                        <option value="guest">Guest</option>
                    </select>

                    <button class="btn-approve">Approve</button>
                    <button class="btn-edit">Edit</button>
                </div>
            </div>

            <div class="user-card">
                <div class="user-info">
                    <p><strong class="text-dark">Nama:</strong> Alif Hakimi bin AlShaari</p>
                    <p><strong class="text-dark">No KP:</strong> 050224-02-1214</p>
                    <p><strong class="text-dark">Email:</strong> alip@gmail.com</p>
                    <p><strong class="text-dark">Phone:</strong> 013-3026129</p>
                </div>

                <div class="user-actions">
                    <label for="userlevel">User Level</label>
                    <select name="userlevel" id="userlevel">
                        <option value="admin">Admin</option>
                        <option value="lower_admin">Lower Admin</option>
                        <option value="staff">Staff</option>
                        <option value="guest">Guest</option>
                    </select>

                    <button class="btn-approve">Approve</button>
                    <button class="btn-edit">Edit</button>
                </div>
            </div>

        </div>
    </main>

</div>
@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
@endpush