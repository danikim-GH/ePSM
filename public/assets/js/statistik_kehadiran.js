document.addEventListener("DOMContentLoaded", () => {
    const jabatanDropdown = document.getElementById("jabatanDropdown");
    const jabatanList = document.getElementById("jabatanList");
    const resultContainer = document.getElementById("resultContainer");
    const lantikanDropdown = document.getElementById("lantikanDropdown");
    const tahunDropdown = document.getElementById("tahunDropdown");
    const btnHantar = document.getElementById("btnHantar");

    let selectedJabatan = "";
    let selectedLantikan = "Tetap";
    let selectedTahun = "2025";

    // Initialize default values display
    lantikanDropdown.querySelector('.stat-dropdown-value').textContent = selectedLantikan;
    tahunDropdown.querySelector('.stat-dropdown-value').textContent = selectedTahun;

    // Handle Jabatan selection
    jabatanList.querySelectorAll(".dropdown-item").forEach(item => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            selectedJabatan = item.textContent.trim();
            
            // Update button display
            const btnText = jabatanDropdown.querySelector('.stat-department-text');
            if (btnText) {
                btnText.textContent = selectedJabatan;
            } else {
                jabatanDropdown.innerHTML = `
                    <span class="stat-department-text">${selectedJabatan}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                    </svg>
                `;
            }
            
            // Add visual feedback
            jabatanDropdown.style.borderColor = '#10b981';
            setTimeout(() => {
                jabatanDropdown.style.borderColor = '#667eea';
            }, 300);
        });
    });

    // Handle Lantikan selection
    document.querySelectorAll("#lantikanDropdown + .dropdown-menu .dropdown-item").forEach(item => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            selectedLantikan = item.dataset.value;
            lantikanDropdown.querySelector('.stat-dropdown-value').textContent = selectedLantikan;
            
            // Add visual feedback
            lantikanDropdown.style.borderColor = '#10b981';
            setTimeout(() => {
                lantikanDropdown.style.borderColor = '#e2e8f0';
            }, 300);
        });
    });

    // Handle Tahun selection
    document.querySelectorAll("#tahunMenu .dropdown-item").forEach(item => {
        item.addEventListener("click", function(e) {
            e.preventDefault();
            selectedTahun = this.getAttribute('data-value');
            tahunDropdown.querySelector('.stat-dropdown-value').textContent = selectedTahun;
            
            // Add visual feedback
            tahunDropdown.style.borderColor = '#10b981';
            setTimeout(() => {
                tahunDropdown.style.borderColor = '#e2e8f0';
            }, 300);
        });
    });

    // Handle Submit Button
    btnHantar.addEventListener("click", async() => {
        if (!selectedJabatan) {
            // Enhanced alert with animation
            resultContainer.innerHTML = `
                <div class="alert alert-warning" role="alert" style="animation: fadeIn 0.3s ease-out;">
                    <i class="fa fa-warning" aria-hidden="true"></i>
                    <strong>Perhatian!</strong><br>
                    Sila pilih jabatan terlebih dahulu sebelum meneruskan.
                </div>
            `;
            
            // Shake the jabatan button
            jabatanDropdown.style.animation = 'shake 0.5s';
            setTimeout(() => {
                jabatanDropdown.style.animation = '';
            }, 500);
            return;
        }

        // Enhanced loading state
        resultContainer.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Memuatkan...</span>
                </div>
                <p class="text-muted fst-italic">Sedang mengambil data...</p>
            </div>
        `;

        try {
            const response = await fetch(`/getKursus?NamaJabatan=${encodeURIComponent(selectedJabatan)}&lantikan=${encodeURIComponent(selectedLantikan)}&tahun=${encodeURIComponent(selectedTahun)}`);
            const json = await response.json();
            const data = json.by_kumpulan || [];

            if (!json.success || data.length === 0) {
                resultContainer.innerHTML = `
                    <div class="alert alert-warning" role="alert">
                        <div class="summary-header left">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                            <h5 class="alert-heading gabarito-regular">Tiada Data Dijumpai</h5>
                        </div>
                        <p class="mb-0">Tiada data bagi <strong>${selectedLantikan}</strong> di <strong>${selectedJabatan}</strong> untuk tahun <strong>${selectedTahun}</strong>.</p>
                    </div>
                `;
                return;
            }

            const summary = json.summary || {
                total_staff: 0,
                staff_lebih7: 0,
                staff_kurang7: 0,
                staff_tidak_hadir: 0,
                total_hari_kursus: 0
            };

            const byKumpulan = json.by_kumpulan || [];

            // Create map for easy access
            const map = {};
            byKumpulan.forEach(g => {
                const key = (g.kumpulan || '').toString().toLowerCase();
                map[key] = {
                    total_staff: g.total_staff || 0,
                    lebih7: g.lebih7 || 0,
                    kurang7: g.kurang7 || 0,
                    tidak_hadir: g.tidak_hadir || 0,
                    total_hari: g.total_hari || 0
                };
            });

            const get = (label) => map[label.toLowerCase()] || {
                total_staff: 0,
                lebih7: 0,
                kurang7: 0,
                tidak_hadir: 0,
                total_hari: 0
            };

            // Build table row
            const rowHTML = `
                <tr>
                    <td>1</td>
                    <td class="text-start">${selectedJabatan}</td>
                    <td><strong>${summary.total_staff || 0}</strong></td>

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

            // Build total row
            const totalRowHTML = `
                <tr class="fw-semibold bg-light">

                    <td colspan="2" class="text-start"> Jumlah Keseluruhan</td>
                    <td><strong>${summary.total_staff}</strong></td>

                    <td colspan="3">${get('jusa').lebih7 + get('jusa').kurang7 + get('jusa').tidak_hadir}</td>
                    <td colspan="3">${get('pnp').lebih7 + get('pnp').kurang7 + get('pnp').tidak_hadir}</td>
                    <td colspan="3">${get('sokongan1').lebih7 + get('sokongan1').kurang7 + get('sokongan1').tidak_hadir}</td>
                    <td colspan="3">${get('sokongan2').lebih7 + get('sokongan2').kurang7 + get('sokongan2').tidak_hadir}</td>
                </tr>
            `;

            // Calculate percentage
            const totalDays = summary.total_hari_kursus || 0;
            const staffWithAtLeast7Days = summary.staff_lebih7 || 0;
            const totalStaff = summary.total_staff || 0;
            const percentage = totalStaff > 0 ? ((staffWithAtLeast7Days / totalStaff) * 100).toFixed(2) : 0;

            // Build complete table
            const tableHTML = `
                <div class="table-responsive rounded-2 mt-3" style="animation: fadeIn 0.5s ease-out;">
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
                
                <div class="alert alert-primary text-center fw-semibold mt-4" role="alert" style="animation: fadeIn 0.6s ease-out 0.2s both;">
                    <div class="summary-header">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        <h3 class="mb-3 gabarito-regular">Ringkasan Pencapaian</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <p class="mb-1">% Pencapaian (≥7 Hari Berkursus):</p>
                            <h3 class="mb-0 righteous-regular">${percentage}%</h3>
                            <small>(${staffWithAtLeast7Days} daripada ${totalStaff} orang)</small>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">Jumlah Hari Kursus:</p>
                            <h3 class="mb-0 righteous-regular">${totalDays} hari</h3>
                            <small>Keseluruhan jabatan</small>
                        </div>
                    </div>
                </div>
            `;

            resultContainer.innerHTML = tableHTML;

        } catch (err) {
            console.error('Error fetching data:', err);
            resultContainer.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <h5 class="alert-heading">❌ Ralat Berlaku</h5>
                    <p class="mb-0">Ralat ketika mengambil data dari pelayan. Sila cuba sebentar lagi.</p>
                    <hr>
                    <small class="text-muted">Mesej ralat: ${err.message}</small>
                </div>
            `;
        }
    });
});

// Add shake animation dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
`;
document.head.appendChild(style);