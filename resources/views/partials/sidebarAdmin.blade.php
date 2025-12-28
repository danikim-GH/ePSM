    {{-- Side Navigation --}}
    <aside class="admin-sidebar bg-dark collapsed" id="adminSidebar">
        <div class="text-center">
            <img class="kedah-img" src="{{ asset("assets/img/cropped-kedah-baru.png") }}" alt="logoKedah" style="max-width: 50px; margin-right:30px">
        </div>
        <div class="sidebar-header">
            <h2 class="gabarito-regular">Admin Panel</h2>
            <i class="bi bi-list sidebar-toggle" style="margin-bottom: 5px" id="sidebarToggle"></i>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('adminView') ? 'active' : '' }}" title="Pending Users">
                <a href="{{ route('adminView') }}">
                    <i class="bi bi-person-fill-add"></i>
                    <span class="menu-text">Daftar Pengguna</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('view') ? 'active' : '' }}" title="All Users">
                <a href="{{ route('view') }}" title="All Users">
                    <i class="fas fa-users"></i>
                    <span class="material-symbols-outlined"></span>
                    <span class="menu-text">All Users</span>
                </a>
            </li>
            <li class="" title="Jabatan">
                <a href="#" title="Jabatan">
                    <i class="fa fa-building"></i>
                    <span class="material-symbols-outlined"></span>
                    <span class="menu-text">Jabatan</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.setting') ? 'active': '' }}" title="Settings">
                <a href="{{ route('admin.setting') }}" title="Settings">
                    <i class="fas fa-cogs"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </li>
        </ul>

        {{-- Back to Home button at bottom --}}
        <div class="sidebar-bottom">
            <a href="{{ route('home') }}" class="sidebar-home-btn">
                <i class="fas fa-home"></i>
                <span class="menu-text">Back to Home</span>
            </a>
        </div>
    </aside>