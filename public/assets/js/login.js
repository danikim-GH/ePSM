// Login Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Form elements
    const loginForm = document.querySelector('form[method="POST"]');
    const loginButton = loginForm?.querySelector('button[type="submit"]');
    const passwordInput = document.getElementById('katalaluan');
    const togglePasswordButton = document.querySelector('.password-toggle');
    
    // Initialize form
    initForm();
    
    function initForm() {
        // Add toggle password functionality
        if (togglePasswordButton && passwordInput) {
            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? 
                    '<i class="fas fa-eye"></i>' : 
                    '<i class="fas fa-eye-slash"></i>';
            });
        }
        
        // Form submission handling
        if (loginForm) {
            loginForm.addEventListener('submit', handleFormSubmit);
        }
        
        // Input validation on blur
        const inputs = loginForm?.querySelectorAll('input[required]');
        inputs?.forEach(input => {
            input.addEventListener('blur', validateInput);
            input.addEventListener('input', clearError);
        });
        
        // Auto-focus first input
        const firstInput = loginForm?.querySelector('input');
        if (firstInput) {
            firstInput.focus();
        }
    }
    
    function validateInput(event) {
        const input = event.target;
        const value = input.value.trim();
        
        if (input.id === 'NoKP') {
            // Validate Malaysian IC number format (basic validation)
            /** 
            if (value && !/^\d{6}-\d{2}-\d{4}$|^\d{12}$/.test(value)) {
                showFieldError(input, 'Sila masukkan format No. Kad Pengenalan yang betul (contoh: 901231-01-1234 atau 901231011234)');
                return false;
            }
                */
        }
        

        
        clearFieldError(input);
        return true;
    }
    
    function showFieldError(input, message) {
        clearFieldError(input);
        input.classList.add('error');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.cssText = `
            color: #c33;
            font-size: 12px;
            margin-top: 4px;
            animation: slideIn 0.3s ease;
        `;
        errorDiv.textContent = message;
        
        input.parentNode.appendChild(errorDiv);
    }
    
    function clearFieldError(input) {
        input.classList.remove('error');
        const existingError = input.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }
    
    function clearError(event) {
        const input = event.target;
        if (input.classList.contains('error')) {
            clearFieldError(input);
        }
    }
    
    async function handleFormSubmit(event) {
        event.preventDefault();
        
        // Validate all inputs
        const inputs = loginForm.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            input.dispatchEvent(new Event('blur'));
            if (input.classList.contains('error')) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            showMessage('Sila isi semua ruangan dengan betul', 'error');
            return;
        }
        
        // Disable button and show loading state
        if (loginButton) {
            loginButton.disabled = true;
            loginButton.innerHTML = '<span class="loading-spinner"></span> Sedang Memproses...';
        }
        
        try {
            // Show processing message
            showMessage('Mengesahkan maklumat anda...', 'info');
            
            // For now, just submit the form normally
            // Later, you can add AJAX submission here
            await simulateAPICall();
            
            // If we reach here, form submission will continue normally
            // Remove the loading state before actual submission
            if (loginButton) {
                loginButton.disabled = false;
                loginButton.textContent = 'Log Masuk';
            }
            
            // Proceed with form submission
            loginForm.submit();
            
        } catch (error) {
            // Handle API call error
            if (loginButton) {
                loginButton.disabled = false;
                loginButton.textContent = 'Log Masuk';
            }
            showMessage('Ralat berlaku. Sila cuba lagi.', 'error');
        }
    }
    
    function simulateAPICall() {
        return new Promise(resolve => {
            setTimeout(resolve, 1000);
        });
    }
    
    function showMessage(message, type = 'info') {
        // Remove existing messages
        const existingMessages = document.querySelectorAll('.custom-message');
        existingMessages.forEach(msg => msg.remove());
        
        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = `custom-message ${type}-message`;
        messageDiv.style.cssText = `
            background: ${type === 'error' ? '#fee' : type === 'success' ? '#d4edda' : '#e7f3ff'};
            color: ${type === 'error' ? '#c33' : type === 'success' ? '#155724' : '#004085'};
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid ${type === 'error' ? '#c33' : type === 'success' ? '#28a745' : '#007bff'};
            font-size: 14px;
            animation: slideIn 0.3s ease;
        `;
        messageDiv.textContent = message;
        
        // Insert after the form header or before the form
        const header = document.querySelector('.login-header');
        if (header) {
            header.parentNode.insertBefore(messageDiv, header.nextSibling);
        } else {
            loginForm.parentNode.insertBefore(messageDiv, loginForm);
        }
        
        // Auto-remove after 5 seconds (for info messages)
        if (type === 'info') {
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.style.opacity = '0';
                    messageDiv.style.transform = 'translateY(-10px)';
                    messageDiv.style.transition = 'all 0.3s ease';
                    setTimeout(() => messageDiv.remove(), 300);
                }
            }, 5000);
        }
    }
    
    // Add CSS for field errors
    const style = document.createElement('style');
    style.textContent = `
        .error {
            border-color: #c33 !important;
            background: #fff5f5 !important;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
});