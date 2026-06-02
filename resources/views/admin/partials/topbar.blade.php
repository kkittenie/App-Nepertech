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
        @php
            $pendingRentals = \App\Models\Rental::with('product')->whereIn('status', ['pending', 'payment_submitted'])->orderBy('created_at', 'desc')->get();
            $pendingSales = \App\Models\Sale::with('product')->whereIn('status', ['pending', 'payment_submitted'])->orderBy('created_at', 'desc')->get();
            
            $allNotifications = collect();
            foreach($pendingRentals as $rental) {
                $allNotifications->push((object)[
                    'title' => 'Sewa: ' . ($rental->product->name ?? 'Produk'),
                    'desc' => $rental->status === 'payment_submitted' ? 'Pembayaran diunggah' : 'Menunggu persetujuan',
                    'time' => $rental->updated_at,
                    'link' => route('admin.rentals.index'),
                    'icon' => 'ti-calendar-time',
                    'color' => $rental->status === 'payment_submitted' ? 'success' : 'warning'
                ]);
            }
            foreach($pendingSales as $sale) {
                $allNotifications->push((object)[
                    'title' => 'Beli: ' . ($sale->product->name ?? 'Produk'),
                    'desc' => $sale->status === 'payment_submitted' ? 'Pembayaran diunggah' : 'Menunggu persetujuan',
                    'time' => $sale->updated_at,
                    'link' => route('admin.sales.index'),
                    'icon' => 'ti-shopping-cart',
                    'color' => $sale->status === 'payment_submitted' ? 'success' : 'warning'
                ]);
            }
            $allNotifications = $allNotifications->sortByDesc('time')->take(5);
            $notifCount = $allNotifications->count();
        @endphp
        <div class="dropdown">
            <button class="topbar-btn position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-bell"></i>
                @if($notifCount > 0)
                <span class="topbar-badge">{{ $notifCount }}</span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end topbar-dropdown p-0">
                <div class="topbar-dropdown-header">
                    <span class="fw-semibold">Notifikasi</span>
                    @if($notifCount > 0)
                    <span class="topbar-dropdown-badge">{{ $notifCount }} baru</span>
                    @endif
                </div>
                <ul class="list-unstyled m-0">
                    @forelse($allNotifications as $notif)
                    <li>
                        <a href="{{ $notif->link }}" class="topbar-dropdown-item text-decoration-none text-dark" style="display:flex; padding:12px 16px;">
                            <div class="topbar-dropdown-icon bg-{{ $notif->color }}-subtle text-{{ $notif->color }} me-3">
                                <i class="ti {{ $notif->icon }}"></i>
                            </div>
                            <div class="topbar-dropdown-content flex-grow-1">
                                <p class="mb-0 fw-semibold" style="font-size:13px;">{{ $notif->title }}</p>
                                <p class="mb-0 text-muted" style="font-size:12px;">{{ $notif->desc }}</p>
                                <small class="text-muted" style="font-size:11px;">{{ $notif->time->diffForHumans() }}</small>
                            </div>
                        </a>
                    </li>
                    @empty
                    <li class="p-3 text-center text-muted" style="font-size:13px;">
                        Tidak ada notifikasi baru.
                    </li>
                    @endforelse
                </ul>
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