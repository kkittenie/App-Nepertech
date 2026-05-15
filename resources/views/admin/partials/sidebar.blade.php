<aside id="sidebar" class="sidebar">

    <div class="logo-area d-flex align-items-center px-3 mb-4">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
            
            <img src="{{ asset('assets/images/logoNepertech.png') }}" 
                 alt="Nepertech Logo" 
                 width="38"
                 class="me-2">

            <span class="fw-bold fs-4 text-dark logo-title">
                Neper<span style="color: #2c6b9e;">tech</span>
            </span>

        </a>
    </div>

    <ul class="nav flex-column">

        <li>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ route('dashboard') }}">
                <i class="ti ti-home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
               href="{{ route('products.index') }}">
                <i class="ti ti-box-seam"></i>
                <span class="nav-text">Produk</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('kategori.index') ? 'active' : '' }}"
               href="{{ route('kategori.index') }}">
                <i class="ti ti-category"></i>
                <span class="nav-text">Kategori</span>
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
                <i class="ti ti-receipt"></i>
                <span class="nav-text">Laporan</span>
            </a>
        </li>





    </ul>

</aside>