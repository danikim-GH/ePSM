// assets/js/adminSetting.js

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const addNewImageBtn = document.getElementById('addNewImageBtn');
    const carouselFormContainer = document.getElementById('carouselFormContainer');
    const carouselForm = document.getElementById('carouselForm');
    const cancelBtn = document.getElementById('cancelBtn');
    const formTitle = document.getElementById('formTitle');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    

    let isEditMode = false;
    let itemToDelete = null;

    let deleteCarouselId = null;
    
    // Event Listeners
    addNewImageBtn.addEventListener('click', showAddForm);
    cancelBtn.addEventListener('click', hideForm);
    carouselForm.addEventListener('submit', handleFormSubmit);
    imageInput.addEventListener('change', handleImagePreview);
    confirmDeleteBtn.addEventListener('click', confirmDelete);
    
    

    // Functions
    function showAddForm() {
        isEditMode = false;
        formTitle.textContent = 'Add New Carousel Image';
        submitText.textContent = 'Add Image';
        carouselForm.reset();
        carouselFormContainer.style.display = 'block';
        imagePreview.style.display = 'none';
        clearErrors();
        scrollToForm();
    }
    
    function showEditForm(data) {
        isEditMode = true;
        formTitle.textContent = 'Edit Carousel Image';
        submitText.textContent = 'Update Image';
        
        // Fill form with data
        document.getElementById('carouselId').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('description').value = data.description;
        document.getElementById('order').value = data.order;
        
        // Show image preview if exists
        if (data.image_path) {
            previewImage.src = data.image_path;
            imagePreview.style.display = 'block';
        }
        
        carouselFormContainer.style.display = 'block';
        clearErrors();
        scrollToForm();
    }
    
    function hideForm() {
        carouselFormContainer.style.display = 'none';
        isEditMode = false;
        carouselForm.reset();
        imagePreview.style.display = 'none';
        clearErrors();
    }
    
    function scrollToForm() {
        carouselFormContainer.scrollIntoView({ behavior: 'smooth' });
    }
    
    function handleImagePreview(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
    
    async function handleFormSubmit(e) {
        e.preventDefault();
        
        // Validate form
        if (!validateForm()) {
            return;
        }
        
        // Prepare form data
        const formData = new FormData(carouselForm);
        
        // Show loading state
        submitBtn.disabled = true;
        loadingSpinner.style.display = 'inline-block';
        
        try {
            const url = isEditMode ? '/admin/carousel/update' : '/admin/carousel/store';
            const method = 'POST';
            
            const response = await fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (response.ok) {
                // Success
                showNotification(result.message, 'success');
                hideForm();
                loadCarouselImages(); // Reload images
            } else {
                // Show errors
                if (result.errors) {
                    displayErrors(result.errors);
                }
                showNotification(result.message || 'An error occurred', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Network error. Please try again.', 'error');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            loadingSpinner.style.display = 'none';
        }
    }
    
    function validateForm() {
        let isValid = true;
        clearErrors();
        
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const image = document.getElementById('image').files[0];
        
        if (!title) {
            showError('titleError', 'Title is required');
            isValid = false;
        }
        
        if (!description) {
            showError('descriptionError', 'Description is required');
            isValid = false;
        }
        
        if (!image && !isEditMode) {
            showError('imageError', 'Image is required');
            isValid = false;
        }
        
        return isValid;
    }
    
    function clearErrors() {
        const errorElements = document.querySelectorAll('.error');
        errorElements.forEach(element => {
            element.textContent = '';
        });
    }
    
    function showError(elementId, message) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = message;
        }
    }
    
    function displayErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const errorElement = document.getElementById(field + 'Error');
            if (errorElement) {
                errorElement.textContent = messages[0];
            }
        }
    }
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        `;
        
        // Add to body
        document.body.appendChild(notification);
        
        // Add styles if not already present
        if (!document.querySelector('#notification-styles')) {
            const styles = document.createElement('style');
            styles.id = 'notification-styles';
            styles.textContent = `
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 15px 20px;
                    border-radius: 4px;
                    color: white;
                    z-index: 1000;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    min-width: 300px;
                    max-width: 400px;
                    animation: slideIn 0.3s ease;
                }
                .notification.success { background: #28a745; }
                .notification.error { background: #dc3545; }
                .notification.warning { background: #ffc107; color: #333; }
                .notification-close {
                    background: none;
                    border: none;
                    color: inherit;
                    font-size: 20px;
                    cursor: pointer;
                    margin-left: 15px;
                }
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(styles);
        }
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
        
        // Close button
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.remove();
        });
    }
    
    async function loadCarouselImages() {
        try {
            const response = await fetch('/admin/carousel/list', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            console.log('Response status:', response.status);
            console.log('Response content type:', response.headers.get('content-type'));
            
            // Check if response is HTML instead of JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('text/html')) {
                const html = await response.text();
                console.error('Server returned HTML instead of JSON');
                console.error('First 500 chars of HTML:', html.substring(0, 500));
                throw new Error('Server returned HTML. Check if route exists and returns JSON.');
            }
            
            const data = await response.json();
            console.log('Carousel data:', data);
            
            if (response.ok) {
                updateImagesGrid(data);
            } else {
                console.error('Server error:', data);
            }
        } catch (error) {
            console.error('Error loading images:', error);
            showNotification('Failed to load carousel images. Check console for details.', 'error');
        }
    }
    
    function updateImagesGrid(items) {
        const grid = document.getElementById('carouselImagesGrid');
        grid.innerHTML = items.map(item => `
            <div class="image-card" data-id="${item.id}">
                <div class="image-preview">
                    <img src="${item.image_path}" alt="${item.title}">
                    <div class="image-overlay">
                        <button class="btn-edit" onclick="editCarouselItem(${item.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete" onclick="openDeleteModal(${item.id},'${item.title.replace(/'/g, "\\'")}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="image-info">
                    <h4 class="gabarito-regular">${item.title}</h4>
                    <p>${item.description}</p>
                    <small>Order: ${item.order}</small>
                </div>
            </div>
        `).join('');
    }
    
    // Global functions for inline onclick handlers
    window.editCarouselItem = async function(id) {
        try {
            const response = await fetch(`/admin/carousel/edit/${id}`);
            const data = await response.json();
            
            if (response.ok) {
                showEditForm(data);
            } else {
                showNotification(data.message || 'Failed to load data', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Network error', 'error');
        }
    };

    window.openDeleteModal = function (id ,title){
        deleteCarouselId = id;
        const el = document.getElementById('deleteItemTitle');
        el.innerText = title;

        el.classList.remove('fadeInRight');
        void el.offsetWidth;
        el.classList.add('fadeInRight');

        document.getElementById('deleteModal').classList.add('show');
    }
    
    window.closeDeleteModal = function() {
        deleteCarouselId = null;
        document.getElementById('deleteModal').classList.remove('show');
    };
    
    async function confirmDelete() {
        if (!deleteCarouselId) return;
        
        try {
            const response = await fetch(`/admin/carousel/delete/${deleteCarouselId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (response.ok) {
                showNotification(result.message, 'success');
                loadCarouselImages();
            } else {
                showNotification(result.message || 'Failed to delete', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Network error', 'error');
        } finally {
            closeDeleteModal();
        }
    }

    const opacitySlider = document.getElementById('overlay_opacity');
    const opacityVal = document.getElementById('opacityVal');

    opacitySlider.addEventListener('input', function(){
        opacityVal.textContent = this.value;
    });

    document.querySelector(`input[name="show_text"][value="${data.show_text}"]`).checked = true;
    document.getElementById('overlay_opacity').value = data.overlay_opacity;
    opacityVal.textContent = data.overlay_opacity;

    // Initialize
    loadCarouselImages();
});