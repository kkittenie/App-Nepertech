<aside id="sidebar" class="sidebar">

    <div class="logo-area">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logoNepertech.png') }}"
                 alt="Nepertech Logo"
                 width="34"
                 class="logo-icon">
            <span class="logo-title">
                Neper<span class="logo-accent">tech</span>
            </span>
        </a>
    </div>

    <div class="sidebar-section-label">
        <small>MENU</small>
    </div>

    <ul class="nav flex-column sidebar-nav">

        <li>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ route('dashboard') }}">
                <i class="ti ti-layout-dashboard"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
               href="{{ route('products.index') }}">
                <i class="ti ti-box"></i>
                <span class="nav-text">Produk</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}"
               href="{{ route('kategori.index') }}">
                <i class="ti ti-category"></i>
                <span class="nav-text">Kategori</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}"
               href="{{ route('admin.rentals.index') }}">
                <i class="ti ti-calendar-event"></i>
                <span class="nav-text">Penyewaan</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
               href="{{ route('users.index') }}">
                <i class="ti ti-users"></i>
                <span class="nav-text">Users</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
               href="{{ route('reports.index') }}">
                <i class="ti ti-chart-bar"></i>
                <span class="nav-text">Laporan</span>
            </a>
        </li>

    </ul>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                <span class="sidebar-user-role">Administrator</span>
            </div>
        </div>
    </div>

</aside>