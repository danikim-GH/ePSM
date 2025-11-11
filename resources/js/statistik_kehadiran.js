document.addEventListener("DOMContentLoaded", () => {
    const jabatanDropdown = document.getElementById("jabatanDropdown");
    const jabatanList = document.getElementById("jabatanList");
    const jadualKehadiran = document.getElementById("jadualKehadiran").querySelector("tbody");
    const pencapaianBox = document.getElementById("pencapaianBox");

    /*dummy array
    const dataJabatan = {
        "BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH": { anggota: 27, jusa: 0, pnp: 5, sok1: 19, sok2: 3 },
        "BAHAGIAN KEWANGAN NEGERI KEDAH": { anggota: 14, jusa: 1, pnp: 4, sok1: 6, sok2: 3 },
        "BAHAGIAN SUMBER MANUSIA NEGERI KEDAH": { anggota: 22, jusa: 0, pnp: 9, sok1: 8, sok2: 5 },
        "BAHAGIAN PENTADBIRAN NEGERI KEDAH": { anggota: 19, jusa: 0, pnp: 6, sok1: 9, sok2: 4 },
        "BAHAGIAN PERANCANGAN STRATEGIK NEGERI KEDAH": { anggota: 10, jusa: 0, pnp: 4, sok1: 4, sok2: 2 },
    };
*/
    //ni bila user click dropdown item
    jabatanList.querySelectorAll(".dropdown-item").forEach(item => {
        item.addEventListener("click", async (e) => {
            e.preventDefault();
            const jabatan = e.target.textContent.trim();

            //update button text
            jabatanDropdown.textContent = jabatan;

            try {
                const response = await fetch(`/getDataJabatan?nama=${encodeURIComponent(jabatan)}`);
                const result = await response.json();

                if(!result.success||!result.data.length){
                    jadualKehadiran.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center text-danger fw-bold">
                                NOT FOUND ANY DATA
                            </td>
                        </tr>
                    `;

                    pencapaianBox.innerHTML = '';
                    return;
                }

                //create table based on lantikan
                let rows="";
                let totalKeseluruhan = 0;
                
                result.data.forEach(item =>{
                    totalKeseluruhan += item.total;
                    rows+=`
                        <tr>
                            <td class="text-start">${jabatan}</td>
                            <td>${item.lantikan}</td>
                            <td>${item.pnp}</td>
                            <td>${item.sokongan1}</td>
                            <td>${item.sokongan2}</td>
                            <td>${item.total}</td>
                        </tr>
                    `;
                });

                jadualKehadiran.innerHTML = rows;
                pencapaianBox.innerHTML = `% Pencapaian (7 Hari Berkursus): 100% (${totalKeseluruhan} orang)`;

            } catch{
                console.error("Error fetching data:", error);
                jadualKehadiran.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-danger fw-bold">
                            ERROR FETCHING DATA
                        </td>
                    </tr>
                `;
            }

            //ambik data
            const data = dataJabatan[jabatan];
            if(!data) return;

        });
    });
});