@extends('layouts.apps')

@section('title', ' - Log Masuk')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="login-container">
    {{-- SHAPE --}}

    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <img src="{{ asset('assets/img/cropped-kedah-baru.png') }}" alt="logo-kedah">
                <span class="logo-text righteous-regular">ePSM</span>
            </div>
            <h1 class="login-title gabarito-bold">Log Masuk</h1>
            <p class="login-subtitle">Sistem e-Pembangunan Sumber Manusia</p>
        </div>

        <form action="{{ route('login.check') }}" id="loginForm" method="POST" class="login-form">
            @csrf

            <div class="form-grid">
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <input type="text" name="NoKP" id="NoKP" placeholder="No KP">
                    <div class="input-border"></div>
                </div>

                <div class="input-group">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" name="katalaluan" id="katalaluan" placeholder="Kata Laluan" required>
                    <div class="input-border"></div>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="btn-text">Login</span>
                <i class="fas fa-arrow-right btn-icon"></i>
                <div class="btn-glow"></div>
            </button>

            <div class="register-link text-light">
                Daftar akaun disini - <a href="{{ route('register.view') }}" class="register-text">Pendaftaran Akaun</a>
            </div>
        </form>
        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/login.js') }}"></script>
@endpush