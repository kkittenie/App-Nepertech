<nav id="topbar" class="topbar">

    {{-- Left side --}}
    <div class="topbar-left">
        {{-- Desktop collapse toggle --}}
        <button id="toggleBtn" class="topbar-btn d-none d-lg-inline-flex" title="Toggle sidebar">
            <i class="ti ti-layout-sidebar-left-expand"></i>
        </button>

        {{-- Mobile hamburger --}}
        <button id="mobileBtn" class="topbar-btn d-lg-none" title="Open menu">
            <i class="ti ti-menu-2"></i>
        </button>

        {{-- Breadcrumb / page title --}}
        <div class="topbar-title d-none d-md-block">
            <span>@yield('title', 'Dashboard')</span>
        </div>
    </div>

    {{-- Right side --}}
    <div class="topbar-right">

        {{-- Search (desktop only) --}}
        <form action="{{ route('products.index') }}" method="GET" class="topbar-search d-none d-md-flex">
            <i class="ti ti-search"></i>
            <input type="text" name="search" placeholder="Cari produk..." class="topbar-search-input" value="{{ request('search') }}">
        </form>

        {{-- Notifications --}}
        <div class="dropdown">
            <button class="topbar-btn position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-bell"></i>
                <span class="topbar-badge">2</span>
            </button>

            <div class="dropdown-menu dropdown-menu-end topbar-dropdown p-0">
                <div class="topbar-dropdown-header">
                    <span class="fw-semibold">Notifications</span>
                    <span class="topbar-dropdown-badge">2 new</span>
                </div>
                <ul class="list-unstyled m-0">
                    <li class="topbar-dropdown-item">
                        <div class="topbar-dropdown-icon bg-primary-subtle text-primary">
                            <i class="ti ti-package"></i>
                        </div>
                        <div class="topbar-dropdown-content">
                            <p>New product added</p>
                            <small>5 minutes ago</small>
                        </div>
                    </li>
                    <li class="topbar-dropdown-item">
                        <div class="topbar-dropdown-icon bg-success-subtle text-success">
                            <i class="ti ti-user-plus"></i>
                        </div>
                        <div class="topbar-dropdown-content">
                            <p>New user registered</p>
                            <small>30 minutes ago</small>
                        </div>
                    </li>
                </ul>
                <div class="topbar-dropdown-footer">
                    <a href="#">View all notifications</a>
                </div>
            </div>
        </div>

        {{-- User menu --}}
        <div class="dropdown">
            <button class="topbar-user-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="topbar-user-avatar">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    @endif
                </div>
                <span class="topbar-user-name d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                <i class="ti ti-chevron-down d-none d-md-inline" style="font-size:14px; opacity:0.5;"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end topbar-dropdown p-0" style="min-width:220px">
                <div class="topbar-dropdown-header">
                    <div>
                        <p class="fw-semibold mb-0">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <small class="text-muted">{{ auth()->user()->email ?? '' }}</small>
                    </div>
                </div>
                <ul class="list-unstyled m-0">
                    <li>
                        <a class="topbar-dropdown-link" href="{{ route('dashboard') }}">
                            <i class="ti ti-home"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="topbar-dropdown-link" href="{{ route('products.index') }}">
                            <i class="ti ti-box"></i> Produk
                        </a>
                    </li>
                    <li>
                        <a class="topbar-dropdown-link" href="{{ route('home') }}">
                            <i class="ti ti-world"></i> Website
                        </a>
                    </li>
                </ul>
                <div class="topbar-dropdown-footer">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="topbar-logout-btn">
                            <i class="ti ti-logout"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</nav>