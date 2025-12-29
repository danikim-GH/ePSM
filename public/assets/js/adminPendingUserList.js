let userTableBody;
let paginationDiv;
let currentPage = 1;
let currentData = null;

let usersData = [];

async function fetchUsers(page = 1) {
    currentPage = page;

    userTableBody.innerHTML = `
        <tr class="loading row">
            <td colspan="9">
                <div style="text-align: center; padding: 40px;">
                    <i class="fa fa-spinner fa-spin fa-2x" style="color: #53708eff"></i>
                    <p style="margin-top: 15px; color: #64748b;">Loading users...</p> 
                </div>
            </td>
        </tr>
    `;

    try{
        const res = await fetch(`/admin-panel/pending-user-list`);
        const json = await res.json();

        if(!json.success){
            throw new Error('Failed to fetch pending users');
        }

        currentData = json;
        usersData = json.pending;

        //function table put here m8
        renderTable(json.users);
        renderPagination(json.current_page, json.last_page);
    } catch (error){
        console.error('Error fetch pending users', error);
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

function renderTable(pending){
    userTableBody.innerHTML = "";

    if(pending.length === 0){
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

    pending.forEach((u,index)=>{
        const startIndex = (currentPage - 1) * 10;

        html += `
            <tr>
                <td>${startIndex + index + 1}</td> 
                <td>
                    <div class="user-info">
                        <strong>${u.Nama || 'NULL'}</strong>
                    </div>
                </td>
                <td>${u.NoKP || 'NULL'}</td>
                <td>${u.emel || 'NULL'}</td>
                <td>${u.hp || 'NULL'}</td>
                <td>${u.NamaJabatan || 'NULL'}</td>
                <td>Coming Soon</td>                
            </tr>
        `;
    });

    userTableBody.innerHTML = html;
}

function renderPagination(current, last){
    let html = "";

    if(last <= 1) return;

    html += `
        <button class="page-btn prev-btn" 
                onclick="fetchUsers(${current - 1})"
                ${current === 1 ? "disabled" : ""}>
            <i class="fas fa-chevron-left"></i>
        </button>
    `;

    const maxVisible = 4; // maximum pagination number yang petak tu visible
    let start = Math.max(1, current - Math.floor(maxVisible/2));
    let end = Math.min(last, start + maxVisible - 1);

    if(end - start + 1 < maxVisible){
        start = Math.max(1, end - maxVisible + 1);
    }

    //1st page
    if(start > 1){
        html += `<button class="page-btn" onclick="fetchUsers(1)">1</button>`;
        if (start > 2) html += `<span class="page-ellipsis">...</span>`;
    }

    //page numbers
    for (let i = start; i <= end; i++){
        html += `
            <button class="page-btn ${i === current ? "active" : ""}"
                    onclick="fetchUsers(${i})">
                ${i}
            </button>
        `;
    }

    //last page
    if(end < last){
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

document.addEventListener("DOMContentLoaded", () => {
    userTableBody = document.querySelector("#userTable tbody");
    paginationDiv = document.getElementById("pagination");

    fetchUsers(1);
});

window.fetchUsers = fetchUsers;