class EPSMRegister{
    constructor(){
        this.form = document.getElementById('registrationForm')
        this.registerBtn = document.getElementById('registerBtn')
        this.fields={
            username: document.getElementById('username'),
            email: document.getElementById('email'),
            phone: document.getElementById('phone'),
            userLevel: document.getElementById('userLevel'),
            userLevelId: document.getElementById('userLevelId'),
            password: document.getElementById('password'),
            confirmPassword: document.getElementById('confirmPassword'),
            agreeTerms: document.getElementById('agreeTerms')
        };
    
        this.toggleBtn = {
            password: document.getElementById('togglePassword'),
            confirmPassword: document.getElementById('toggleConfirmPassword')
        };
        
        this.strengthIndi ={
            fill: document.getElementById('strengthFill')
        };

        this.isSubmit = false;
        this.validationRules = this.initValidationRules();

        this.init();
    }

    init(){
        this.bindEvents();
        this.initPasswordStrength();
        this.initRealTimeValidation();
        //this.initAccessibilityFeatures();
        this.initUserLevelHandler();
    }

    initValidationRules(){
        return{
            username :{
                required:true,
                minLength: 3,
                maxLength:30,
                pattern: /^[a-zA-Z0-9._-]+$/,
                message: 'Username must be 3-30 Characters (A-Z,.!_@#$%)'
            },
            email:{
                required:true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter a valid email'
            },
            phone:{
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

    bindEvents(){
        //form submit
        this.form.addEventListener('submit', (e)=> this.handleSubmit(e));

        //password toggle
        this.toggleBtn.password.addEventListener('click', ()=>
            this.togglePassVisible('password'));
        this.toggleBtn.confirmPassword.addEventListener('click', ()=> 
            this.togglePassVisible('confirmPassword'));

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



    initUserLevelHandler() {
        this.fields.userLevel.addEventListener('change', (e) => {
            const selectedOption = e.target.selectedOptions[0];
            if (selectedOption) {
                const levelId = selectedOption.getAttribute('data-id');
                this.fields.userLevelId.value = levelId || '';
                
                // Add visual feedback
                this.showLevelSelection(selectedOption.value, levelId);
            }
        });
    }

    async handleSubmit(e){
        e.preventDefault();

        if(this.isSubmit) return;

        //validate semua yang dalam form
        const isValid = this.validationForm();
        if(!isValid){
            //this.announceToScreenReader('Form contains errors. Please review and correct');
            return;
        }

        this.setSubmitting(true);

        try{
            const formData = new FormData(this.form);

            formData.append('crsf_token',this.generateCSRFToken());
            formData.append('timestamp',Date.now());
            formData.append('device_fingerprint',this.getDeviceFingerprint());

            const response = await fetch('register.php',{
                method:'POST',
                body: formData,
                credentials: 'same-origin'
            });

            if(!response.ok){
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();

            if(result.success){
                this.handleRegistrationSuccess(result);
            } else{
                this.handleRegistrationError(result.message, result.errors);
            }
        } catch(error){
            console.error('Registration error:', error);
            this.handleRegistrationError('Network error. Please check your connection and try again.');
        } finally{
            this.setSubmitting(false);
        }
    }

    validateForm(){
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
        
        if (!this.fields.agreeTerms.checked) {
            this.showFieldError('agreeTerms', 'You must agree to the terms and conditions');
            isValid = false;
        }
        
        if (!this.fields.userLevel.value) {
            this.showFieldError('userLevel', 'Please select an access level');
            isValid = false;
        }
        
        return isValid;
    }

    validateField(fieldName){
        const field = this.fields[fieldName];
        const rules = this.validationRules[fieldName];

        if(!field || !rules) return true;

        const value = field.value.trim();

        //required validation
        if(rules.required && validationRules){
            this.showFieldError(fieldName, `${this.getFieldLabel(fieldName)} is required`);
            return false;
        }   

        if(!value) return true;

        if(rules.minLength && value.length < rules.minLength){
            this.showFieldError(fieldName, `${this.getFieldLabel(fieldName)} must be at least ${rules.minLength} character`);
            return false;
        }

        if(rules.maxLength && value.length > rules.maxLength){
            this.showFieldError(fieldName, `${this.getFieldLabel(fieldName)} must not exceed ${rules.maxLength} characters`);
            return false;
        }

        //pattern validation
        if(rules.pattern && !rules.pattern.test(value)){
            this.showFieldError(fieldName, rules.message);
            return false;
        }

        this.showFieldSuccess(fieldName);
        return true;
    }

    validateEmail(email){
        if(!email) return;

        const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

        if(isValid){
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

    async checkUsernameAvailability(username){
        if(!username || username.length < 3) return;

        //Mock availablity check
        const unavailableUsernames = ['admin','administrator','root','test','user'];

        if(unavailableUsernames.includes(username.toLowerCase())){
            this.showFieldError('username', 'This username is not available');
        } else{
            this.showFieldSuccess('username', 'Username is available');
        }
    }

    validatePasswordMatch(){
        const password = this.fields.password.value;
        const confirmPassword = this.fields.confirmPassword.value;

        if(!confirmPassword) return true;

        if(password !== confirmPassword){
            this.showFieldError('confirmPassword','Password do not match');
            return false;
        }

        this.showFieldSuccess('confirmPassword');
        return true;
    }

    checkPasswordStrength(password){
        const strength = this.calculatePasswordStrength(password);
        this.updatePasswordStrengthIndi(strength);
    }

    calculatePasswordStrength(password){
        let score=0;
        let feedback=[];

        if(!password){
            return {score:0,level:'none', feedback:['Password is required']};
        }

        //check length pass
        if(password.length >= 8) score +=25;

        //lowercase
        if(/[a-z]/.test(password)) score +=15;
        else feedback.push('Tambahkan huruf kecil');

        //uppercase
        if(/[A-Z]/.test(password)) score += 15;
        else feedback.push('Tambahkan huruf besar');

        //number check 
        if(/\d/.test(password)) score+= 15;
        else feedback.push('Tambahkan nombor');

        //for special char !@*()$%#
        if(/[!@#$%^&*(),.?":{}|,.]<>/.test(password)) score+= 20;
        else feedback.push('Tambahkan Aksara');

        //string show untuk user(weak,strong)
        if(password.length)score +=10;

        let level; 
        if(score<40) level = 'weak';
        else if(score < 60) level = 'fair';
        else if(score<80) level = 'good';
        else level = strong;

        return{ score , level , feedback};
    }

    updatePasswordStrengthIndi(strength){
        const{level , feedback}=strength;

        this.strengthIndi.fill.className = `strength-fill ${level}`;
        this.strengthIndi.text.className = `strength-text ${level}`;

        const levelText = {
            none: 'Password strength will appear here',
            weak: 'Weak password',
            fair: 'Fair password',
            good: 'Good password',
            strong: 'Strong password'
        };

        this.strengthIndi.text.textContent = levelText[level] || levelText.none;

        if(feedback.length > 0 && level !== 'strong'){
            this.strengthIndi.text.title = feedback.join(', ');
        }
    }

    showFieldError(fieldName, message){
        const field = this.fields[fieldName];
        if(!field) true;

        field.classList.remove('is-valid');
        field.classList.add('is-invalid');

        const feedback = field.parentNode.querySelector('.invalid-feedback') ||
            field.closest('.col-12').querySelector('.invalid-feedback');

        if(feedback){
            feedback.textContent = message;
        }

        // Bootstrap validation classes for input groups
        const inputGroup = field.closest('.input-group');
        if (inputGroup) {
            inputGroup.classList.add('has-validation');
        }
    }

    showFieldSuccess(fieldName, message = ''){
        const field = this.fields[fieldName];
        if(!field) return;

        field.classList.remove('is-invalid');
        field.classList.add('is-valid');

        const feedback = field.parentNode.querySelector('.invalid-feedback') ||
                        field.closest('.col-12').querySelector('.invalid-feedback');

        if(feedback){
            feedback.textContent = message;
        }
    }

    showFieldWarning(fieldName, message){
        const field = this.fields[fieldName];
        if(!field) return;

        const feedback = field.parentNode.querySelector('.invalid-feedback')||
                        field.closest('.col-12').querySelector('.invalid-feedback');

        if(feedback){
            feedback.textContent = message;
            feedback.style.color = '#f59e0b';
        }
    }

    clearFieldError(fieldName){
        const field = this.fields[fieldName];
        if(!field) return;

        field.classList.remove('is-invalid','is-valid');

        const feedback = field.parentNode.querySelector('.invalid-feedback') ||
                        field.closest('.col-12').querySelector('.invalid-feedback')

        if(feedback){
            feedback.textContent = '';
            feedback.style.color = '';
        }
    }

    getFieldLabel(fieldName){
        const labelMap = {
            username: 'Username',
            email: 'Email',
            phone: 'Phone number',
            password: 'Password',
            confirmPassword: 'Password confirmation'
        };
        return labelMap[fieldName] || fieldName;
    }

    togglePassVisible(fieldName){
        const field = this.fields[fieldName];
        const button = this.toggleBtn[fieldName];

        if(!field || !button)return;

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

    formatPhoneNumber(e){
        let value = e.target.value.replace(/\D/g, '');

        //add 60 kat depan
        if(value.length > 0 && !value.startsWih('60')){
            if(value.startsWih('0')){
                value = '60'+ value.substring(0);
            }
        }

        // + kat depan
        if(value.length > 0){
            value = '+' + value;
        }

        e.target.value = value;
    }

    showLevelSelection(level, levelId){
        const levelDescription = {
            admin: 'Full system access',
            staff: 'Standard employee acces',
            medium: 'Limited access to specific modules',
            guest: 'Basic read-only access to public information'
        };

        const description = levelDescription[level]
        if(description){
            let descriptionElement = document.getElementById('levelDescription');
            if(!descriptionElement){
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

    setSubmitting(isSubmit){
        this.isSubmit = isSubmit;

        const btnContent = this.registerBtn.querySelector('.btn-content');
        const btnLoading = this.registerBtn.querySelector('.btn-loading');

        if(isSubmit){
            this.registerBtn.classList.add('loading');
            btnContent.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            this.registerBtn.disabled = true;
        } else{
            this.registerBtn.classList.add('loading');
            btnContent.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            this.registerBtn.disabled = false;
        }
        // Disable all form inputs during submission
        const formElements = this.form.querySelectorAll('input, select, button');
        formElements.forEach( el => {
            el.disabled = isSubmit;
        });
    }

    handleRegistrationSuccess(result){
        //success modal
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();

        //reset form
        this.form.reset();
        this.cleaerAllValidation();
        this.resetPasswordStrength();
        

        //auto direct for 5s
        setTimeout(()=>{
            window.location.href = 'register.html';
        },5000);
    }

    handleRegistrationError(message, fieldErrors = {}){
        //show error
        this.showBootstrapAlert('danger', message);

        //show specifiv dekat field
        Object.keys(fieldErrors).forEach(fieldName => {
            if(this.fields[fieldName]){
                this.showFieldError(fieldName, fieldErrors[fieldName]);
            }
        });

        //focus dekat first error field
        const firstErrorField = this.form.querySelector('.is-invalid');
        if (firstErrorField) {
            firstErrorField.focus();
        }
        
        //this.announceToScreenReader(`Registration failed: ${message}`);
    }

    showBootstrapAlert(type, message){
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

        //insert lepas form
        this.form.parentNode.insertBefore(alertDiv, this.form.nextSibling);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                const alert = new bootstrap.Alert(alertDiv);
                alert.close();
            }
        }, 5000);
        
        // Scroll to alert
        alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' })
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

    //extra features
    focusNextField(currentField){
        const formElements = Array.from(this.form.querySelectorAll('input, select, button'));
        const currentIndex = formElements.indexOf(currentField);

        if(currentIndex >=0 && currentIndex < formElements.length - 1){
            formElements[currentIndex + 1].focus();
        }
    }

    //security utilities
    generateCSRFToken(){
        const array = new Uint16Array(32);
        crypto.getRandomValues(array);
        return Array.from(array, byte=> byte.toString(16).padStart(2,'0').join(''));
    }

    getDeviceFingerprint(){
        const fingerprint = {
            userAgent: navigator.userAgent,
            language: navigator.language,
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            screen: `${screen.width}x${screen.height}`,
            colorDepth: screen.colorDepth
        };

        return btoa(JSON.stringify(fingerprint)).substring(0,32);
    }
}

function redirectToLogin(){
    window.location.href = 'index.php';
}

document.addEventListener('DOMContentLoaded', () =>{
    new EPSMRegister();
});
