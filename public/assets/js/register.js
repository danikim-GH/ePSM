// DOM elements
const registerForm = document.getElementById('registerForm');
const passwordInput = document.getElementById('katalaluan');
const confirmPasswordInput = document.getElementById('confirmKatalaluan');
const togglePasswordBtn = document.getElementById('togglePassword');
const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
const strengthFill = document.getElementById('strengthFill');
const strengthText = document.getElementById('strengthText');
const submitBtn = document.getElementById('submitBtn');
const formToast = document.getElementById('formToast');
const languageSelect = document.getElementById('languageSelect');
const progressSteps = document.querySelectorAll('.progress-step');

// Password visibility toggle
togglePasswordBtn.addEventListener('click', function() {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
});

toggleConfirmPasswordBtn.addEventListener('click', function() {
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPasswordInput.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
});

// Password strength indicator
passwordInput.addEventListener('input', function() {
    const password = this.value;
    let strength = 0;
    let strengthMessage = 'Kekuatan kata laluan';
    let strengthWidth = '0%';
    let strengthColor = '#ff3333';
    
    if (password.length > 0) {
        // Length check
        if (password.length >= 8) strength += 25;
        
        // Lowercase check
        if (/[a-z]/.test(password)) strength += 25;
        
        // Uppercase check
        if (/[A-Z]/.test(password)) strength += 25;
        
        // Number/Special character check
        if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;
        
        // Set width and color based on strength
        strengthWidth = strength + '%';
        
        if (strength <= 25) {
            strengthColor = '#ff3333';
            strengthMessage = 'Lemah';
        } else if (strength <= 50) {
            strengthColor = '#ffaa00';
            strengthMessage = 'Sederhana';
        } else if (strength <= 75) {
            strengthColor = '#ffff00';
            strengthMessage = 'Kuat';
        } else {
            strengthColor = '#00ffaa';
            strengthMessage = 'Sangat Kuat';
        }
    }
    
    // Update strength indicator
    strengthFill.style.width = strengthWidth;
    strengthFill.style.background = strengthColor;
    strengthText.textContent = strengthMessage;
    strengthText.style.color = strengthColor;
});

// Form validation on submit
registerForm.addEventListener('submit', function(e) {
    e.preventDefault();

    // Get form values
    const nama = document.getElementById('Nama').value.trim();
    const noKP = document.getElementById('NoKP').value.trim();
    const emel = document.getElementById('emel').value.trim();
    const hp = document.getElementById('hp').value.trim();
    const password = document.getElementById('katalaluan').value;
    const confirmPassword = document.getElementById('confirmKatalaluan').value;
    
    // Validation checks
    let isValid = true;
    let errorMessage = '';
    
    // Check if all fields are filled
    if (!nama || !noKP || !emel || !hp || !password || !confirmPassword) {
        isValid = false;
        errorMessage = 'Sila isi semua medan yang diperlukan';
    }
    // Check if passwords match
    else if (password !== confirmPassword) {
        isValid = false;
        errorMessage = 'Kata laluan tidak sepadan';
    }
    // Check email format
    else if (!isValidEmail(emel)) {
        isValid = false;
        errorMessage = 'Format emel tidak sah';
    }
    // Check phone number (basic validation)
    else if (!isValidPhone(hp)) {
        isValid = false;
        errorMessage = 'Nombor telefon tidak sah';
    }
    
    // Show appropriate message
    if (isValid) {
        // In a real application, you would submit the form here
        showToast('Pendaftaran berjaya! Mengemaskini maklumat...', 'success');
        
        // Simulate form submission
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        submitBtn.disabled = true;
        
        registerForm.submit();

        // Simulate API call delay
        setTimeout(() => {
            showToast('Pendaftaran selesai! Selamat datang ke ePSM.', 'success');
            
            // In a real application, you would redirect or show success message
            // For now, reset form and button
            setTimeout(() => {
                registerForm.reset();
                submitBtn.innerHTML = '<span class="btn-text">Daftar</span><i class="fas fa-arrow-right btn-icon"></i><div class="btn-glow"></div>';
                submitBtn.disabled = false;
                strengthFill.style.width = '0%';
                strengthText.textContent = 'Kekuatan kata laluan';
                strengthText.style.color = '#c2c0c0ff';
            }, 2000);
        }, 2000);
    } else {
        showToast(errorMessage, 'error');
    }
});

// Helper functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    // Basic phone validation - accepts numbers, spaces, dashes, and plus sign
    const phoneRegex = /^[\d\s\-\+]+$/;
    return phoneRegex.test(phone) && phone.replace(/\D/g, '').length >= 8;
}

// Toast notification function
function showToast(message, type) {
    const toastIcon = formToast.querySelector('.toast-icon');
    const toastMessage = formToast.querySelector('.toast-message');
    
    // Set message
    toastMessage.textContent = message;
    
    // Set icon and color based on type
    if (type === 'success') {
        toastIcon.className = 'fas fa-check-circle toast-icon';
        formToast.style.borderLeftColor = '#00ffaa';
        toastIcon.style.color = '#00ffaa';
    } else {
        toastIcon.className = 'fas fa-exclamation-circle toast-icon';
        formToast.style.borderLeftColor = '#ff3333';
        toastIcon.style.color = '#ff3333';
    }
    
    // Show toast
    formToast.classList.add('show');
    
    // Hide toast after 5 seconds
    setTimeout(() => {
        formToast.classList.remove('show');
    }, 5000);
}

// Language selector functionality
languageSelect.addEventListener('change', function() {
    const selectedLang = this.value;
    
    // In a real application, you would change the language of the page here
    // For this example, we'll just show a toast
    if (selectedLang === 'en') {
        showToast('Language changed to English', 'success');
        
        // Update some text elements to English (for demo purposes)
        document.querySelector('.register-title').textContent = 'New User Registration';
        document.querySelector('.register-subtitle').textContent = 'Create your account for full access to our platform';
        document.getElementById('Nama').placeholder = 'Full Name';
        document.getElementById('NoKP').placeholder = 'IC Number';
        document.getElementById('emel').placeholder = 'Email Address';
        document.getElementById('hp').placeholder = 'Phone Number';
        document.getElementById('katalaluan').placeholder = 'Password';
        document.getElementById('confirmKatalaluan').placeholder = 'Confirm Password';
        document.querySelector('.submit-btn .btn-text').textContent = 'Register';
        document.querySelector('.login-link').innerHTML = 'Already have an account? <a href="#" class="login-text">Login here</a>';
    } else {
        showToast('Bahasa ditukar kepada Bahasa Malaysia', 'success');
        
        // Update text elements back to Malay
        document.querySelector('.register-title').textContent = 'Daftar Pengguna Baru';
        document.querySelector('.register-subtitle').textContent = 'Buat akaun anda untuk akses penuh ke platform kami';
        document.getElementById('Nama').placeholder = 'Nama Penuh';
        document.getElementById('NoKP').placeholder = 'No KP';
        document.getElementById('emel').placeholder = 'Alamat Emel';
        document.getElementById('hp').placeholder = 'Nombor Telefon';
        document.getElementById('katalaluan').placeholder = 'Kata Laluan';
        document.getElementById('confirmKatalaluan').placeholder = 'Sahkan Kata Laluan';
        document.querySelector('.submit-btn .btn-text').textContent = 'Daftar';
        document.querySelector('.login-link').innerHTML = 'Sudah mempunyai akaun? <a href="#" class="login-text">Log Masuk di sini</a>';
    }
});

// Input focus effects
const inputs = document.querySelectorAll('.input-group input');
inputs.forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        if (this.value === '') {
            this.parentElement.classList.remove('focused');
        }
    });
});

// Progress indicator animation (simulating form steps)
let currentStep = 0;
function updateProgress() {
    progressSteps.forEach((step, index) => {
        if (index <= currentStep) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });
    
    // Move to next step (for demo)
    currentStep = (currentStep + 1) % progressSteps.length;
}

// Simulate progress updates
setInterval(updateProgress, 3000);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Add focused class to inputs with values on page load
    inputs.forEach(input => {
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });
    
    // Show welcome message after a short delay
    setTimeout(() => {
        showToast('Selamat datang ke sistem pendaftaran ePSM', 'success');
    }, 1000);
});