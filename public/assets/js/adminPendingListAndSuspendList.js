function adminPendingListAndSuspendList({ tableBodyId, paginationId, fetchUrl, mode }) {

    let currentPage = 1;
    let userCache = {};

    const tableBody = document.getElementById(tableBodyId);
    const pagination = document.getElementById(paginationId);

    if (!tableBody || !pagination) return null;

    async function fetchUsers(page = 1, extra = {}) {
        const params = new URLSearchParams({ page, ...extra });
        currentPage = page;

        tableBody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center py-4">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </td>
            </tr>
        `;

        try {
            const res = await fetch(`${fetchUrl}?${params}`);
            const json = await res.json();

            if (!json.success) throw new Error();

            renderTable(json.users);
            renderPagination(json.current_page, json.last_page);

        } catch (e) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center text-danger">
                        Failed to load data
                    </td>
                </tr>
            `;
        }
    }

    function renderTable(users) {
        tableBody.innerHTML = "";

        if (!users || users.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center">No users found</td>
                </tr>
            `;
            return;
        }

        users.forEach((u, i) => {
            let actionButtons = '';
            userCache[u.NoKP] = u;

            if (mode === 'pending') {
                actionButtons = `
                    <button class="btn btn-sm btn-success btn-approve" data-id="${u.NoKP}" data-target-modal="#viewUserModal" data-user="${encodeURIComponent(JSON.stringify(u))}">
                        <i class="fas fa-eye"></i>
                    </button>

                    <button class="btn btn-sm btn-danger btn-reject" data-id="${u.NoKP}" data-target-modal="#suspendUserModal" data-user="${encodeURIComponent(JSON.stringify(u))}">
                        <i class="fas fa-user-slash"></i>
                    </button>
                `;
            } else if (mode === 'suspended') {
                actionButtons = `
                    <button class="btn btn-sm btn-primary btn-reactivate" data-id="${u.NoKP}" data-target-modal="#reactivateUserModal" data-user="${encodeURIComponent(JSON.stringify(u))}">
                        <i class="fas fa-history"></i>
                    </button>

                    <button class="btn btn-sm btn-danger btn-delete" data-id="${u.NoKP}" data-target-modal="#deleteUserModal" data-user="${encodeURIComponent(JSON.stringify(u))}">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
            }

            tableBody.innerHTML += `
                <tr>
                    <td>${(currentPage - 1) * 5 + i + 1}</td>
                    <td>${u.Nama ?? 'NULL'}</td>
                    <td>${u.NoKP ?? 'NULL'}</td>
                    <td>${u.emel ?? 'NULL'}</td>
                    <td>${u.hp ?? 'NULL'}</td>
                    <td>${u.NamaJabatan ?? 'NULL'}</td>
                    <td class="text-center">
                        <div class="action-group">
                            ${actionButtons}
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function renderPagination(current, last) {
        pagination.innerHTML = "";

        if (last <= 1) return;

        const createBtn = (page, text, isDisabled = false, isActive = false) => {
            const btn = document.createElement('button');
            btn.className = `page-btn ${isActive ? 'active' : ''}`;
            btn.innerHTML = text;
            btn.disabled = isDisabled;
            if (!isDisabled) {
                btn.addEventListener('click', () => fetchUsers(page));
            }
            return btn;
        };

        // --- BTN PREVIOUS ---
        pagination.appendChild(createBtn(current - 1, '<i class="fas fa-chevron-left"></i>', current === 1));

    // --- LOGIK NOMBOR (SLIDING WINDOW) ---
        const maxVisible = 5;
        let start = Math.max(1, current - Math.floor(maxVisible / 2));
        let end = Math.min(last, start + maxVisible - 1);

        if (end - start + 1 < maxVisible) {
            start = Math.max(1, end - maxVisible + 1);
        }

        // First Page & Ellipsis
        if (start > 1) {
            pagination.appendChild(createBtn(1, '1'));
            if (start > 2) {
                const span = document.createElement('span');
                span.className = 'page-ellipsis';
                span.textContent = '...';
                pagination.appendChild(span);
            }
        }

        // Loop Nombor Page
        for (let i = start; i <= end; i++) {
            pagination.appendChild(createBtn(i, i, false, i === current));
        }

        // Last Page & Ellipsis
        if (end < last) {
            if (end < last - 1) {
                const span = document.createElement('span');
                span.className = 'page-ellipsis';
                span.textContent = '...';
                pagination.appendChild(span);
            }
            pagination.appendChild(createBtn(last, last));
        }

        // --- BUTANG NEXT ---
        pagination.appendChild(createBtn(current + 1, '<i class="fas fa-chevron-right"></i>', current === last));
    }

    tableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;

        const id = btn.dataset.id;
        const targetModal = btn.dataset.targetModal;

        let user = null;
        if(btn.dataset.user){
            try{
                user = JSON.parse(decodeURIComponent(btn.dataset.user));
            } catch(err){
                console.error('Failed to parse user data from button dataset', err);
            }
        }

        if (!id || !targetModal) return console.log('Missing data-id or data-target-modal');
        
        openModal(targetModal, id, user);
    });

    return {
        fetch: fetchUsers,
        getUser: (id) => userCache[id] || null,
    };
}

document.addEventListener('DOMContentLoaded', () => {
    let activeModal = null;

    function openModal(modalId, userId, user) {
        const modal = document.querySelector(modalId);

        if(!modal) return;

        modal.dataset.userId = userId;
        modal.classList.add('show');
        activeModal = modal;

        const action = modal.dataset.action;

        if(user){
            injectUserDataIntoModal(modal, user);
        } else {
            console.log(`Fetch user data for ID: ${userId} for action: ${action}`);
        }
    }

    function injectUserDataIntoModal(modal, u) {
        const body = modal.querySelector('.modal-body');
        const action = modal.dataset.action;

        if (!body) return console.log('Modal body not found');

        if(action === 'delete'){
            body.innerHTML = `
                <p>Delete akaun pengguna yang telah dibekukan ini <strong>${u.Nama}</strong>?</p>
            `;
            return;
        }

        if(action === 'reactivate'){
            body.innerHTML = `
                <p>Tetapkan kembali kepada status akaun <strong>${u.Nama}</strong> yang belum disahkan?</p>
                <p>Pengguna akan kembali ke status <strong>Belum Disahkan</strong></p>
                <p>user level sekarang: ${u.userlevel}</p>
            `;
            return;
        }

        body.innerHTML = `
            <div class="user-summary">
                <p><strong>Name:</strong> ${u.Nama}</p>
                <p><strong>Email:</strong> ${u.emel}</p>
                <p><strong>No KP:</strong> ${u.NoKP}</p>
                <p><strong>Jabatan:</strong> ${u.NamaJabatan}</p>
            </div>
        `;
    }

    function closeModal() {
        if (!activeModal) return;

        activeModal.classList.remove('show');
        activeModal.dataset.userId = '';
        activeModal = null;
    }

    function showToast(message, type = 'success', action = null) {
        const toast = document.createElement('div');
        
        // Determine toast class based on action
        let toastClass = 'toast-success'; // default
        
        if (action) {
            switch(action) {
                case 'delete':
                    toastClass = 'toast-delete';
                    break;
                case 'suspend':
                    toastClass = 'toast-suspend';
                    break;
                case 'reactivate':
                    toastClass = 'toast-reactivate';
                    break;
                case 'view':
                case 'approve':
                    toastClass = 'toast-approve';
                    break;
                default:
                    toastClass = `toast-${type}`;
            }
        } else {
            toastClass = `toast-${type}`;
        }
        
        toast.className = `toast ${toastClass}`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 50);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
            window.location.reload();
        }, 1000);
    }

    function getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    document.addEventListener('click', (e) => {
        if(e.target.matches('.modal-close') || e.target.matches('.modal .btn-cancel-modal') || e.target.matches('.btn-cancel-modal')){
            closeModal();
        }
    });

    async function handleUserAction({ userId, action }) {
        let url = '';
        let payload = {};
        let method = 'POST';

        switch (action) {
            case 'suspend': 
                url = `/admin/users/${userId}/update-level`; 
                payload = { userlevel: 'SP' }; 
                break;
            case 'view': 
                url = `/admin/users/${userId}/update-level`; 
                payload = { userlevel: '1' }; 
                break;
            case 'reactivate': 
                url = `/admin/users/${userId}/update-level`; 
                payload = { userlevel: '0' }; 
                break;
            case 'delete': 
                url = `/admin/users/${userId}`; 
                method = 'DELETE'; 
                break;
        }

        //console.log('DEBUG fetch', method, url, payload);

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCSRFToken()
                },
                body: method === 'DELETE' ? null : JSON.stringify(payload)
            });

            const text = await res.text();
            console.log('DEBUG response', text);

            const json = JSON.parse(text);
            if (!json.success) throw new Error(json.message || 'Action failed');

            // Pass the action to showToast
            showToast(json.message || 'Action successful', 'success', action);
            
            if (window.pendingList) window.pendingList.fetch(1);
            if (window.suspendedList) window.suspendedList.fetch(1);

        } catch (err) {
            console.error('Fetch error', err);
            showToast(err.message || 'Something went wrong', 'error');
        }
    }

    document.addEventListener('click', (e) => {
        const btn = e.target.closest(
            '.btn-suspend-modal, .btn-sahkan-modal, .btn-delete-modal, .btn-reactivate-modal'
        );
        if (!btn) return;

        const modal = btn.closest('.modal');
        if (!modal) return;

        const userId = modal.dataset.userId;
        const action = modal.dataset.action;

        if (!userId || !action) return;

        handleUserAction({ userId, action });
        closeModal();
    });

    // expose global
    window.openModal = openModal;
});