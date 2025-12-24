function suspendedCount(){
    fetch('/admin/suspended-count')
        .then(response => response.json())
        .then(data => {
            const value =  data.total_suspended;

            const byId = document.getElementById('suspendedCount'); 

            if(byId) byId.textContent = value;
            document.querySelectorAll('.js-suspended-count').forEach(el =>el.textContent = value);
        })
        .catch(error => {
            console.error('Error fetching suspended count:', error);
        })
}

function pendingUsersCount(){
    fetch('/admin/pending-users-count')
        .then(response => response.json())
        .then(data =>{
            const value = data.pending_users_count;

            const byId = document.getElementById('pendingUserCount');
            if(byId) byId.textContent = value;

            document.querySelectorAll('.js-pending-count').forEach(el => el.textContent = value);//call up using class, not id, for multi uses purpose, id cannot be duplicate.
        })
        .catch(error => {
            console.error('Error fetching pending users count:', error);
        });
}

// User Card Interactions
document.addEventListener('DOMContentLoaded', pendingUsersCount(),suspendedCount(),function() {
    // Initialize sidebar state
    updateSidebarState();

    
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