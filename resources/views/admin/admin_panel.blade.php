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

            {{-- Example user card --}}
            <div class="user-card">
                <div class="user-info">
                    <p><strong class="text-dark">Nama:</strong> John Dongo Nurmagumedov</p>
                    <p><strong class="text-dark">No KP:</strong> 900101-01-1234</p>
                    <p><strong class="text-dark">Email:</strong> john@example.com</p>
                    <p><strong class="text-dark">Phone:</strong> 012-3456789</p>
                </div>

                <div class="user-actions">
                    <label>User Level</label>
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

            {{-- Real card apply --}}
            @foreach ($pending as $user)
                <div class="user-card">
                    <div class="user-info">
                        <p><strong class="text-dark">Nama:</strong>{{ $user -> Nama }}</p>
                        <p><strong class="text-dark">No KP:</strong>{{ $user -> NoKP }}</p>
                        <p><strong class="text-dark">Email:</strong>{{ $user -> emel }}</p>
                        <p><strong class="text-dark">Phone:</strong>{{ $user -> hp }}</p>
                    </div>

                    <div class="user-actions">
                        <form action="{{ route('admin.approve', $user->NoKP) }}" method="POST" class="action-form">
                            @csrf
                            <label>User Level</label>
                            <select name="userlevel" id="userlevel" class="action-select">
                                <option value="9">Admin</option>
                                <option value="8">Lower Admin</option>
                                <option value="1">Staff</option>
                                <option value="2">Guest</option>
                                <option value="3">3</option>
                            </select>

                            <button class="btn-approve" type="submit">Approve</button>
                        </form>
                        <a class="btn-edit action-edit-btn" href="{{ route('admin.editUser', $user->NoKP) }}">
                                Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection

@push('scripts')
    <script src="{{ asset("assets/js/admin.js")}}"></script>
@endpush