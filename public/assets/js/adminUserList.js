// Live search
document.getElementById("searchBox").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter)
            ? ""
            : "none";
    });
});

//filter jabatan
document.getElementById("jabatanFilter").addEventListener("change", function(){
    let selected = this.value.toLowerCase();
    let rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(row => {
        let jabatan = row.children[4].textContent.toLowerCase();
        row.style.display = selected === "" || jabatan === selected ? "" : "none";
    });
});