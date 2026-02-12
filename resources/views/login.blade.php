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
            <div class="logo-wrapper">
                <img class="logo-kedah" 
                    src="{{ asset('assets/img/cropped-kedah-baru.png') }}" 
                    alt="logo-kedah">

                <div class="logo-divider"></div>

                <img class="logo-epsm" 
                    src="{{ asset('assets/img/logo_epsm.png') }}" 
                    alt="logo-epsm">
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
                    <input type="text" name="NoKP" id="NoKP" placeholder="No KP" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
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
                <p>Sebarang pertanyaan, sila hubungi <strong>+60-16383-4887</strong>  (Danial)</p>
            </div>

        </form>
        @if(session('status'))
        <script>
        document.addEventListener("DOMContentLoaded", function() {

            let status = "{{ session('status') }}";
            let message = "{{ session('message') }}";

            let bgColor = status === "pending" ? "#f39c12" : "#e74c3c";

            let toast = document.createElement("div");
            toast.innerText = message;
            toast.style.position = "fixed";
            toast.style.bottom = "30px";
            toast.style.right = "30px";
            toast.style.background = bgColor;
            toast.style.color = "white";
            toast.style.padding = "15px 20px";
            toast.style.borderRadius = "10px";
            toast.style.boxShadow = "0 4px 10px rgba(0,0,0,0.2)";
            toast.style.zIndex = "9999";

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 4000);
        });
        </script>
        @endif

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/login.js') }}"></script>
@endpush