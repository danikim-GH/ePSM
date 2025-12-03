// Sidebar Toggle Functionality
const sidebar = document.getElementById("adminSidebar");
const toggle = document.getElementById("sidebarToggle");
const mobileToggle = document.getElementById("mobileMenuToggle");
const overlay = document.createElement('div');
overlay.className = 'sidebar-overlay';

// Add overlay to body
document.body.appendChild(overlay);

// Function to check if mobile
function isMobile() {
    return window.innerWidth <= 768;
}

// Function to update sidebar state
function updateSidebarState() {
    if (isMobile()) {
        sidebar.classList.remove('collapsed');
        sidebar.style.transform = 'translateX(-100%)';
    } else {
        sidebar.style.transform = '';
    }
}

// Toggle sidebar function
function toggleSidebar() {
    if (isMobile()) {
        sidebar.classList.toggle("mobile-open");
        overlay.classList.toggle("active");
        document.body.style.overflow = sidebar.classList.contains("mobile-open") ? 'hidden' : '';
    } else {
        sidebar.classList.toggle("collapsed");
    }
}

// Event Listeners
if (toggle) {
    toggle.addEventListener("click", toggleSidebar);
}

if (mobileToggle) {
    mobileToggle.addEventListener("click", toggleSidebar);
}

// Close sidebar when clicking overlay
overlay.addEventListener('click', () => {
    sidebar.classList.remove("mobile-open");
    overlay.classList.remove("active");
    document.body.style.overflow = '';
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', (e) => {
    if (isMobile() && 
        sidebar.classList.contains('mobile-open') && 
        !sidebar.contains(e.target) && 
        e.target !== mobileToggle && 
        !mobileToggle.contains(e.target)) {
        sidebar.classList.remove("mobile-open");
        overlay.classList.remove("active");
        document.body.style.overflow = '';
    }
});

// Handle window resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        updateSidebarState();
        if (!isMobile() && sidebar.classList.contains('mobile-open')) {
            sidebar.classList.remove("mobile-open");
            overlay.classList.remove("active");
            document.body.style.overflow = '';
        }
    }, 250);
});

// User Card Interactions
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar state
    updateSidebarState();
    
    // Card hover effects - only on desktop
    const userCards = document.querySelectorAll('.user-card');
    
    userCards.forEach(card => {
        // Store original background
        const originalBg = window.getComputedStyle(card).backgroundColor;
        
        card.addEventListener('mouseenter', function(e) {
            if (!isMobile()) {
                this.style.transform = 'translateY(-8px)';
                this.style.zIndex = '10';
                
                // Apply gradient background
                this.style.background = 'linear-gradient(180deg, #001442, #001a57)';
                
                // Update text colors
                const textElements = this.querySelectorAll('.info-value, .form-label, .info-group label, .date-badge');
                textElements.forEach(el => {
                    el.style.color = '#ffffff';
                });
                
                // Update select
                const select = this.querySelector('.level-select');
                if (select) {
                    select.style.background = 'rgba(255, 255, 255, 0.1)';
                    select.style.borderColor = 'rgba(255, 255, 255, 0.3)';
                    select.style.color = '#ffffff';
                }
                
                // Update actions background
                const actions = this.querySelector('.user-actions');
                if (actions) {
                    actions.style.background = 'rgba(255, 255, 255, 0.05)';
                }
            }
        });
        
        card.addEventListener('mouseleave', function(e) {
            if (!isMobile()) {
                this.style.transform = 'translateY(0)';
                this.style.zIndex = '1';
                this.style.background = originalBg;
                
                // Reset text colors
                const textElements = this.querySelectorAll('.info-value, .form-label, .info-group label, .date-badge');
                textElements.forEach(el => {
                    el.style.color = '';
                });
                
                // Reset select
                const select = this.querySelector('.level-select');
                if (select) {
                    select.style.background = '';
                    select.style.borderColor = '';
                    select.style.color = '';
                }
                
                // Reset actions background
                const actions = this.querySelector('.user-actions');
                if (actions) {
                    actions.style.background = '';
                }
            }
        });
        
        // Handle select changes
        const select = card.querySelector('.level-select');
        if(select) {
            // Set default value to empty to force selection
            select.value = '';
            
            select.addEventListener('change', function() {
                if (this.value !== '') {
                    this.classList.add('changed');
                    
                    // Visual feedback
                    const checkIcon = document.createElement('i');
                    checkIcon.className = 'fas fa-check select-check';
                    checkIcon.style.marginLeft = '8px';
                    checkIcon.style.color = '#2ed573';
                    
                    // Remove existing check if any
                    const existingCheck = this.parentNode.querySelector('.select-check');
                    if (existingCheck) {
                        existingCheck.remove();
                    }
                    
                    this.parentNode.appendChild(checkIcon);
                    
                    // Remove check after 2 seconds
                    setTimeout(() => {
                        checkIcon.style.opacity = '0';
                        checkIcon.style.transition = 'opacity 0.3s';
                        setTimeout(() => checkIcon.remove(), 300);
                    }, 2000);
                } else {
                    this.classList.remove('changed');
                }
            });
        }
        
        // View details button
        const viewBtn = card.querySelector('.btn-view-details');
        if (viewBtn) {
            viewBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                alert(`View details for user ID: ${userId}\n(This would open a modal in production)`);
            });
        }
        
        // Form validation
        const form = card.querySelector('.action-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const select = this.querySelector('.level-select');
                if (!select.value) {
                    e.preventDefault();
                    select.style.borderColor = '#ff4757';
                    select.style.boxShadow = '0 0 0 3px rgba(255, 71, 87, 0.15)';
                    
                    // Show error message
                    let errorMsg = select.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message';
                        errorMsg.style.color = '#ff4757';
                        errorMsg.style.fontSize = '12px';
                        errorMsg.style.marginTop = '5px';
                        errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> Please select a user level';
                        select.parentNode.appendChild(errorMsg);
                    }
                    
                    // Remove error after 3 seconds
                    setTimeout(() => {
                        select.style.borderColor = '';
                        select.style.boxShadow = '';
                        if (errorMsg) errorMsg.remove();
                    }, 3000);
                    
                    return false;
                }
            });
        }
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = this.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.user-card');
                
                cards.forEach(card => {
                    const userInfo = card.querySelector('.user-info');
                    if (userInfo) {
                        const text = userInfo.textContent.toLowerCase();
                        if (text.includes(searchTerm) || searchTerm === '') {
                            card.style.display = 'block';
                            card.style.animation = 'fadeInUp 0.3s';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            }, 300);
        });
    }
    
    // Filter functionality
    const filterSelect = document.querySelector('.filter-select');
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            const filterValue = this.value;
            const cards = document.querySelectorAll('.user-card');
            
            cards.forEach(card => {
                // In a real app, you would filter based on actual data
                // For now, just show all cards
                card.style.display = 'block';
                card.style.animation = 'fadeInUp 0.3s';
            });
            
            console.log(`Filtering by: ${filterValue}`);
        });
    }
    
    // Refresh button
    const refreshBtn = document.querySelector('.btn-refresh');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
            this.disabled = true;
            
            // Simulate refresh
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        });
    }
    
    // Mobile bottom nav active state
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (isMobile()) {
                e.preventDefault();
                navItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                window.location.href = this.href;
            }
        });
    });
    
    // Touch gestures for mobile sidebar
    let touchStartX = 0;
    let touchEndX = 0;
    let touchStartY = 0;
    let touchEndY = 0;
    
    document.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    });
    
    document.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    });
    
    function handleSwipe() {
        if (!isMobile()) return;
        
        const swipeThreshold = 50;
        const verticalSwipe = Math.abs(touchEndY - touchStartY);
        const horizontalSwipe = Math.abs(touchEndX - touchStartX);
        
        // Only handle horizontal swipes that are more horizontal than vertical
        if (horizontalSwipe > verticalSwipe && horizontalSwipe > swipeThreshold) {
            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left - close sidebar if open
                if (sidebar.classList.contains('mobile-open')) {
                    sidebar.classList.remove("mobile-open");
                    overlay.classList.remove("active");
                    document.body.style.overflow = '';
                }
            }
            
            if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right - open sidebar if closed
                if (!sidebar.classList.contains('mobile-open')) {
                    sidebar.classList.add("mobile-open");
                    overlay.classList.add("active");
                    document.body.style.overflow = 'hidden';
                }
            }
        }
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Ctrl/Cmd + B to toggle sidebar
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        toggleSidebar();
    }
    
    // Escape to close mobile sidebar
    if (e.key === 'Escape' && isMobile() && sidebar.classList.contains('mobile-open')) {
        sidebar.classList.remove("mobile-open");
        overlay.classList.remove("active");
        document.body.style.overflow = '';
    }
});

// Initialize tooltips for sidebar
function initSidebarTooltips() {
    if (!isMobile() && sidebar.classList.contains('collapsed')) {
        const menuItems = sidebar.querySelectorAll('.sidebar-menu li a');
        
        menuItems.forEach(item => {
            const title = item.getAttribute('title') || item.querySelector('.menu-text')?.textContent;
            if (title) {
                item.setAttribute('title', title);
            }
        });
    }
}

// Initialize on load
window.addEventListener('load', initSidebarTooltips);