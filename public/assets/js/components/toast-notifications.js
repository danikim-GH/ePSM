/**
 * Toast Notification System
 * Simple, elegant toast notifications for success, error, warning, and info messages
 */

const Toast = {
    /**
     * Show a toast notification
     * @param {string} type - Type of toast: 'success', 'error', 'warning', 'info'
     * @param {string} message - Message to display
     * @param {number} duration - Duration in milliseconds (default: 3000)
     */
    show(type, message, duration = 3000) {
        // Create toast container if it doesn't exist
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        // Get icon based on type
        const icon = this.getIcon(type);
        
        // Set toast content
        toast.innerHTML = `
            <div class="toast-icon">${icon}</div>
            <div class="toast-content">
                <div class="toast-title">${this.getTitle(type)}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Add toast to container
        container.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Auto remove toast
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
                
                // Remove container if empty
                if (container.children.length === 0) {
                    container.remove();
                }
            }, 300);
        }, duration);
    },

    /**
     * Get icon HTML based on type
     */
    getIcon(type) {
        const icons = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-times-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };
        return icons[type] || icons.info;
    },

    /**
     * Get title based on type
     */
    getTitle(type) {
        const titles = {
            success: 'Berjaya!',
            error: 'Ralat!',
            warning: 'Amaran!',
            info: 'Maklumat'
        };
        return titles[type] || titles.info;
    },

    // Shorthand methods
    success(message, duration) {
        this.show('success', message, duration);
    },

    error(message, duration) {
        this.show('error', message, duration);
    },

    warning(message, duration) {
        this.show('warning', message, duration);
    },

    info(message, duration) {
        this.show('info', message, duration);
    }
};

// Make Toast available globally
window.Toast = Toast;