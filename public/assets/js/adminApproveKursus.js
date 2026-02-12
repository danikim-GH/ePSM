// ============================================
// Admin Approve Kursus - JavaScript
// ============================================

let allKursusData = [];
let currentKursusId = null;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    loadPendingKursus();
    
    // Event listeners for filters
    document.getElementById('filter-month').addEventListener('change', applyFilters);
    document.getElementById('filter-year').addEventListener('change', applyFilters);
    
    // Event listener for search with debounce
    let searchTimeout;
    document.getElementById('search-input').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 500);
    });
    
    // Close modal when clicking overlay
    document.getElementById('course-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Approve button handler
    document.getElementById('approve-btn').addEventListener('click', approveKursus);
});

/**
 * Load all pending kursus from server
 */
function loadPendingKursus() {
    showLoading();
    
    fetch('/admin/kursus/pending', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            allKursusData = data.data;
            updatePendingCount(data.count);
            displayKursusCards(allKursusData);
        } else {
            showToast('Gagal memuatkan data', 'error');
            showEmptyState();
        }
    })
    .catch(error => {
        console.error('Error loading kursus:', error);
        showToast('Ralat semasa memuatkan data', 'error');
        showEmptyState();
    });
}

/**
 * Display kursus cards in grid
 */
function displayKursusCards(kursusArray) {
    const container = document.getElementById('kursus-cards-container');
    const emptyState = document.getElementById('empty-state');
    
    if (!kursusArray || kursusArray.length === 0) {
        container.innerHTML = '';
        emptyState.style.display = 'block';
        return;
    }
    
    emptyState.style.display = 'none';
    
    let cardsHtml = '';
    
    kursusArray.forEach((kursus, index) => {
        cardsHtml += createKursusCard(kursus, index);
    });
    
    container.innerHTML = cardsHtml;
    
    // Add click handlers to cards
    document.querySelectorAll('.course-card').forEach(card => {
        card.addEventListener('click', function() {
            const kursusId = this.dataset.kursusId;
            openModal(kursusId);
        });
    });
}

/**
 * Create HTML for single kursus card
 */
function createKursusCard(kursus, index) {
    const tarikhMula = formatDate(kursus.kursus_thmula);
    const tarikhTamat = kursus.kursus_thtamat ? formatDate(kursus.kursus_thtamat) : '-';
    const tarikhDaftar = formatDatetime(kursus.kursus_daftar);
    
    return `
        <div class="course-card" data-kursus-id="${kursus.kursus_ID}" style="animation-delay: ${index * 0.05}s;">
            <div class="course-card-header">
                <h3 class="course-title gabarito-regular">${kursus.kursus_tajuk || 'Tiada Tajuk'}</h3>
                <div class="course-user">
                    <i class="fas fa-user"></i>
                    <span>${kursus.Nama || 'Tiada Nama'} (${kursus.NoKP || '-'})</span>
                </div>
            </div>
            
            <div class="course-card-body">
                <div class="course-info-grid">
                    <div class="course-info-item">
                        <div class="course-info-label">
                            <i class="fas fa-calendar-alt"></i>
                            Tarikh Mula
                        </div>
                        <div class="course-info-value">${tarikhMula}</div>
                    </div>
                    
                    <div class="course-info-item">
                        <div class="course-info-label">
                            <i class="fas fa-calendar-check"></i>
                            Tarikh Tamat
                        </div>
                        <div class="course-info-value">${tarikhTamat}</div>
                    </div>
                    
                    <div class="course-info-item">
                        <div class="course-info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Tempat
                        </div>
                        <div class="course-info-value">${kursus.kursus_tempat || '-'}</div>
                    </div>
                    
                    <div class="course-info-item">
                        <div class="course-info-label">
                            <i class="fas fa-building"></i>
                            Anjuran
                        </div>
                        <div class="course-info-value ${!kursus.kursus_anjuran ? 'empty' : ''}">${kursus.kursus_anjuran || 'Tiada Maklumat'}</div>
                    </div>
                    
                    <div class="course-info-item course-info-full">
                        <div class="course-info-label">
                            <i class="fas fa-clock"></i>
                            Tempoh
                        </div>
                        <div class="course-info-value">
                            ${kursus.kursus_bilhari || 0} Hari, ${kursus.kursus_biljam || 0} Jam
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="course-card-footer">
                <span class="course-status-badge">
                    <i class="fas fa-hourglass-half"></i>
                    Menunggu Kelulusan
                </span>
                <span class="course-date">
                    <i class="fas fa-clock"></i>
                    ${tarikhDaftar}
                </span>
            </div>
        </div>
    `;
}

/**
 * Open modal with course details
 */
function openModal(kursusId) {
    currentKursusId = kursusId;
    
    fetch(`/admin/kursus/details/${kursusId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateModal(data.data);
            document.getElementById('course-modal').classList.add('active');
            document.body.style.overflow = 'hidden';
        } else {
            showToast('Gagal memuatkan butiran kursus', 'error');
        }
    })
    .catch(error => {
        console.error('Error loading details:', error);
        showToast('Ralat semasa memuatkan butiran', 'error');
    });
}

/**
 * Populate modal with course details
 */
function populateModal(kursus) {
    const modalContent = document.getElementById('modal-content');
    
    const sijilHtml = kursus.kursus_sijil == 1 ? `
        <div class="sijil-info">
            <i class="fas fa-certificate"></i>
            <div>
                <strong>Sijil Dimuat Naik</strong><br>
                <small>Tarikh: ${formatDatetime(kursus.kursus_tarikhsijil)}</small><br>
                <small>Fail: ${kursus.kursus_sijil_file || '-'}</small>
            </div>
        </div>
    ` : `
        <div class="sijil-no">
            <i class="fas fa-times-circle"></i>
            <div>
                <strong>Tiada Sijil</strong><br>
                <small>Sijil tidak dimuat naik</small>
            </div>
        </div>
    `;
    
    modalContent.innerHTML = `
        <!-- Maklumat Kursus -->
        <div class="modal-info-section">
            <h3 class="modal-section-title gabarito-regular">
                Maklumat Kursus
            </h3>
            <div class="modal-info-grid">
                <div class="modal-info-item modal-info-full">
                    <div class="modal-info-label">Tajuk Kursus</div>
                    <div class="modal-info-value">${kursus.kursus_tajuk || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">ID Program</div>
                    <div class="modal-info-value">${kursus.kursus_idprogram || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">ID Aktiviti</div>
                    <div class="modal-info-value">${kursus.kursus_idaktiviti || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Tarikh Mula</div>
                    <div class="modal-info-value">${formatDate(kursus.kursus_thmula)}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Tarikh Tamat</div>
                    <div class="modal-info-value">${kursus.kursus_thtamat ? formatDate(kursus.kursus_thtamat) : '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Masa Mula</div>
                    <div class="modal-info-value ${!kursus.kursus_msmula ? 'empty' : ''}">${kursus.kursus_msmula || 'Tiada Maklumat'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Masa Akhir</div>
                    <div class="modal-info-value ${!kursus.kursus_msakhir ? 'empty' : ''}">${kursus.kursus_msakhir || 'Tiada Maklumat'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Bilangan Hari</div>
                    <div class="modal-info-value">${kursus.kursus_bilhari || 0} Hari</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Bilangan Jam</div>
                    <div class="modal-info-value">${kursus.kursus_biljam || 0} Jam</div>
                </div>
            </div>
        </div>
        
        <!-- Lokasi & Anjuran -->
        <div class="modal-info-section">
            <h3 class="modal-section-title gabarito-regular">
                Lokasi & Anjuran
            </h3>
            <div class="modal-info-grid">
                <div class="modal-info-item modal-info-full">
                    <div class="modal-info-label">Tempat</div>
                    <div class="modal-info-value">${kursus.kursus_tempat || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Jenis Tempat</div>
                    <div class="modal-info-value ${!kursus.kursus_jenistempat ? 'empty' : ''}">${kursus.kursus_jenistempat || 'Tiada Maklumat'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Negeri</div>
                    <div class="modal-info-value ${!kursus.kursus_namanegeri ? 'empty' : ''}">${kursus.kursus_namanegeri || 'Tiada Maklumat'}</div>
                </div>
                
                <div class="modal-info-item modal-info-full">
                    <div class="modal-info-label">Anjuran</div>
                    <div class="modal-info-value ${!kursus.kursus_anjuran ? 'empty' : ''}">${kursus.kursus_anjuran || 'Tiada Maklumat'}</div>
                </div>
            </div>
        </div>
        
        <!-- Maklumat Peserta -->
        <div class="modal-info-section">
            <h3 class="modal-section-title gabarito-regular">
                Maklumat Peserta
            </h3>
            <div class="modal-info-grid">
                <div class="modal-info-item">
                    <div class="modal-info-label">Nama</div>
                    <div class="modal-info-value">${kursus.Nama || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">No. KP</div>
                    <div class="modal-info-value">${kursus.NoKP || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Gred</div>
                    <div class="modal-info-value">${kursus.Gred || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Jawatan</div>
                    <div class="modal-info-value">${kursus.Jawatan || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Jabatan</div>
                    <div class="modal-info-value">${kursus.NamaJabatan || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Unit</div>
                    <div class="modal-info-value ${!kursus.Unit ? 'empty' : ''}">${kursus.Unit || 'Tiada Maklumat'}</div>
                </div>
            </div>
        </div>
        
        <!-- Maklumat Tambahan -->
        <div class="modal-info-section">
            <h3 class="modal-section-title gabarito-regular">
                Maklumat Tambahan
            </h3>
            <div class="modal-info-grid">
                <div class="modal-info-item">
                    <div class="modal-info-label">No. Rujukan</div>
                    <div class="modal-info-value ${!kursus.kursus_rujukan ? 'empty' : ''}">${kursus.kursus_rujukan || 'Tiada Maklumat'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Tahun</div>
                    <div class="modal-info-value">${kursus.kursus_tahun || '-'}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Bulan</div>
                    <div class="modal-info-value">${getMonthName(kursus.kursus_bulan)}</div>
                </div>
                
                <div class="modal-info-item">
                    <div class="modal-info-label">Tarikh Pendaftaran</div>
                    <div class="modal-info-value">${formatDatetime(kursus.kursus_daftar)}</div>
                </div>
                
                <div class="modal-info-item modal-info-full">
                    <div class="modal-info-label">Status Sijil</div>
                    ${sijilHtml}
                </div>
            </div>
        </div>
    `;
}

/**
 * Close modal
 */
function closeCourseModal() {
    document.getElementById('course-modal').classList.remove('active');
    document.body.style.overflow = 'auto';
    currentKursusId = null;
}

/**
 * Approve kursus
 */
function approveKursus() {
    if (!currentKursusId) {
        showToast('Ralat: Tiada kursus yang dipilih', 'error');
        return;
    }
    
    if (!confirm('Adakah anda pasti ingin mengesahkan kursus ini?')) {
        return;
    }
    
    const approveBtn = document.getElementById('approve-btn');
    const originalText = approveBtn.innerHTML;
    approveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    approveBtn.disabled = true;
    
    fetch(`/admin/kursus/approve/${currentKursusId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'approve');
            closeModal();
            loadPendingKursus(); // Reload the list
        } else {
            showToast(data.message || 'Gagal mengesahkan kursus', 'error');
        }
    })
    .catch(error => {
        console.error('Error approving kursus:', error);
        showToast('Ralat semasa mengesahkan kursus', 'error');
    })
    .finally(() => {
        approveBtn.innerHTML = originalText;
        approveBtn.disabled = false;
    });
}

/**
 * Apply filters and search
 */
function applyFilters() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const filterMonth = document.getElementById('filter-month').value;
    const filterYear = document.getElementById('filter-year').value;
    
    let filteredData = [...allKursusData];
    
    // Apply search filter
    if (searchTerm) {
        filteredData = filteredData.filter(kursus => {
            return (
                (kursus.kursus_tajuk && kursus.kursus_tajuk.toLowerCase().includes(searchTerm)) ||
                (kursus.Nama && kursus.Nama.toLowerCase().includes(searchTerm)) ||
                (kursus.NoKP && kursus.NoKP.toLowerCase().includes(searchTerm)) ||
                (kursus.kursus_tempat && kursus.kursus_tempat.toLowerCase().includes(searchTerm))
            );
        });
    }
    
    // Apply month filter
    if (filterMonth) {
        filteredData = filteredData.filter(kursus => kursus.kursus_bulan == filterMonth);
    }
    
    // Apply year filter
    if (filterYear) {
        filteredData = filteredData.filter(kursus => kursus.kursus_tahun == filterYear);
    }
    
    displayKursusCards(filteredData);
}

/**
 * Update pending count
 */
function updatePendingCount(count) {
    document.getElementById('pending-count').textContent = count;
}

/**
 * Show loading state
 */
function showLoading() {
    const container = document.getElementById('kursus-cards-container');
    container.innerHTML = `
        <div class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Memuatkan data...</p>
        </div>
    `;
}

/**
 * Show empty state
 */
function showEmptyState() {
    document.getElementById('kursus-cards-container').innerHTML = '';
    document.getElementById('empty-state').style.display = 'block';
}

/**
 * Format date (YYYY-MM-DD to DD/MM/YYYY)
 */
function formatDate(dateString) {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    
    return `${day}/${month}/${year}`;
}

/**
 * Format datetime (YYYY-MM-DD HH:MM:SS to DD/MM/YYYY HH:MM)
 */
function formatDatetime(datetimeString) {
    if (!datetimeString) return '-';
    
    const date = new Date(datetimeString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

/**
 * Get month name from number
 */
function getMonthName(monthNumber) {
    const months = [
        'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun',
        'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'
    ];
    
    return months[monthNumber - 1] || '-';
}

/**
 * Show toast notification
 */
function showToast(message, type = 'success') {
    // Remove existing toasts
    document.querySelectorAll('.toast').forEach(toast => toast.remove());
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}