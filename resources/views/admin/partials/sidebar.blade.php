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
            <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}"
               href="{{ route('inventory.index') }}">
                <i class="ti ti-box-seam"></i>
                <span class="nav-text">Inventory</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}"
               href="{{ route('products.create') }}">
                <i class="ti ti-plus"></i>
                <span class="nav-text">Add Product</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
               href="{{ route('reports.index') }}">
                <i class="ti ti-receipt"></i>
                <span class="nav-text">Reports</span>
            </a>
        </li>

        <!-- <li>
            <a class="nav-link" href="#">
                <i class="ti ti-alert-circle"></i>
                <span class="nav-text">404 Error</span>
            </a>
        </li> -->

        <li>
            <a class="nav-link" href="#">
                <i class="ti ti-file-text"></i>
                <span class="nav-text">Docs</span>
            </a>
        </li>

        <li class="px-4 pt-4 pb-2">
            <small class="nav-text">Account</small>
        </li>

        <li>
            <a class="nav-link" href="{{ route('login') }}">
                <i class="ti ti-logout"></i>
                <span class="nav-text">Log in</span>
            </a>
        </li>

        <li>
            <a class="nav-link" href="{{ route('register') }}">
                <i class="ti ti-user-plus"></i>
                <span class="nav-text">Sign up</span>
            </a>
        </li>

    </ul>

</aside>