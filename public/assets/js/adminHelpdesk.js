// Admin Helpdesk Gmail-like Interface
document.addEventListener('DOMContentLoaded', function () {
    let currentFilter = 'all';
    let allTickets = [];
    let selectedTickets = [];

    // Initialize
    init();

    function init() {
        setupEventListeners();
        loadHelpdesk();
    }

    function setupEventListeners() {
        // Tab filters
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.status;
                filterTickets();
            });
        });

        // Search
        const searchInput = document.getElementById('search-helpdesk');
        if (searchInput) {
            searchInput.addEventListener('input', debounce(function () {
                filterTickets();
            }, 300));
        }

        // Select all checkbox
        const selectAllCheckbox = document.getElementById('select-all');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.helpdesk-item-checkbox input');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateSelectedTickets();
            });
        }

        // Refresh button
        const refreshBtn = document.getElementById('refresh-btn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function () {
                this.querySelector('i').classList.add('fa-spin');
                loadHelpdesk();
                setTimeout(() => {
                    this.querySelector('i').classList.remove('fa-spin');
                }, 1000);
            });
        }
    }

    function loadHelpdesk() {
        const listContainer = document.getElementById('helpdesk-list');
        listContainer.innerHTML = `
            <div class="loading-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Memuatkan aduan...</p>
            </div>
        `;

        // Updated URL to match route
        fetch('/admin-panel/helpdesk/tickets')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allTickets = data.data;
                    updateCounts(data.counts);
                    renderTickets(allTickets);
                }
            })
            .catch(error => {
                console.error('Error loading helpdesk:', error);
                listContainer.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Ralat memuatkan data</p>
                    </div>
                `;
            });
    }

    function filterTickets() {
        const searchTerm = document.getElementById('search-helpdesk').value.toLowerCase();
        
        let filtered = allTickets;

        // Filter by status
        if (currentFilter !== 'all') {
            filtered = filtered.filter(ticket => ticket.status === currentFilter);
        }

        // Filter by search
        if (searchTerm) {
            filtered = filtered.filter(ticket => {
                return (
                    ticket.helpdesk_user_name.toLowerCase().includes(searchTerm) ||
                    ticket.helpdesk_subjek_aduan.toLowerCase().includes(searchTerm) ||
                    ticket.helpdesk_butiran_aduan.toLowerCase().includes(searchTerm) ||
                    ticket.helpdesk_user_email.toLowerCase().includes(searchTerm)
                );
            });
        }

        renderTickets(filtered);
    }

    function renderTickets(tickets) {
        const listContainer = document.getElementById('helpdesk-list');

        if (tickets.length === 0) {
            listContainer.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Tiada aduan dijumpai</p>
                </div>
            `;
            return;
        }

        listContainer.innerHTML = tickets.map(ticket => createTicketHTML(ticket)).join('');

        // Add click listeners
        document.querySelectorAll('.helpdesk-item').forEach(item => {
            item.addEventListener('click', function (e) {
                if (!e.target.closest('.checkbox-container')) {
                    const ticketId = this.dataset.id;
                    loadTicketDetail(ticketId);
                    
                    // Update active state
                    document.querySelectorAll('.helpdesk-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                }
            });

            // Checkbox listener
            const checkbox = item.querySelector('.helpdesk-item-checkbox input');
            if (checkbox) {
                checkbox.addEventListener('change', updateSelectedTickets);
            }
        });
    }

    function createTicketHTML(ticket) {
        const date = formatDate(ticket.created_at);
        const preview = ticket.helpdesk_butiran_aduan.substring(0, 80) + '...';
        const statusClass = ticket.status || 'pending';
        const statusText = statusClass === 'resolved' ? 'Selesai' : 'Pending';

        return `
            <div class="helpdesk-item" data-id="${ticket.id}">
                <label class="checkbox-container helpdesk-item-checkbox">
                    <input type="checkbox" value="${ticket.id}">
                    <span class="checkmark"></span>
                </label>
                <div class="helpdesk-item-content">
                    <div class="helpdesk-item-header">
                        <span class="helpdesk-item-name">${ticket.helpdesk_user_name}</span>
                        <span class="helpdesk-item-date">${date}</span>
                    </div>
                    <div class="helpdesk-item-subject">${ticket.helpdesk_subjek_aduan}</div>
                    <div class="helpdesk-item-preview">${preview}</div>
                    <div class="helpdesk-item-meta">
                        <span class="helpdesk-badge ${statusClass}">${statusText}</span>
                        <span class="helpdesk-badge" style="background: #e3f2fd; color: #1976d2;">${ticket.helpdesk_kategori}</span>
                    </div>
                </div>
            </div>
        `;
    }

    function loadTicketDetail(ticketId) {
        const detailContainer = document.getElementById('helpdesk-detail');
        
        detailContainer.innerHTML = `
            <div class="loading-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Memuatkan butiran...</p>
            </div>
        `;

        // Updated URL to match route
        fetch(`/admin-panel/helpdesk/tickets/${ticketId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderTicketDetail(data.data);
                }
            })
            .catch(error => {
                console.error('Error loading ticket detail:', error);
            });
    }

    function renderTicketDetail(ticket) {
        const detailContainer = document.getElementById('helpdesk-detail');
        const statusClass = ticket.status || 'pending';
        const statusText = statusClass === 'resolved' ? 'Selesai' : 'Pending';
        const date = formatDateTime(ticket.created_at);

        detailContainer.innerHTML = `
            <div class="detail-header">

                <div class="detail-header-top">
                    <h2 class="detail-subject gabarito-bold">
                        ${ticket.helpdesk_subjek_aduan}
                    </h2>

                    <div class="detail-header-actions">
                            <button class="detail-btn primary" onclick="updateTicketStatus(${ticket.id}, '${statusClass === 'resolved' ? 'pending' : 'resolved'}')">
                                <i class="fas fa-${statusClass === 'resolved' ? 'undo' : 'check'}"></i>
                            ${statusClass === 'resolved' ? 'Tandakan Pending' : 'Tandakan Selesai'}
                        </button>
                    </div>
                </div>

                
                <div class="detail-meta">
                    <div class="detail-meta-item">
                        <i class="fas fa-user"></i>
                        <span>${ticket.helpdesk_user_name}</span>
                    </div>
                    <div class="detail-meta-item">
                        <i class="fas fa-envelope"></i>
                        <span>${ticket.helpdesk_user_email}</span>
                    </div>
                    <div class="detail-meta-item">
                        <i class="fas fa-phone"></i>
                        <span>${ticket.helpdesk_user_phone || 'Tiada'}</span>
                    </div>
                    <div class="detail-meta-item">
                        <i class="fas fa-clock"></i>
                        <span>${date}</span>
                    </div>
                </div>
                <div class="detail-actions">

                </div>
            </div>
            <div class="detail-body">
                <div class="detail-message-wrapper">
                    <div class="detail-message">
                        ${ticket.helpdesk_butiran_aduan}
                    </div>
                </div>
                <div class="detail-info-grid">
                    <div class="detail-info-item">
                        <span class="detail-info-label">Kategori</span>
                        <span class="detail-info-value">${ticket.helpdesk_kategori}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Jabatan</span>
                        <span class="detail-info-value">${ticket.NamaJabatan || 'Tiada'}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Status</span>
                        <span class="helpdesk-badge status-details ${statusClass}">${statusText}</span>
                        <span class="detail-info-value">
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">No. KP</span>
                        <span class="detail-info-value">${ticket.NoKP || 'Tiada'}</span>
                    </div>
                </div>
            </div>
        `;
    }

    function updateSelectedTickets() {
        const checkboxes = document.querySelectorAll('.helpdesk-item-checkbox input:checked');
        selectedTickets = Array.from(checkboxes).map(cb => cb.value);
    }

    function updateCounts(counts) {
        document.getElementById('count-all').textContent = counts.all;
        document.getElementById('count-pending').textContent = counts.pending;
        document.getElementById('count-resolved').textContent = counts.resolved;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = now - date;
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));

        if (days === 0) {
            return date.toLocaleTimeString('ms-MY', { hour: '2-digit', minute: '2-digit' });
        } else if (days === 1) {
            return 'Semalam';
        } else if (days < 7) {
            return `${days} hari lalu`;
        } else {
            return date.toLocaleDateString('ms-MY', { day: 'numeric', month: 'short' });
        }
    }

    function formatDateTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('ms-MY', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Global function for status update
    window.updateTicketStatus = function (ticketId, newStatus) {
        // Updated URL to match route
        fetch(`/admin-panel/helpdesk/tickets/${ticketId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Status berjaya dikemaskini', 'success');
                    loadHelpdesk();
                    loadTicketDetail(ticketId);
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
                showNotification('Ralat mengemas kini status', 'error');
            });
    };

    // Helper function to show notifications
    function showNotification(message, type) {
        // You can implement your own notification system here
        alert(message);
    }
});