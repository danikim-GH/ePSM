<div class="mobile-bottom-nav">
    <a href="{{ route('adminView') }}" class="nav-item {{ request()->routeIs('adminView') ? 'active' : '' }}">
        <i class="fas fa-user-clock"></i>
        <span>Pending</span>
    </a>
    <a href="{{ route('view') }}" class="nav-item {{ request()->routeIs('view') ? 'active' : '' }}">
        <i class="fas fa-users"></i>
        <span>Users</span>
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
    <a href="{{ route('home') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
</div>