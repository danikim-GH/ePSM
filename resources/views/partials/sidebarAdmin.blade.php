    {{-- Side Navigation --}}
    <aside class="admin-sidebar bg-dark collapsed" id="adminSidebar">
        <div class="text-center sidebar-logo-wrapper">
            <img class="kedah-img" src="{{ asset("assets/img/cropped-kedah-baru.png") }}" alt="logoKedah" style="max-width: 50px;">
            <div class="sidebar-logo-divider"></div>
            <img class="sidebar-logo-epsm" src="{{ asset("assets/img/logo_epsm.png") }}" alt="">
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
                    <span class="menu-text">Senarai Pengguna</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.viewApproveKursus') }}" title="Pengesahan Kursus">
                <a href="{{ route('admin.viewApproveKursus') }}" title="Pengesahan Kursus">
                    <i class="fa fa-list" aria-hidden="true"></i>
                    <span class="material-symbols-outlined"></span>
                    <span class="menu-text">Pengesahan Kursus</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.helpdesk') ? 'active':'' }}" title="Helpdesks">
                <a href="{{ route('admin.helpdesk') }}" title="Helpdesks">
                    <i class="bi bi-headset"></i>
                    <span class="material-symbols-outlined"></span>
                    <span class="menu-text">Helpdesks</span>
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
                <span class="menu-text">Kembali ke Halaman Utama</span>
            </a>
        </div>
    </aside>