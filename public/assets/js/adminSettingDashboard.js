// assets/js/adminSettingDashboard.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Settings Dashboard loaded');
});

// Open feature function
function openFeature(featureName) {
    console.log('Opening feature:', featureName);
    
    // Hide settings dashboard
    const settingsDashboard = document.querySelector('.settings-dashboard');
    const featureContainer = document.getElementById('carouselFeatureContainer');
    
    if (featureName === 'carousel') {
        // Redirect to carousel settings page
        window.location.href = '/admin-panel/settings/carousel';
    } else if (featureName === 'gallery') {
        showNotification('Gallery settings coming soon!', 'warning');
    } else if (featureName === 'site') {
        showNotification('Site settings coming soon!', 'warning');
    } else if (featureName === 'menu') {
        showNotification('Menu settings coming soon!', 'warning');
    } else if (featureName === 'seo') {
        showNotification('SEO settings coming soon!', 'warning');
    } else if (featureName === 'email') {
        showNotification('Email settings coming soon!', 'warning');
    }
}

// Close feature function
function closeFeature() {
    const settingsDashboard = document.querySelector('.settings-dashboard');
    const featureContainer = document.getElementById('carouselFeatureContainer');
    
    featureContainer.style.display = 'none';
    settingsDashboard.style.display = 'block';
}

// Notification function (reusable)
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