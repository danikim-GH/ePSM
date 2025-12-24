@extends('layouts.apps')

@section('title', ' - Daftar Pengguna Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')

@include('components.spinnerLoading')

<div class="register-container">
        <div class="bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
        
        <!-- Main register card -->
        <div class="register-card">
            <!-- Header section -->
            <div class="register-header">
                <div class="logo">
                    <img src="{{ asset('assets/img/cropped-kedah-baru.png') }}" alt="logo-kedah">
                    <span class="logo-text righteous-regular">ePSM</span>
                </div>
                <h1 class="register-title gabarito-bold">Daftar Pengguna Baru</h1>
                <p class="register-subtitle">Pendaftaran akaun perlu menunggu pengesahan admin.</p>
            </div>
            
            <!-- Form section -->
            <form id="registerForm" action="{{ route('register.store') }}" method="POST" class="register-form">
                @csrf
                
                <!-- Form fields -->
                <div class="form-grid">
                    <!-- Nama field -->
                    <div class="input-group">
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" name="Nama" id="Nama" placeholder="Nama Penuh" required>
                        <div class="input-border"></div>
                    </div>
                    
                    <!-- NoKP field -->
                    <div class="input-group">
                        <div class="input-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <input type="text" name="NoKP" id="NoKP" placeholder="No KP" required>
                        <div class="input-border"></div>
                    </div>
                    
                    <!-- Email field -->
                    <div class="input-group">
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" name="emel" id="emel" placeholder="Alamat Emel" required>
                        <div class="input-border"></div>
                    </div>
                    
                    <!-- Phone field -->
                    <div class="input-group">
                        <div class="input-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <input type="tel" name="hp" id="hp" placeholder="Nombor Telefon" required>
                        <div class="input-border"></div>
                    </div>
                    
                    <!-- Department field -->
                    <div class="input-group input-group-select full-width">                     
                        <div class="input-icon">
                            <i class="fas fa-building"></i>
                        </div>

                        <div class="select-wrapper modern-select">
                            <select name="NamaJabatan" id="NamaJabatan" required>
                                <option value="" disabled selected>Pilih Jabatan</option>
                                <option value="BAHAGIAN TEKNOLOGI MAKLUMAT">BAHAGIAN TEKNOLOGI MAKLUMAT</option>
                                <option value="SURUHANJAYA PERKHIDMATAN AWAM">SURUHANJAYA PERKHIDMATAN AWAM</option>
                                <option value="BAHAGIAN PEMBAGUNAN SUMBER MANUSIA">BAHAGIAN PEMBAGUNAN SUMBER MANUSIA</option>
                                <option value="OTHERS">Lain-lain</option>
                            </select>

                            <div class="select-arrow smooth-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="input-border"></div>
                    </div>

                    
                    <!-- Password field -->
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
                    
                    <!-- Confirm Password field (added for better UX) -->
                    <div class="input-group">
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" name="confirmKatalaluan" id="confirmKatalaluan" placeholder="Sahkan Kata Laluan" required>
                        <div class="input-border"></div>
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>


                </div>
                
                <!-- Password strength indicator -->
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <span class="strength-text" id="strengthText">Kekuatan kata laluan</span>
                </div>
                

                
                <!-- Submit button -->
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span class="btn-text">Daftar</span>
                    <i class="fas fa-arrow-right btn-icon"></i>
                    <div class="btn-glow"></div>
                </button>
                
                <!-- Login link -->
                <div class="login-link text-light">
                    Sudah mempunyai akaun? <a href="{{ route('login') }}" class="login-text">Log Masuk di sini</a>
                </div>
            </form>
            
            <!-- Progress indicator -->
            <div class="progress-indicator">
                <div class="progress-step active"></div>
                <div class="progress-step"></div>
                <div class="progress-step"></div>
                <div class="progress-step"></div>
            </div>
        </div>
        
        <!-- Language selector -->
        <div class="language-selector">
            <i class="fas fa-globe"></i>
            <select id="languageSelect">
                <option value="en">English</option>
                <option value="ms" selected>Bahasa Malaysia</option>
            </select>
        </div>
        
        <!-- Notification toast -->
        <div class="toast" id="formToast">
            <i class="fas fa-check-circle toast-icon"></i>
            <span class="toast-message">Sila isi semua ruangan dengan betul</span>
        </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/register.js') }}"></script>
@endpush

