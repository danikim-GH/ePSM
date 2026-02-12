/**
 * Dynamic Menu Loader for menutepi items
 * Loads menu based on user level from database
 */

// Icon mapping for menu items based on menu_tajuk
const menuIcons = {
    'Daftar Kehadiran Kursus': 'fas fa-edit',
    'Senarai Kursus': 'fas fa-list',
    'Penilaian TNA': 'bi bi-clipboard-check',
    'Cadangan Kursus': 'bi bi-lightbulb',
    'TRM/Profail Kompetensi': 'bi bi-person-badge',
    'Rekod Pengesahan Kehadiran': 'bi bi-check-circle',
    'Laporan Kehadiran Kakitangan': 'bi bi-file-earmark-text',
    'Statistik Kehadiran': 'bi bi-graph-up',
    'Mesej Pengguna': 'bi bi-chat-square-text',
    'Daftar Kursus BSM': 'bi bi-calendar-plus',
    'Senarai Kursus BSM': 'bi bi-list-check',
    'Senarai Permohonan Kursus': 'fa fa-list-alt',
    'Laporan Penilaian Keberkesanan Kursus': 'bi bi-person-lines-fill',
    'Mesej Admin': 'bi bi-chat-square-text',
    'Undian': 'bi bi-file-excel-fill',
    'Arkib': 'bi bi-archive-fill',
    'Perkhidmatan': 'bi bi-cup-hot-fill',
    'Penilaian Kursus': 'bi bi-clipboard-data',
    'Kew8': 'bi bi-receipt',
    'Kenaikan Pangkat': 'bi bi-chevron-double-up',
    'iRawat': 'bi bi-heart-pulse-fill',
    'Pertukaran': 'bi bi-arrow-repeat',
    'Program Pembelajaran Sepanjang Hayat': 'bi bi-book-half',
    'Tawaran Kursus': 'bi bi-person-workspace',
    'Sistem UPPK': 'bi bi-building',
    'Sijil PTM': 'bi bi-award'
};

// Default icon if not found in mapping
const defaultIcon = 'bi bi-card-list';

/**
 * Get icon for menu item
 */
function getMenuIcon(menuTitle) {
    return menuIcons[menuTitle] || defaultIcon;
}

/**
 * Create menu card HTML
 */
function createMenuCard(menuItem, delay) {
    const icon = getMenuIcon(menuItem.menu_tajuk);
    const url = menuItem.menu_url && menuItem.menu_url !== '-' 
        ? menuItem.menu_url 
        : '#';

    document.addEventListener('click', function (e) {
        const card = e.target.closest('.feature-card');
        if (!card) return;

        const url = card.dataset.url;
        const title = card.dataset.title;

        // Kalau coming soon
        if (url === '#') {
            e.preventDefault();
            showToast(`${title} akan datang `);
        }
    });

    // Kalau coming soon
    if (url === '#') {
        return `
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" 
            data-wow-delay="${delay}s" 
            style="visibility: visible; animation-delay: ${delay}s; animation-name: fadeInUp;">
            <a href="#" class="text-decoration-none feature-card" data-url="#" data-title="${menuItem.menu_tajuk}">
                <div class="feature-item p-4 text-center d-flex flex-column justify-content-between" 
                    style="cursor:default;">
                    <div class="feature-item-container">
                        <div class="feature-icon disable mb-3 mx-auto">
                            <i class="${icon} text-white fa-3x"></i>
                        </div>
                        <h5 class="mb-3 pt-sans-bold text-muted">${menuItem.menu_tajuk}</h5>
                        <p class="mb-0 feature-menu-text">Klik untuk akses ${menuItem.menu_tajuk.toLowerCase()}</p>
                    </div>
                </div>
            </a>
        </div>
    `;
    }

    //**
    const isModal = menuItem.menu_action === 'modal';
    const linkAttribute = isModal 
        ? `data-bs-toggle="modal" data-bs-target="#${menuItem.menu_target}"` 
        : `href="${url}"`;

    return `
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" 
            data-wow-delay="${delay}s" 
            style="visibility: visible; animation-delay: ${delay}s; animation-name: fadeInUp;">
            <a ${linkAttribute} class="text-decoration-none feature-card" data-url="${url}" data-title="${menuItem.menu_tajuk}">
                <div class="feature-item p-4 text-center d-flex flex-column justify-content-between" 
                    style="cursor:pointer;">
                    <div class="feature-item-container">
                        <div class="feature-icon mb-3 mx-auto">
                            <i class="${icon} text-white fa-3x"></i>
                        </div>
                        <h5 class="mb-3 pt-sans-bold">${menuItem.menu_tajuk}</h5>
                        <p class="mb-0 feature-menu-text">Klik untuk akses ${menuItem.menu_tajuk.toLowerCase()}</p>
                    </div>
                </div>
            </a>
        </div>
    `;
}

/**
 * Load dynamic menu from server
 */
async function loadDynamicMenu() {
    const container = document.getElementById('dynamicMenuContainer');
    const spinner = document.getElementById('menuLoadingSpinner');
    
    try {
        // Show loading spinner
        if (spinner) {
            spinner.style.display = 'block';
        }
        
        // Fetch menu data from server
        const response = await fetch('/api/menu/side-menu', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        // Hide spinner
        if (spinner) {
            spinner.style.display = 'none';
        }
        
        if (data.success && data.data && data.data.length > 0) {
            // Clear container
            container.innerHTML = '';
            
            // Create menu cards with staggered animation delays
            let menuHTML = '';
            data.data.forEach((item, index) => {
                const delay = 0.1 + (index * 0.03); // Stagger animations
                menuHTML += createMenuCard(item, delay);
            });
            
            // Insert all cards at once
            container.innerHTML = menuHTML;
            
            // Re-initialize WOW.js for new elements
            if (typeof WOW !== 'undefined') {
                new WOW().init();
            }
            
            //console.log(`Loaded ${data.data.length} menu items for user level: ${data.user_level}`);
        } else {
            // No menu items found
            container.innerHTML = `
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Tiada menu tersedia untuk tahap pengguna anda.
                    </div>
                </div>
            `;
            console.warn(' No menu items returned from server');
        }
        
    } catch (error) {
        console.error('Error loading menu:', error);
        
        // Hide spinner
        if (spinner) {
            spinner.style.display = 'none';
        }
        
        // Show error message
        container.innerHTML = `
            <div class="col-12 text-center">
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Ralat memuatkan menu. Sila cuba sebentar lagi.
                </div>
            </div>
        `;
    }
}

/**
 * Initialize menu on page load
 */
document.addEventListener('DOMContentLoaded', function() {
    //console.log('Initializing dynamic menu...');
    loadDynamicMenu();
});

/**
 * Optional: Reload menu function (can be called externally)
 */
function reloadMenu() {
    //console.log(' Reloading menu...');
    loadDynamicMenu();
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = `toast-sidemenu toast-coming-soon`;
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 50);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}


// Export for external use
window.reloadMenu = reloadMenu;