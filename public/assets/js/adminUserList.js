let searchBox;
let jabatanFilter;
let levelFilter;
let userTableBody;
let paginationDiv;
let clearSearchBtn;
let currentPage = 1;
let currentData = null;

// DOM Elements for Modals
let editModal;
let deleteModal;
let closeModalBtn;
let cancelEditBtn;
let cancelDeleteBtn;
let confirmDeleteBtn;
let editUserForm;
let deleteUserName;

// Store user data for operations
let usersData = [];

// Debounce function for search
function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

// GLOBAL FUNCTION > wajib untuk onclick()
async function fetchUsers(page = 1) {
    currentPage = page;
    
    const search = searchBox.value;
    const jabatan = jabatanFilter.value;
    const level = levelFilter.value;
    
    // Show loading
    userTableBody.innerHTML = `
        <tr class="loading-row">
            <td colspan="9">
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin fa-2x" style="color: #53708eff;"></i>
                    <p style="margin-top: 15px; color: #64748b;">Loading users...</p> 
                </div>
            </td>
        </tr>
    `;

    try {
        const res = await fetch(`/admin-panel/user-list/list?search=${encodeURIComponent(search)}&jabatan=${encodeURIComponent(jabatan)}&level=${encodeURIComponent(level)}&page=${page}`);
        const json = await res.json();
        
        if (!json.success) {
            throw new Error('Failed to fetch users');
        }
        
        currentData = json;
        usersData = json.users;
        
        renderTable(json.users);
        renderPagination(json.current_page, json.last_page);
        updateStats(json);
    } catch (error) {
        console.error('Error fetching users:', error);
        userTableBody.innerHTML = html `
            <tr>
                <td colspan="9" class="no-data">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Failed to load data. Please try again.</p>
                </td>
            </tr>
        `;
    }
}

function renderTable(users) {
    userTableBody.innerHTML = "";
    
    if (users.length === 0) {
        userTableBody.innerHTML = `
            <tr>
                <td colspan="9" class="no-data">
                    <i class="fas fa-users-slash"></i>
                    <p>No users found</p>
                    <p style="font-size: 14px; margin-top: 10px;">Try adjusting your search or filters</p>
                </td>
            </tr>
        `;
        return;
    }
    
    let html = "";
    
    users.forEach((u, index) => {
        const startIndex = (currentPage - 1) * 10; // Assuming 10 per page

        html += `
        <tr>
            <td>${startIndex + index + 1}</td>
            <td>
                <div class="user-info">
                    <strong>${u.Nama || 'NULL'}</strong>
                </div>
            </td>
            <td>${u.NoKP || 'NULL'}</td>
            <td>
                <div class="email-cell">
                    ${u.emel || 'NULL'}
                </div>
            </td>
            <td>${u.hp || 'NULL'}</td>
            <td>
                <span class="department-badge">${u.NamaJabatan || 'NULL'}</span>
            </td>
            <td>
                <span class="level-badge level-${u.userlevel || 'user'}">
                    ${userLevelLabel(u.userlevel)}
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn-action btn-edit" onclick="openEditModal(${index})" title="Edit user">
                        <i class="fas fa-edit"></i>
                        <span class="action-text">Edit</span>
                    </button>
                    <button class="btn-action btn-delete" onclick="openDeleteModal(${index})" title="Delete user">
                        <i class="fas fa-trash"></i>
                        <span class="action-text">Delete</span>
                    </button>
                </div>
            </td>
        </tr>`;
    });
    
    userTableBody.innerHTML = html;
}


function renderPagination(current, last) {
    let html = "";
    
    if (last <= 1) return;
    
    // Prev button
    html += `
        <button class="page-btn prev-btn" 
                onclick="fetchUsers(${current - 1})"
                ${current === 1 ? "disabled" : ""}>
            <i class="fas fa-chevron-left"></i>
        </button>
    `;
    
    // Show page numbers with ellipsis
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = Math.min(last, start + maxVisible - 1);
    
    if (end - start + 1 < maxVisible) {
        start = Math.max(1, end - maxVisible + 1);
    }
    
    // First page
    if (start > 1) {
        html += `<button class="page-btn" onclick="fetchUsers(1)">1</button>`;
        if (start > 2) html += `<span class="page-ellipsis">...</span>`;
    }
    
    // Page numbers
    for (let i = start; i <= end; i++) {
        html += `
            <button class="page-btn ${i === current ? "active" : ""}"
                    onclick="fetchUsers(${i})">
                ${i}
            </button>
        `;
    }
    
    // Last page
    if (end < last) {
        if (end < last - 1) html += `<span class="page-ellipsis">...</span>`;
        html += `<button class="page-btn" onclick="fetchUsers(${last})">${last}</button>`;
    }
    
    // Next button
    html += `
        <button class="page-btn next-btn" 
                onclick="fetchUsers(${current + 1})"
                ${current === last ? "disabled" : ""}>
            <i class="fas fa-chevron-right"></i>
        </button>
    `;
    
    paginationDiv.innerHTML = html;
}

function updateStats(data) {
    const totalUsers = document.getElementById('totalUsers');
    const showingStart = document.getElementById('showingStart');
    const showingEnd = document.getElementById('showingEnd');
    const totalRecords = document.getElementById('totalRecords');
    
    if (totalUsers) {
        totalUsers.textContent = data.total_users || 0;
    }
    
    if (showingStart && showingEnd && totalRecords) {
        const perPage = 1; //adjust if needed
        const start = ((currentPage - 1) * perPage) + 1;
        const end = currentData.users.length;
        
        showingStart.textContent = start;
        showingEnd.textContent = end;
        totalRecords.textContent = currentData.total_users || 0;
    }
}

// Modal Functions
function openEditModal(userIndex) {
    const user = usersData[userIndex];
    if (!user) return;
    
    // Populate form fields
    document.getElementById('editUserId').value = user.id || userIndex;
    document.getElementById('editName').value = user.Nama || '';
    document.getElementById('editEmail').value = user.emel || '';
    document.getElementById('editPhone').value = user.hp || '';
    document.getElementById('editNoKP').value = user.NoKP || '';
    document.getElementById('editLevel').value = user.userlevel || 'user';
    document.getElementById('editDepartment').value = user.NamaJabatan || '';    
    // Show modal
    editModal.style.display = 'flex';
}

function openDeleteModal(userIndex) {
    const user = usersData[userIndex];
    if (!user) return;
    
    // Store the user index for deletion
    confirmDeleteBtn.dataset.userIndex = userIndex;
    
    // Show user name in confirmation
    deleteUserName.textContent = user.Nama || 'This user';
    
    // Show modal
    deleteModal.style.display = 'flex';
}

function closeModal() {
    editModal.style.display = 'none';
    deleteModal.style.display = 'none';
}

function closeModalOnOutsideClick(event) {
    if (event.target === editModal || event.target === deleteModal) {
        closeModal();
    }
}

// Event Listeners
function setupEventListeners() {
    // Search and filter events
    searchBox.addEventListener('input', debounce(() => fetchUsers(1), 300));
    jabatanFilter.addEventListener('change', () => fetchUsers(1));
    levelFilter.addEventListener('change', () => fetchUsers(1));
    
    // Clear search button
    clearSearchBtn.addEventListener('click', () => {
        searchBox.value = '';
        fetchUsers(1);
    });
    
    // Modal close events
    closeModalBtn.addEventListener('click', closeModal);
    cancelEditBtn.addEventListener('click', closeModal);
    cancelDeleteBtn.addEventListener('click', closeModal);
    
    // Outside click to close modal
    window.addEventListener('click', closeModalOnOutsideClick);
    
    // Form submission
    editUserForm.addEventListener('submit', handleEditSubmit);
    
    // Delete confirmation
    confirmDeleteBtn.addEventListener('click', handleDelete);
}

// Form submission handler
async function handleEditSubmit(event) {
    event.preventDefault();
    
    // Show loading state
    const submitBtn = editUserForm.querySelector('.btn-save');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    submitBtn.disabled = true;
    
    try {
        // Get form data
        const formData = {
            id: document.getElementById('editUserId').value,
            name: document.getElementById('editName').value,
            email: document.getElementById('editEmail').value,
            phone: document.getElementById('editPhone').value,
            no_kp: document.getElementById('editNoKP').value,
            level: document.getElementById('editLevel').value,
            department: document.getElementById('editDepartment').value,
        };
        
        // TODO: Replace with actual API call
        console.log('Updating user:', formData);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Show success message
        alert('User updated successfully!');
        
        // Close modal and refresh data
        closeModal();
        fetchUsers(currentPage);
        
    } catch (error) {
        console.error('Error updating user:', error);
        alert('Failed to update user. Please try again.');
    } finally {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

// Delete handler
async function handleDelete() {
    const userIndex = confirmDeleteBtn.dataset.userIndex;
    const user = usersData[userIndex];
    
    if (!user) return;
    
    // Show loading state
    confirmDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    confirmDeleteBtn.disabled = true;
    
    try {
        // TODO: Replace with actual API call
        console.log('Deleting user:', user);
        
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Show success message
        alert('User deleted successfully!');
        
        // Close modal and refresh data
        closeModal();
        fetchUsers(currentPage);
        
    } catch (error) {
        console.error('Error deleting user:', error);
        alert('Failed to delete user. Please try again.');
    } finally {
        // Restore button state
        confirmDeleteBtn.innerHTML = '<i class="fas fa-trash"></i> Delete User';
        confirmDeleteBtn.disabled = false;
    }
}

//Return user level value into string even it is string tho
function userLevelLabel(level){
    switch(level){
        case '9': return 'Admin';
        case '8': return 'EO';
        case '1': return 'Staff';
        case '0': return 'Pending User';
        default: return 'Undefined';
    }
}

// Initialize
document.addEventListener("DOMContentLoaded", () => {
    // Initialize DOM elements
    searchBox = document.getElementById("searchBox");
    jabatanFilter = document.getElementById("jabatanFilter");
    levelFilter = document.getElementById("levelFilter");
    userTableBody = document.querySelector("#userTable tbody");
    paginationDiv = document.getElementById("pagination");
    clearSearchBtn = document.getElementById("clearSearch");
    
    // Modal elements
    editModal = document.getElementById("editUserModal");
    deleteModal = document.getElementById("deleteConfirmModal");
    closeModalBtn = document.getElementById("closeModal");
    cancelEditBtn = document.getElementById("cancelEdit");
    cancelDeleteBtn = document.getElementById("cancelDelete");
    confirmDeleteBtn = document.getElementById("confirmDelete");
    editUserForm = document.getElementById("editUserForm");
    deleteUserName = document.getElementById("deleteUserName");
    
    // Setup event listeners
    setupEventListeners();
    
    // Initial fetch
    fetchUsers(1);
});

// Export functions for global use
window.fetchUsers = fetchUsers;
window.openEditModal = openEditModal;
window.openDeleteModal = openDeleteModal;