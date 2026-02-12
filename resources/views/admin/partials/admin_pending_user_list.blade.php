        <div id="pendingUserPanel" style="display: none; margin-top: 50px; box-shadow: 0 5px 30px 5px rgba(99, 56, 2, 0.865); border-radius: 16px; background: #ffffff2c; margin-bottom: 50px;" class="px-5 py-5">
            <div class="d-flex justify-content-between align-items-center py-3 ">
                <h1 class="pt-sans-regular">Pengguna yang Belum Disahkan <i class="fa fa-clock" style="font-size: 2rem" aria-hidden="true"></i> </h1>
                <button class="btn btn-sm btn-dark" id="closePendingPanel">
                    <i class="fas fa-times"></i>
                </button>
            </div>

    
            {{-- Search + Filter --}}
            <div class="filter-row">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari nama pengguna ataupun email..." autocomplete="off" data-mode="pending">
                    <button class="clear-search" id="clearSearch" title="Clear search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
    
            {{-- User Table --}}
            <div class="table-container">
                <table class="user-table" id="userTable">
                    <thead>
                        <tr>
                            <th>Bil.</th>
                            <th>Nama</th>
                            <th>No KP</th>
                            <th>Emel</th>
                            <th>No. Fon</th>
                            <th>Jabatan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="pendingTableBody">
                        <!-- Data will be populated by JavaScript soo will seperate for pending and suspended users-->
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <div id="pendingPagination" class="page-container container-fluid"></div>
                </div>
            </div>
        </div>