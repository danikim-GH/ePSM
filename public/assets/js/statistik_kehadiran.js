document.addEventListener("DOMContentLoaded", () => {
    const jabatanDropdown = document.getElementById("jabatanDropdown");
    const jabatanList = document.getElementById("jabatanList");
    const resultContainer = document.getElementById("resultContainer");
    const lantikanDropdown = document.getElementById("lantikanDropdown");
    const btnHantar = document.getElementById("btnHantar");

    let selectedJabatan = "";
    let selectedLantikan = "Tetap";
    let selectedTahun = "2025";

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
        item.addEventListener( "click", (e) =>{
            e.preventDefault();
            e.stopPropagation();
            selectedJabatan = item.textContent.trim();
            jabatanDropdown.textContent = selectedJabatan;
        });
    });

    document.querySelectorAll("#lantikanDropdown + .dropdown-menu .dropdown-item").forEach(item => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            selectedLantikan = item.dataset.value;
            lantikanDropdown.textContent = selectedLantikan;
        });
    });

    document.querySelectorAll("#tahunMenu .dropdown-item").forEach( item => {
        item.addEventListener( "click", function(e) {
            e.preventDefault();
            selectedTahun = this.getAttribute('data-value');
            document.getElementById('tahunDropdown').textContent = selectedTahun;
        });
    });

    //bila click hantar, fetch ke backend
    btnHantar.addEventListener("click", async() => {
        if(!selectedJabatan){
            alert("Sila pilih jabatan terlebih dahulu");
            return;
        }

        resultContainer.innerHTML = `<div class="text-muted fst-italic">loading...</div>`;

        try{
            const response = await fetch(`/getKursus?NamaJabatan=${encodeURIComponent(selectedJabatan)}&lantikan=${encodeURIComponent(selectedLantikan)}&tahun=${encodeURIComponent(selectedTahun)}`);
            const json = await response.json();
            const data = json.by_kumpulan || [];

            if(!json.success || data.length === 0){
                resultContainer.innerHTML = `<div class="alert alert-warning">Tiada data bagi lantikan"${selectedLantikan}" di jabatan${selectedJabatan}</div>`;
                return;
            }

            let tableRows = "";
            let bil = 1;

            const summary = json.summary || {total_staff:0, staff_lebih7:0, staff_kurang7:0, staff_tidak_hadir:0, total_hari_kursus:0};
            const byKumpulan = json.by_kumpulan || 0;

            const map = {};
            byKumpulan.forEach(g => {
                const key = (g.kumpulan || '').toString().toLowerCase();
                map [key] = {
                    total_staff: g.total_staff || 0,
                    lebih7: g.lebih7 ||0,
                    kurang7: g.kurang7 ||0,
                    tidak_hadir: g.tidak_hadir||0,
                    total_hari: g.total_hari || 0
                }
            });

            const get = (label) => map[label.toLowerCase()] || {total_staff: 0, lebih7: 0, kurang7:0, tidak_hadir:0, total_hari:0};

            const rowHTML = `
                <tr>
                    <td>1</td>
                    <td class"text-start">${selectedJabatan}</td>
                    <td>${summary.total_staff || 0}</td>

                    <td>${get('jusa').lebih7}</td>
                    <td>${get('jusa').kurang7}</td>
                    <td>${get('jusa').tidak_hadir}</td>

                    <td>${get('pnp').lebih7}</td>
                    <td>${get('pnp').kurang7}</td>
                    <td>${get('pnp').tidak_hadir}</td>

                    <td>${get('sokongan1').lebih7}</td>
                    <td>${get('sokongan1').kurang7}</td>
                    <td>${get('sokongan1').tidak_hadir}</td>

                    <td>${get('sokongan2').lebih7}</td>
                    <td>${get('sokongan2').kurang7}</td>
                    <td>${get('sokongan2').tidak_hadir}</td>
                </tr>
            `;

            //row dekat jumlah keseluruhan
            const totalRowHTML = `
                <tr class="fw-semibold bg-light">
                    <td colspan="2">Jumlah Keseluruhan</td>
                    <td>${summary.total_staff}</td>

                    <td colspan="3">${get('jusa').lebih7+get('jusa').kurang7+get('jusa').tidak_hadir}</td>
                    <td colspan="3">${get('pnp').lebih7+get('pnp').kurang7+get('pnp').tidak_hadir}</td>
                    <td colspan="3">${get('sokongan1').lebih7+get('sokongan1').kurang7+get('sokongan1').tidak_hadir}</td>
                    <td colspan="3">${get('sokongan2').lebih7+get('sokongan2').kurang7+get('sokongan2').tidak_hadir}</td>
                </tr>
            `;

            //const total = json.summary || {};
            const tableHTML = `
            <div class="table-responsive rounded-2 mt-3">
                <table class="table table-striped table-bordered align-middle" id="jadualKehadiran">
                    <thead class="table-primary text-center text-capitalize align-middle">
                        <tr>
                            <th rowspan="2">Bil</th>
                            <th rowspan="2">Jabatan/Bahagian</th>
                            <th rowspan="2">Anggota</th>
                            <th colspan="3">Jusa</th>
                            <th colspan="3">P n P</th>
                            <th colspan="3">Sokongan 1</th>
                            <th colspan="3">Sokongan 2</th>
                        </tr>
                        
                        <tr>
                            <th>>7 hari</th>
                            <th><7 hari</th>
                            <th>Tidak hadir</th>

                            <th>>7 hari</th>
                            <th><7 hari</th>
                            <th>Tidak hadir</th>

                            <th>>7 hari</th>
                            <th><7 hari</th>
                            <th>Tidak hadir</th>

                            <th>>7 hari</th>
                            <th><7 hari</th>
                            <th>Tidak hadir</th>
                        </tr>

                    </thead>
                    <tbody class="text-center">
                        ${rowHTML}
                        ${totalRowHTML}
                    </tbody>
                </table>
            </div>
            <div class="alert alert-primary text-center fw-semibold mt-3" role="alert">
                % Pencapaian (7 Hari Berkursus):
                100% (${summary.total_staff || 0} orang)
            </div>
            `;

            resultContainer.innerHTML = tableHTML;
        } catch(err){
            console.error(err);
            resultContainer.innerHTML = `<div class="alert alert-danger">Ralat ketika mengambil data dari pelayan.</div>`;
        }
    });
});