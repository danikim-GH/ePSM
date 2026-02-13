// Government Registration System JavaScript
// Enhanced with Bootstrap integration and comprehensive validation

class GovernmentRegistration {
    constructor() {
        this.form = document.getElementById('form');
        this.registerBtn = document.getElementById('registerBtn');
        this.fields = {
            username: document.getElementById('username'),
            email: document.getElementById('email'),
            phone: document.getElementById('phone'),
            userLevel: document.getElementById('userLevel'),
            userLevelId: document.getElementById('userLevelId'),
            password: document.getElementById('password'),
            confirmPassword: document.getElementById('confirmPassword'),
            agreeTerms: document.getElementById('agreeTerms')
        };
        
        this.toggleButtons = {
            password: document.getElementById('togglePassword'),
            confirmPassword: document.getElementById('toggleConfirmPassword')
        };
        
        this.strengthIndicator = {
            fill: document.getElementById('strengthFill'),
            text: document.getElementById('strengthText')
        };
        
        this.isSubmitting = false;
        this.validationRules = this.initValidationRules();
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.initPasswordStrength();
        this.initRealTimeValidation();
        this.initAccessibilityFeatures();
        this.initUserLevelHandler();
    }
    
    initValidationRules() {
        return {
            username: {
                required: true,
                minLength: 3,
                maxLength: 30,
                pattern: /^[a-zA-Z0-9._-]+$/,
                message: 'Username must be 3-30 characters, alphanumeric with dots, underscores, or hyphens only'
            },
            email: {
                required: true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter a valid email address'
            },
            phone: {
                required: true,
                pattern: /^[0-9+\-\s()]+$/,
                minLength: 10,
                message: 'Please enter a valid phone number'
            },
            password: {
                required: true,
                minLength: 8,
                message: 'Password must be at least 8 characters long'
            }
        };
    }
    
    bindEvents() {
        // Form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Password toggles
        this.toggleButtons.password.addEventListener('click', () => 
            this.togglePasswordVisibility('password'));
        this.toggleButtons.confirmPassword.addEventListener('click', () => 
            this.togglePasswordVisibility('confirmPassword'));
        
        // Real-time validation
        Object.keys(this.fields).forEach(fieldName => {
            const field = this.fields[fieldName];
            if (field && field.addEventListener) {
                field.addEventListener('blur', () => this.validateField(fieldName));
                field.addEventListener('input', () => this.clearFieldError(fieldName));
            }
        });
        
        // Password confirmation matching
        this.fields.confirmPassword.addEventListener('input', () => this.validatePasswordMatch());
        
        // Prevent form submission on Enter in input fields (except submit button)
        this.form.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
                e.preventDefault();
                this.focusNextField(e.target);
            }
        });
        
        // Auto-format phone number
        this.fields.phone.addEventListener('input', (e) => this.formatPhoneNumber(e));
    }
    
    initPasswordStrength() {
        this.fields.password.addEventListener('input', (e) => {
            this.checkPasswordStrength(e.target.value);
        });
    }
    
    initRealTimeValidation() {
        // Email validation with debouncing
        let emailTimeout;
        this.fields.email.addEventListener('input', (e) => {
            clearTimeout(emailTimeout);
            emailTimeout = setTimeout(() => {
                this.validateEmail(e.target.value);
            }, 500);
        });
        
        // Username availability check (mock)
        let usernameTimeout;
        this.fields.username.addEventListener('input', (e) => {
            clearTimeout(usernameTimeout);
            usernameTimeout = setTimeout(() => {
                this.checkUsernameAvailability(e.target.value);
            }, 1000);
        });
    }
    
    initAccessibilityFeatures() {
        // Add ARIA labels and descriptions
        this.fields.password.setAttribute('aria-describedby', 'passwordHelp');
        this.fields.confirmPassword.setAttribute('aria-describedby', 'confirmPasswordHelp');
        
        // Announce validation errors to screen readers
        this.createAriaLiveRegion();
    }
    
    initUserLevelHandler() {
        this.fields.userLevel.addEventListener('change', (e) => {
            const selectedOption = e.target.selectedOptions[0];
            console.log("Dropdown changed:", selectedOption?.value); // 👈 Debug log
    
            if (selectedOption) {
                const levelId = selectedOption.getAttribute('data-id');
                console.log("Level ID selected:", levelId); // 👈 Debug log
    
                this.fields.userLevelId.value = levelId || '';
                this.showLevelSelection(selectedOption.value, levelId);
            }
        });
    }
    
    
    async handleSubmit(e) {
        e.preventDefault();

        console.log("Form reference:", this.form);
    
        const formData = new FormData();
        formData.append("username", this.fields.username.value);
        formData.append("email", this.fields.email.value);
        formData.append("phone", this.fields.phone.value);
        formData.append("userLevel", this.fields.userLevel.value);
        formData.append("userLevelId", this.fields.userLevelId.value);
        formData.append("password", this.fields.password.value);
        formData.append("confirmPassword", this.fields.confirmPassword.value);
       // formData.append("agreeTerms",this.fields.agreeTerms.checked);

       if (this.fields.agreeTerms.checked) {
            formData.append("agreeTerms", "on");
        }        
        // Debug log
        console.log("FormData contents:");
        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
    
        fetch("register.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response from PHP:", data);
            if (!data.success) {
                this.handleRegistrationError(data.message, data.errors);
            }
        })
        .catch(err => {
            console.error("Network error:", err);
            this.handleRegistrationError("Network error, please try again later.");
        });
    }
    
    
    
    validateForm() {
        let isValid = true;
        const errors = {};
        
        // Validate each field
        Object.keys(this.validationRules).forEach(fieldName => {
            if (!this.validateField(fieldName)) {
                isValid = false;
            }
        });
        
        // Special validations
        if (!this.validatePasswordMatch()) {
            isValid = false;
        }
        console.log("this.fields.agreeTerms:", this.fields.agreeTerms);
        if (this.fields.agreeTerms) {
            console.log("Checked status:", this.fields.agreeTerms.checked);
        }
        /**
        if (!this.fields.agreeTerms.checked) {
            this.showFieldError('agreeTerms', 'You must agree to the terms and conditions');
            isValid = false;
        }
         */
        if (!this.fields.userLevel.value) {
            this.showFieldError('userLevel', 'Please select an access level');
            isValid = false;
        }
        
        return isValid;
    }
    
    validateField(fieldName) {
        const field = this.fields[fieldName];
        const rules = this.validationRules[fieldName];
        
        if (!field || !rules) return true;
        
        const value = field.value.trim();
        
        // Required validation
        if (rules.required && !value) {
            this.showFieldError(fieldName, `${this.getFieldLabel(fieldName)} is required`);
            return false;
        }
        
        if (!value) return true; // Skip other validations if empty and not required
        
        // Length validation
        if (rules.minLength && value.length < rules.minLength) {
            this.showFieldError(fieldName, `${this.getFieldLabel(fieldName)} must be at least ${rules.minLength} characters`);
            return false;
        }
        
        if (rules.maxLength && value.length > rules.maxLength) {
            this.showFieldError(fieldName, `${this.getFieldLabel(fieldName)} must not exceed ${rules.maxLength} characters`);
            return false;
        }
        
        // Pattern validation
        if (rules.pattern && !rules.pattern.test(value)) {
            this.showFieldError(fieldName, rules.message);
            return false;
        }
        
        this.showFieldSuccess(fieldName);
        return true;
    }
    
    validateEmail(email) {
        if (!email) return;
        
        const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        
        if (isValid) {
            // Mock email domain validation
            const domain = email.split('@')[1];
            const allowedDomains = ['gmail.com', 'gov.my', 'mygov.my', 'yahoo.com', 'outlook.com'];
            
            if (allowedDomains.includes(domain)) {
                this.showFieldSuccess('email');
            } else {
                this.showFieldWarning('email', 'Consider using a government or common email domain');
            }
        } else {
            this.showFieldError('email', 'Please enter a valid email address');
        }
    }
    
    async checkUsernameAvailability(username) {
        if (!username || username.length < 3) return;
        
        // Mock availability check
        const unavailableUsernames = ['admin', 'administrator', 'root', 'test', 'user'];
        
        if (unavailableUsernames.includes(username.toLowerCase())) {
            this.showFieldError('username', 'This username is not available');
        } else {
            this.showFieldSuccess('username', 'Username is available');
        }
    }
    
    validatePasswordMatch() {
        const password = this.fields.password.value;
        const confirmPassword = this.fields.confirmPassword.value;
        
        if (!confirmPassword) return true;
        
        if (password !== confirmPassword) {
            this.showFieldError('confirmPassword', 'Passwords do not match');
            return false;
        }
        
        this.showFieldSuccess('confirmPassword');
        return true;
    }
    
    checkPasswordStrength(password) {
        const strength = this.calculatePasswordStrength(password);
        this.updatePasswordStrengthIndicator(strength);
    }
    
    calculatePasswordStrength(password) {
        let score = 0;
        let feedback = [];
        
        if (!password) {
            return { score: 0, level: 'none', feedback: ['Password is required'] };
        }
        
        // Length check
        if (password.length >= 8) score += 25;
        else feedback.push('Use at least 8 characters');
        
        // Lowercase check
        if (/[a-z]/.test(password)) score += 15;
        else feedback.push('Add lowercase letters');
        
        // Uppercase check
        if (/[A-Z]/.test(password)) score += 15;
        else feedback.push('Add uppercase letters');
        
        // Number check
        if (/\d/.test(password)) score += 15;
        else feedback.push('Add numbers');
        
        // Special character check
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score += 20;
        else feedback.push('Add special characters');
        
        // Additional complexity bonus
        if (password.length >= 12) score += 10;
        
        let level;
        if (score < 40) level = 'weak';
        else if (score < 60) level = 'fair';
        else if (score < 80) level = 'good';
        else level = 'strong';
        
        return { score, level, feedback };
    }
    
    updatePasswordStrengthIndicator(strength) {
        const { level, feedback } = strength;
        
        this.strengthIndicator.fill.className = `strength-fill ${level}`;
        this.strengthIndicator.text.className = `strength-text ${level}`;
        
        const levelText = {
            none: 'Password strength will appear here',
            weak: 'Weak password',
            fair: 'Fair password',
            good: 'Good password',
            strong: 'Strong password'
        };
        
        this.strengthIndicator.text.textContent = levelText[level] || levelText.none;
        
        if (feedback.length > 0 && level !== 'strong') {
            this.strengthIndicator.text.title = feedback.join(', ');
        }
    }
    
    showFieldError(fieldName, message) {
        const field = this.fields[fieldName];
        if (!field) return;
        
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');
        
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                        field.closest('.col-12').querySelector('.invalid-feedback');
        
        if (feedback) {
            feedback.textContent = message;
        }
        
        // Bootstrap validation classes for input groups
        const inputGroup = field.closest('.input-group');
        if (inputGroup) {
            inputGroup.classList.add('has-validation');
        }
    }
    
    showFieldSuccess(fieldName, message = '') {
        const field = this.fields[fieldName];
        if (!field) return;
        
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                        field.closest('.col-12').querySelector('.invalid-feedback');
        
        if (feedback) {
            feedback.textContent = message;
        }
    }
    
    showFieldWarning(fieldName, message) {
        const field = this.fields[fieldName];
        if (!field) return;
        
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                        field.closest('.col-12').querySelector('.invalid-feedback');
        
        if (feedback) {
            feedback.textContent = message;
            feedback.style.color = '#f59e0b';
        }
    }
    
    clearFieldError(fieldName) {
        const field = this.fields[fieldName];
        if (!field) return;
        
        field.classList.remove('is-invalid', 'is-valid');
        
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                        field.closest('.col-12').querySelector('.invalid-feedback');
        
        if (feedback) {
            feedback.textContent = '';
            feedback.style.color = '';
        }
    }
    
    getFieldLabel(fieldName) {
        const labelMap = {
            username: 'Username',
            email: 'Email',
            phone: 'Phone number',
            password: 'Password',
            confirmPassword: 'Password confirmation'
        };
        return labelMap[fieldName] || fieldName;
    }
    
    togglePasswordVisibility(fieldName) {
        const field = this.fields[fieldName];
        const button = this.toggleButtons[fieldName];
        
        if (!field || !button) return;
        
        const isPassword = field.type === 'password';
        field.type = isPassword ? 'text' : 'password';
        
        const icon = button.querySelector('i');
        icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        
        button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        
        // Auto-hide after 3 seconds for security
        if (isPassword) {
            setTimeout(() => {
                if (field.type === 'text') {
                    field.type = 'password';
                    icon.className = 'fas fa-eye';
                    button.setAttribute('aria-label', 'Show password');
                }
            }, 3000);
        }
    }
    
    formatPhoneNumber(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // Add Malaysia country code if not present
        if (value.length > 0 && !value.startsWith('60')) {
            if (value.startsWith('0')) {
                value = '60' + value.substring(1);
            }
        }
        
        // Format with + prefix
        if (value.length > 0) {
            value = '+' + value;
        }
        
        e.target.value = value;
    }
    
    showLevelSelection(level, levelId) {
        const levelDescriptions = {
            admin: 'Full system access with administrative privileges',
            staff: 'Standard employee access to system resources',
            medium: 'Limited access to specific system modules',
            guest: 'Basic read-only access to public information'
        };
        
        const description = levelDescriptions[level];
        if (description) {
            // Create or update level description
            let descriptionElement = document.getElementById('levelDescription');
            if (!descriptionElement) {
                descriptionElement = document.createElement('div');
                descriptionElement.id = 'levelDescription';
                descriptionElement.className = 'form-text mt-2';
                this.fields.userLevel.closest('.col-12').appendChild(descriptionElement);
            }
            
            descriptionElement.innerHTML = `
                <i class="fas fa-info-circle me-1"></i>
                <strong>Level ${levelId}:</strong> ${description}
            `;
        }
    }
    
    setSubmitting(isSubmitting) {
        this.isSubmitting = isSubmitting;
        
        const btnContent = this.registerBtn.querySelector('.btn-content');
        const btnLoading = this.registerBtn.querySelector('.btn-loading');
        
        if (isSubmitting) {
            this.registerBtn.classList.add('loading');
            btnContent.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            this.registerBtn.disabled = true;
        } else {
            this.registerBtn.classList.remove('loading');
            btnContent.classList.remove('d-none');
            btnLoading.classList.add('d-none');
            this.registerBtn.disabled = false;
        }
        
        // Disable all form inputs during submission
        const formElements = this.form.querySelectorAll('input, select, button');
        formElements.forEach(el => {
            el.disabled = isSubmitting;
        });
    }
    
    handleRegistrationSuccess(result) {
        // Show success modal
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
        
        // Reset form
        this.form.reset();
        this.clearAllValidation();
        this.resetPasswordStrength();
        
        // Auto-redirect after 5 seconds
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 5000);
        
        this.announceToScreenReader('Registration successful! Welcome to ePSM BPSM.');
    }
    
    handleRegistrationError(message, fieldErrors) {
        // Pastikan sentiasa objek walaupun undefined
        fieldErrors = fieldErrors || {};
    
        this.showBootstrapAlert('danger', message);
    
        Object.keys(fieldErrors).forEach(fieldName => {
            if (this.fields[fieldName]) {
                this.showFieldError(fieldName, fieldErrors[fieldName]);
            }
        });
    
        const firstErrorField = this.form.querySelector('.is-invalid');
        if (firstErrorField) {
            firstErrorField.focus();
        }
    
        this.announceToScreenReader(`Registration failed: ${message}`);
    }
    
    
    
    showBootstrapAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert-registration');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-registration`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : 'check-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert after form
        this.form.parentNode.insertBefore(alertDiv, this.form.nextSibling);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                const alert = new bootstrap.Alert(alertDiv);
                alert.close();
            }
        }, 5000);
        
        // Scroll to alert
        alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    clearAllValidation() {
        Object.keys(this.fields).forEach(fieldName => {
            this.clearFieldError(fieldName);
        });
    }
    
    resetPasswordStrength() {
        this.strengthIndicator.fill.className = 'strength-fill';
        this.strengthIndicator.text.className = 'strength-text';
        this.strengthIndicator.text.textContent = 'Password strength will appear here';
    }
    
    focusNextField(currentField) {
        const formElements = Array.from(this.form.querySelectorAll('input, select, button'));
        const currentIndex = formElements.indexOf(currentField);
        
        if (currentIndex >= 0 && currentIndex < formElements.length - 1) {
            formElements[currentIndex + 1].focus();
        }
    }
    
    createAriaLiveRegion() {
        const liveRegion = document.createElement('div');
        liveRegion.id = 'ariaLiveRegion';
        liveRegion.setAttribute('aria-live', 'polite');
        liveRegion.setAttribute('aria-atomic', 'true');
        liveRegion.className = 'visually-hidden';
        document.body.appendChild(liveRegion);
        this.ariaLiveRegion = liveRegion;
    }
    
    announceToScreenReader(message) {
        if (this.ariaLiveRegion) {
            this.ariaLiveRegion.textContent = message;
            
            // Clear after announcement
            setTimeout(() => {
                this.ariaLiveRegion.textContent = '';
            }, 1000);
        }
    }
    
    // Security utilities
    generateCSRFToken() {
        const array = new Uint8Array(32);
        crypto.getRandomValues(array);
        return Array.from(array, byte => byte.toString(16).padStart(2, '0')).join('');
    }
    
    getDeviceFingerprint() {
        const fingerprint = {
            userAgent: navigator.userAgent,
            language: navigator.language,
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            screen: `${screen.width}x${screen.height}`,
            colorDepth: screen.colorDepth
        };
        
        return btoa(JSON.stringify(fingerprint)).substring(0, 32);
    }
}

// Utility function for redirect from success modal
function redirectToLogin() {
    window.location.href = 'index.html';
}

// Initialize registration system on DOM load
document.addEventListener('DOMContentLoaded', () => {
    new GovernmentRegistration();
});
