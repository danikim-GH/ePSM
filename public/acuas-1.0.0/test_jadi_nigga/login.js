// Government Portal Login JavaScript
// Enhanced security and user experience features
console.log("nigga babi");
class GovernmentLogin {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.loginBtn = document.getElementById('loginBtn');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.passwordField = document.getElementById('password');
        this.usernameField = document.getElementById('username');
        //this.userTypeField = document.getElementById('userType');
        this.errorAlert = document.getElementById('errorAlert');
        this.successAlert = document.getElementById('successAlert');
        
        this.isLoading = false;
        this.loginAttempts = 0;
        this.maxAttempts = 5;
        this.lockoutDuration = 15 * 60 * 1000; // 15 minutes
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.initSecurityFeatures();
        this.loadSavedCredentials();
        this.initAccessibilityFeatures();
    }
    
    bindEvents() {
        // Form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Password toggle
        this.passwordToggle.addEventListener('click', () => this.togglePassword());
        
        // Real-time validation
        this.usernameField.addEventListener('input', () => this.validateUsername());
        this.passwordField.addEventListener('input', () => this.validatePassword());
       // this.userTypeField.addEventListener('change', () => this.validateUserType());
        
        // Enhanced security monitoring
        this.passwordField.addEventListener('paste', (e) => this.handlePasswordPaste(e));
        
        // Auto-focus and navigation
        /**
        this.userTypeField.addEventListener('change', () => {
            if (this.userTypeField.value) {
                this.usernameField.focus();
            }
        });
         */

        // Prevent form auto-complete in sensitive areas
        this.form.addEventListener('focus', () => this.handleFormFocus(), true);
        
        // Session timeout warning
        this.initSessionTimeout();
        
        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => this.handleKeyboardShortcuts(e));
        
        // Prevent right-click context menu on sensitive elements
        [this.passwordField, this.usernameField].forEach(field => {
            field.addEventListener('contextmenu', (e) => e.preventDefault());
        });
        
        // Clear clipboard after password operations
        this.passwordField.addEventListener('copy', () => this.scheduleClipboardClear());
        this.passwordField.addEventListener('cut', () => this.scheduleClipboardClear());
    }
    
    initSecurityFeatures() {
        // Check for suspicious activity
        this.detectBotBehavior();
        
        // Initialize CSRF protection
        this.initCSRFProtection();
        
        // Check browser security
        this.checkBrowserSecurity();
        
        // Initialize device fingerprinting
        this.initDeviceFingerprinting();
        
        // Monitor for developer tools
        this.detectDevTools();
    }
    
    async handleSubmit(e) {
        e.preventDefault();
    
        const formEl = document.getElementById("loginForm");
        const formData = new FormData(formEl);
    
        // Add security tokens
        formData.append('csrf_token', this.getCSRFToken());
        formData.append('device_id', this.getDeviceId());
        formData.append('timestamp', Date.now());
    
        for (let [key, value] of formData.entries()) {
            console.log("FINAL FORM DATA:", key, value);
        }
    
        fetch("login.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            console.log("RAW RESPONSE:", text);
        
            let result;
            try {
                result = JSON.parse(text);
                console.log("SERVER RESULT:", result);
            } catch (e) {
                console.error("❌ JSON parse failed:", e);
                return;
            }
        
            if (result.success) {
                console.log("Login OK, redirecting...");
                window.location.href = result.redirect;
            } else {
                console.error("Login failed:", result.message);
                document.querySelector("#errorAlert .alert-text").textContent = result.message;
                document.getElementById("errorAlert").style.display = "block";
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
        });
    }
    
        
    handleLoginSuccess(result) {
        this.loginAttempts = 0;
        this.clearLockout();
        
        this.showAlert('success', 'Login successful! Redirecting...');
        
        // Save credentials if remember me is checked
        if (document.getElementById('rememberMe').checked) {
            this.saveCredentials();
        }
        
        // Add success animation
        this.form.classList.add('success');
        
        // Redirect after delay
        setTimeout(() => {
            if (result.redirect) {
                window.location.href = result.redirect;
            } else {
                // Fallback redirect based on user type
                const redirectUrl = result.data?.user_type === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php';
                window.location.href = redirectUrl;
            }
        }, 1500);
    }
    
    handleLoginError(message) {
        this.loginAttempts++;
        
        this.showAlert('error', message);
        
        // Shake animation for error
        this.form.classList.add('shake');
        setTimeout(() => this.form.classList.remove('shake'), 500);
        
        // Clear sensitive fields
        this.passwordField.value = '';
        
        // Focus on first empty field
        if (!this.usernameField.value) {
            this.usernameField.focus();
        } else {
            this.passwordField.focus();
        }
        
        // Check for lockout
        if (this.loginAttempts >= this.maxAttempts) {
            this.setLockout();
        }
        
        // Add progressive delay for failed attempts
        const delay = Math.min(this.loginAttempts * 1000, 5000);
        this.loginBtn.disabled = true;
        setTimeout(() => {
            this.loginBtn.disabled = false;
        }, delay);
    }
    
    validateForm() {
        let isValid = true;
        
        // Clear previous validation styles
        this.clearValidationErrors();
        
        // Validate user type
        /** 
        if (!this.userTypeField.value) {
            this.addValidationError(this.userTypeField, 'Please select an access level');
            isValid = false;
        }
        */
        // Validate username
        if (!this.usernameField.value.trim()) {
            this.addValidationError(this.usernameField, 'Username is required');
            isValid = false;
        } else if (!this.validateUsername()) {
            isValid = false;
        }
        
        // Validate password
        if (!this.passwordField.value) {
            this.addValidationError(this.passwordField, 'Password is required');
            isValid = false;
        } else if (!this.validatePassword()) {
            isValid = false;
        }
        
        return isValid;
    }
    
    validateUsername() {
        const username = this.usernameField.value.trim();
        const usernameRegex = /^[a-zA-Z0-9._-]{3,30}$/;
        
        if (username && !usernameRegex.test(username)) {
            this.addValidationError(this.usernameField, 'Invalid username format');
            return false;
        }
        
        this.removeValidationError(this.usernameField);
        return true;
    }
    
    validatePassword() {
        const password = this.passwordField.value;
        
        if (password.length > 0 && password.length < 6) {
            this.addValidationError(this.passwordField, 'Password must be at least 6 characters');
            return false;
        }
        
        this.removeValidationError(this.passwordField);
        return true;
    }

    /**
    validateUserType() {
        if (this.userTypeField.value) {
            this.removeValidationError(this.userTypeField);
            return true;
        }
        return false;
    }
     */

    addValidationError(field, message) {
        field.classList.add('error');
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }
    
    removeValidationError(field) {
        field.classList.remove('error');
        const errorMessage = field.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }
    
    clearValidationErrors() {
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
    }
    
    togglePassword() {
        const isPassword = this.passwordField.type === 'password';
        this.passwordField.type = isPassword ? 'text' : 'password';
        
        const icon = this.passwordToggle.querySelector('i');
        icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        
        // Security: Auto-hide password after 3 seconds
        if (isPassword) {
            setTimeout(() => {
                if (this.passwordField.type === 'text') {
                    this.passwordField.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            }, 3000);
        }
    }
    
    setLoading(loading) {
        this.isLoading = loading;
        this.loginBtn.classList.toggle('loading', loading);
        
        // Disable all form elements during loading
        const formElements = this.form.querySelectorAll('input, select, button');
        formElements.forEach(el => {
            el.disabled = loading;
        });
    }
    
    showAlert(type, message) {
        // Hide all alerts first
        this.errorAlert.style.display = 'none';
        this.successAlert.style.display = 'none';
        
        const alert = type === 'error' ? this.errorAlert : this.successAlert;
        const textElement = alert.querySelector('.alert-text');
        
        textElement.textContent = message;
        alert.style.display = 'flex';
        
        // Auto-hide success messages
        if (type === 'success') {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }
        
        // Scroll to alert if it's not visible
        alert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    // Security Features
    detectBotBehavior() {
        let mouseMovements = 0;
        let keystrokes = 0;
        
        document.addEventListener('mousemove', () => mouseMovements++);
        document.addEventListener('keydown', () => keystrokes++);
        
        // Check for human-like behavior after 10 seconds
        setTimeout(() => {
            if (mouseMovements < 5 && keystrokes < 5) {
                console.warn('Potential bot behavior detected');
                // In production, you might want to add additional verification
            }
        }, 10000);
    }
    
    initCSRFProtection() {
        // Generate and store CSRF token
        let token = sessionStorage.getItem('csrf_token');
        if (!token) {
            token = this.generateToken();
            sessionStorage.setItem('csrf_token', token);
        }
    }
    
    getCSRFToken() {
        return sessionStorage.getItem('csrf_token') || this.generateToken();
    }
    
    generateToken() {
        return Array.from(crypto.getRandomValues(new Uint8Array(32)))
            .map(b => b.toString(16).padStart(2, '0'))
            .join('');
    }
    
    checkBrowserSecurity() {
        const warnings = [];
        
        // Check for HTTPS
        if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
            warnings.push('Insecure connection detected');
        }
        
        // Check for supported features
        if (!window.crypto || !window.crypto.getRandomValues) {
            warnings.push('Browser security features not available');
        }
        
        if (warnings.length > 0) {
            console.warn('Security warnings:', warnings);
        }
    }
    
    initDeviceFingerprinting() {
        const fingerprint = {
            userAgent: navigator.userAgent,
            language: navigator.language,
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            screen: `${screen.width}x${screen.height}`,
            colorDepth: screen.colorDepth,
            timestamp: Date.now()
        };
        
        const deviceId = btoa(JSON.stringify(fingerprint)).substring(0, 32);
        sessionStorage.setItem('device_id', deviceId);
    }
    
    getDeviceId() {
        return sessionStorage.getItem('device_id') || 'unknown';
    }
    
    detectDevTools() {
        let devtools = false;
        
        const threshold = 160;
        
        setInterval(() => {
            if (window.outerHeight - window.innerHeight > threshold || 
                window.outerWidth - window.innerWidth > threshold) {
                if (!devtools) {
                    devtools = true;
                    console.warn('Developer tools detected');
                }
            } else {
                devtools = false;
            }
        }, 500);
    }
    
    // Session Management
    initSessionTimeout() {
        const timeout = 30 * 60 * 1000; // 30 minutes
        let warningShown = false;
        
        const checkTimeout = () => {
            const lastActivity = sessionStorage.getItem('last_activity');
            if (lastActivity) {
                const elapsed = Date.now() - parseInt(lastActivity);
                
                // Show warning at 25 minutes
                if (elapsed > (timeout - 5 * 60 * 1000) && !warningShown) {
                    warningShown = true;
                    this.showSessionWarning();
                }
                
                // Force logout at 30 minutes
                if (elapsed > timeout) {
                    this.handleSessionTimeout();
                }
            }
        };
        
        // Update activity timestamp
        const updateActivity = () => {
            sessionStorage.setItem('last_activity', Date.now().toString());
            warningShown = false;
        };
        
        // Track user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, updateActivity, true);
        });
        
        // Initial timestamp
        updateActivity();
        
        // Check every minute
        setInterval(checkTimeout, 60000);
    }
    
    showSessionWarning() {
        if (confirm('Your session will expire in 5 minutes due to inactivity. Click OK to stay logged in.')) {
            sessionStorage.setItem('last_activity', Date.now().toString());
        }
    }
    
    handleSessionTimeout() {
        alert('Your session has expired due to inactivity. Please log in again.');
        sessionStorage.clear();
        window.location.reload();
    }
    
    // Lockout Management
    isLockedOut() {
        const lockoutTime = localStorage.getItem('lockout_time');
        if (lockoutTime && Date.now() - parseInt(lockoutTime) < this.lockoutDuration) {
            return true;
        }
        this.clearLockout();
        return false;
    }
    
    setLockout() {
        localStorage.setItem('lockout_time', Date.now().toString());
        localStorage.setItem('login_attempts', this.loginAttempts.toString());
        
        const remainingTime = Math.ceil(this.lockoutDuration / 60000);
        this.showAlert('error', `Account temporarily locked due to multiple failed attempts. Try again in ${remainingTime} minutes.`);
    }
    
    clearLockout() {
        localStorage.removeItem('lockout_time');
        localStorage.removeItem('login_attempts');
    }
    
    // Credential Management
    saveCredentials() {
        if (document.getElementById('rememberMe').checked) {
            const encryptedData = btoa(JSON.stringify({
                username: this.usernameField.value,
                //userType: this.userTypeField.value,
                timestamp: Date.now()
            }));
            localStorage.setItem('saved_credentials', encryptedData);
        }
    }
    
    loadSavedCredentials() {
        const saved = localStorage.getItem('saved_credentials');
        if (saved) {
            try {
                const data = JSON.parse(atob(saved));
                
                // Check if data is not too old (30 days)
                if (Date.now() - data.timestamp < 30 * 24 * 60 * 60 * 1000) {
                    this.usernameField.value = data.username || '';
                    //this.userTypeField.value = data.userType || '';
                    document.getElementById('rememberMe').checked = true;
                } else {
                    localStorage.removeItem('saved_credentials');
                }
            } catch (e) {
                localStorage.removeItem('saved_credentials');
            }
        }
    }
    
    // Accessibility Features
    initAccessibilityFeatures() {
        // High contrast mode detection
        if (window.matchMedia && window.matchMedia('(prefers-contrast: high)').matches) {
            document.body.classList.add('high-contrast');
        }
        
        // Reduced motion detection
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.body.classList.add('reduced-motion');
        }
        
        // Font size preferences
        const savedFontSize = localStorage.getItem('font_size_preference');
        if (savedFontSize) {
            document.documentElement.style.fontSize = savedFontSize;
        }
        
        // Keyboard navigation announcements
        this.initAriaAnnouncements();
    }
    
    initAriaAnnouncements() {
        const announcer = document.createElement('div');
        announcer.setAttribute('aria-live', 'polite');
        announcer.setAttribute('aria-atomic', 'true');
        announcer.style.position = 'absolute';
        announcer.style.left = '-10000px';
        announcer.style.width = '1px';
        announcer.style.height = '1px';
        announcer.style.overflow = 'hidden';
        document.body.appendChild(announcer);
        
        this.announcer = announcer;
    }
    
    announce(message) {
        if (this.announcer) {
            this.announcer.textContent = message;
        }
    }
    
    // Keyboard Shortcuts
    handleKeyboardShortcuts(e) {
        // Alt + L: Focus username field
        if (e.altKey && e.key.toLowerCase() === 'l') {
            e.preventDefault();
            this.usernameField.focus();
            this.announce('Username field focused');
        }
        
        // Alt + P: Focus password field
        if (e.altKey && e.key.toLowerCase() === 'p') {
            e.preventDefault();
            this.passwordField.focus();
            this.announce('Password field focused');
        }
        
        // Escape: Clear form
        if (e.key === 'Escape') {
            if (confirm('Clear the form?')) {
                this.form.reset();
                this.clearValidationErrors();
                //this.userTypeField.focus();
            }
        }
    }
    
    // Security Utilities
    handlePasswordPaste(e) {
        // Allow paste but warn about security
        setTimeout(() => {
            console.warn('Password pasted from clipboard. Ensure your clipboard is secure.');
        }, 100);
    }
    
    scheduleClipboardClear() {
        // Clear clipboard after 30 seconds for security
        setTimeout(() => {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText('').catch(() => {
                    // Silently fail if clipboard access is denied
                });
            }
        }, 30000);
    }
    
    handleFormFocus() {
        // Disable autocomplete on focus for security
        this.passwordField.setAttribute('autocomplete', 'new-password');
    }
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
    new GovernmentLogin();
});

// Additional CSS for validation errors and animations
const additionalStyles = `
    .form-input.error,
    .form-select.error {
        border-color: #ef4444;
        animation: inputShake 0.5s ease-in-out;
    }
    
    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes inputShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .login-form.shake {
        animation: formShake 0.5s ease-in-out;
    }
    
    @keyframes formShake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
        20%, 40%, 60%, 80% { transform: translateX(10px); }
    }
    
    .login-form.success {
        animation: successPulse 0.5s ease-in-out;
    }
    
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    .high-contrast .login-card {
        border: 3px solid #000;
        background: #fff;
    }
    
    .high-contrast .form-input,
    .high-contrast .form-select {
        border: 2px solid #000;
    }
    
    .reduced-motion * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// Export for potential module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = GovernmentLogin;
}