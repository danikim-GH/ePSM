        <div id="pendingUserPanel" style="display: none; margin-top: 50px; box-shadow: 5px 8px 20px 5px rgba(0, 20, 66, 0.25); border-radius: 16px; background: #ffffff2c;" class="px-5 py-5">
            
            <div class="d-flex justify-content-between align-items-center py-3 ">
                <h1 class="pt-sans-regular">User Pending</h1>
                <button class="btn btn-sm btn-dark" id="closePendingPanel">
                    <i class="fas fa-times"></i>
                </button>
            </div>

    
            {{-- Search + Filter --}}
            <div class="filter-row">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchBox" placeholder="Search user name / email...">
                    <button class="clear-search" id="clearSearch" title="Clear search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
    
                <div class="filter-group">
                    <select id="jabatanFilter">
                        <option value="">All Departments</option>
                        <option value="Pentadbiran">Pentadbiran</option>
                        <option value="Sumber Manusia">Sumber Manusia</option>
                        <option value="Kewangan">Kewangan</option>
                        <option value="BAHAGIAN TEKNOLOGI MAKLUMAT KEDAH">IT</option>
                    </select>
                    
                    <select id="levelFilter">
                        <option value="">All Levels</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="staff">Staff</option>
                    </select>
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
                            <th>Level</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by JavaScript soo will seperate for pending and suspended users-->
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <div class="table-info">
                        Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalRecords">0</span> Users
                    </div>
                    <div id="pagination" class="page-container"></div>
                </div>
            </div>
        </div>