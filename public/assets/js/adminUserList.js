let searchBox;
let jabatanFilter;
let userTableBody;
let paginationDiv;
let currentPage = 1;

// GLOBAL FUNCTION → wajib untuk onclick()
async function fetchUsers(page = 1) {
    currentPage = page; // update page semasa

    const search = searchBox.value;
    const jabatan = jabatanFilter.value;

    const res = await fetch(`/admin-panel/user-list/list?search=${search}&jabatan=${jabatan}&page=${page}`);
    const json = await res.json();

    if (!json.success) return;

    renderTable(json.users);
    renderPagination(json.current_page, json.last_page);
}

function renderTable(users) {
    userTableBody.innerHTML = "";

    if (users.length === 0) {
        userTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted fst-italic">
                    Tiada rekod dijumpai
                </td>
            </tr>
        `;
        return;
    }

    let html = "";

    users.forEach(u => {
        html += `
        <tr>
            <td>${u.Nama}</td>
            <td>${u.NoKP ?? '-'}</td>
            <td>${u.emel}</td>
            <td>${u.hp ?? '-'}</td>
            <td>${u.NamaJabatan ?? '-'}</td>
            <td>${u.userlevel ?? '-'}</td>
        </tr>`;
    });

    userTableBody.innerHTML = html;
}

function renderPagination(current, last) {
    let html = "";

    // Prev button
    html += `
        <button class="page-btn" 
                onclick="fetchUsers(${current - 1})"
                ${current === 1 ? "disabled" : ""}>
            ‹
        </button>
    `;

    // Page numbers
    for (let i = 1; i <= last; i++) {
        html += `
            <button class="page-btn ${i === current ? "active" : ""}"
                    onclick="fetchUsers(${i})">
                ${i}
            </button>
        `;
    }

    // Next button
    html += `
        <button class="page-btn" 
                onclick="fetchUsers(${current + 1})"
                ${current === last ? "disabled" : ""}>
            ›
        </button>
    `;

    paginationDiv.innerHTML = html;
}


function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

document.addEventListener("DOMContentLoaded", () => {
    searchBox = document.getElementById("searchBox");
    jabatanFilter = document.getElementById("jabatanFilter");
    userTableBody = document.querySelector("#userTable tbody");
    paginationDiv = document.getElementById("pagination");

    searchBox.addEventListener("input", debounce(() => fetchUsers(1), 300));
    jabatanFilter.addEventListener("change", () => fetchUsers(1));

    fetchUsers(1);
});
    