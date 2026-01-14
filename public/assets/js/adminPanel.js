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
        });
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


function initServerSideSearch() {
    document.querySelectorAll('.search-input').forEach(input => {
    
        const clearBtn = input.parentElement.querySelector('.clear-search');
        let debounce;
    
        input.addEventListener('input', () => {

            const keyword = input.value.trim();
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                
                // toggle clear button
                if (clearBtn) {
                    clearBtn.classList.toggle('d-none', keyword === '');
                }
    
                //  SERVER SIDE FETCH
                if (input.dataset.mode === 'pending' && window.pendingList) {
                    window.pendingList.fetch(1, { search: keyword });
                }
    
                if (input.dataset.mode === 'suspended' && window.suspendList) {
                    window.suspendList.fetch(1, { search: keyword });
                }
            }, 300);
        });
    
        if(clearBtn){
            clearBtn.addEventListener('click', () => {
                input.value = '';
                input.dispatchEvent(new Event('input'));
                input.focus();
            });
        }
    });
}



function handleEmptyState(rows, visibleCount) {
    if (!rows.length === 0) return;
    
    const tbody = rows[0].closest('tbody');
    if(!tbody) return;
    let emptyStateRow = tbody.querySelector('.empty-search-row');

    if(visibleCount === 0) {
        if(!emptyStateRow) {
            emptyStateRow = document.createElement('tr');
            emptyStateRow.className = 'empty-search-row';
            emptyStateRow.innnerHTML = `
                <td colspan="100%" class="text-center text-muted py-4">
                    <i class="fas fa-search-minus mb-2"></i><br>
                    Tiada data dijumpai
                </td>
            `;

            tbody.appendChild(emptyStateRow);
        }
    } else {
        if(emptyStateRow) {
            emptyStateRow.remove();
        }
    }

}