const sidebar = document.getElementById("adminSidebar");
const content = document.getElementById("adminContent");
const toggle = document.getElementById("sidebarToggle");

toggle.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
    content.classList.toggle("expanded");
});
