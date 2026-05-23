@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- ── SUCCESS TOAST ── --}}
@if(session('success'))
<div class="toast-alert toast-success" id="dashToast" style="position:fixed; top:24px; right:24px; z-index:9999; display:flex; align-items:center; gap:12px; background:white; border:1.5px solid #86efac; border-left:5px solid #16a34a; border-radius:12px; padding:14px 18px; box-shadow:0 8px 30px rgba(0,0,0,0.1); min-width:300px; max-width:420px; animation: slideInRight 0.35s ease;">
    <div style="width:32px;height:32px;border-radius:50%;background:#dcfce7;color:#16a34a;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:16px;">
        <i class="ti ti-check"></i>
    </div>
    <span style="font-size:13.5px;color:#166534;font-weight:500;flex:1;">{{ session('success') }}</span>
    <button onclick="document.getElementById('dashToast').remove()" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:18px;line-height:1;padding:0;">×</button>
</div>
@endif

{{-- ── WA SIMULATION MODAL (from remind) ── --}}
@if(session('whatsapp_simulated'))
<div class="modal fade show" id="waSimulationModal" tabindex="-1" style="display:block; background:rgba(10,37,64,0.45); backdrop-filter:blur(8px); z-index:1050;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px; overflow:hidden;">
            <div class="d-flex align-items-center justify-content-between p-3 text-white" style="background:linear-gradient(135deg,#075e54 0%,#128c7e 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-weight:bold;">NP</div>
                    <div>
                        <h6 class="mb-0 fw-bold">Nepertech WA Gateway</h6>
                        <small style="font-size:11px;opacity:.7;">Simulasi Aktif (Fonnte API)</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" onclick="closeWaModal()"></button>
            </div>
            <div class="modal-body p-4" style="background-color:#efeae2; min-height:320px; max-height:420px; overflow-y:auto;">
                <div class="align-self-center text-center py-1 px-3 mb-3 bg-white text-muted shadow-sm rounded-pill mx-auto" style="font-size:11px; display:inline-block;">🔒 Pesan disimulasikan & dicatat di laravel.log</div>
                <div class="bg-white rounded-3 shadow-sm p-3" style="max-width:90%; border-top-left-radius:0 !important;">
                    <span class="text-secondary fw-semibold d-block mb-1" style="font-size:11px;">Ke: +{{ session('whatsapp_simulated')['phone'] }}</span>
                    <div style="white-space:pre-wrap; font-size:13.5px; line-height:1.5; color:#303030;">{!! e(session('whatsapp_simulated')['message']) !!}</div>
                    <span class="text-muted d-block text-end mt-2" style="font-size:10px;">{{ now()->format('H:i') }} <i class="fa fa-check-double text-primary ms-1"></i></span>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-3 d-flex justify-content-between">
                <span class="text-muted small"><i class="fa fa-info-circle text-primary me-1"></i> LOGGED IN storage/logs</span>
                <button class="btn btn-secondary px-4 fw-semibold" style="border-radius:8px;font-size:13px;" onclick="closeWaModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back, {{ auth()->user()->name }} 👋</p>
        </div>
        <div class="page-header-actions">
            <span class="header-date">
                <i class="ti ti-calendar"></i>
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- ── ROW 1: Stat Cards ── --}}
    <div class="stats-grid">

        <div class="stat-card stat-card--primary">
            <div class="stat-card-icon">
                <i class="ti ti-box"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Total Produk</span>
                <h3 class="stat-card-value">{{ number_format($totalProducts) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--accent">
            <div class="stat-card-icon">
                <i class="ti ti-category"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Kategori</span>
                <h3 class="stat-card-value">{{ number_format($totalCategories) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--teal">
            <div class="stat-card-icon">
                <i class="ti ti-users"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Total Users</span>
                <h3 class="stat-card-value">{{ number_format($totalUsers) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--gold">
            <div class="stat-card-icon">
                <i class="ti ti-currency-dollar"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Nilai Katalog</span>
                <h3 class="stat-card-value">Rp {{ number_format($catalogValue, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

    </div>

    {{-- ── RENTAL EXPIRY ALERTS ── --}}
    @php
        $hasAlerts = $expiredRentals->count() > 0 || $expiringSoonRentals->count() > 0;
    @endphp

    @if($hasAlerts)
    <div class="rental-alerts-section mb-4">

        {{-- EXPIRED --}}
        @if($expiredRentals->count() > 0)
        <div class="alert-card alert-card--expired mb-3">
            <div class="alert-card-header">
                <div class="alert-card-icon">
                    <i class="ti ti-alert-octagon"></i>
                </div>
                <div>
                    <h3 class="alert-card-title">Masa Sewa Sudah Habis</h3>
                    <p class="alert-card-subtitle">{{ $expiredRentals->count() }} penyewa perlu diperpanjang atau dinotifikasi</p>
                </div>
                <span class="alert-card-badge alert-badge--expired">{{ $expiredRentals->count() }} Kedaluwarsa</span>
            </div>
            <div class="alert-list">
                @foreach($expiredRentals->take(5) as $rental)
                @php $daysOver = abs($rental->days_remaining); @endphp
                <div class="alert-item alert-item--expired">
                    <div class="alert-item-avatar">
                        {{ strtoupper(substr($rental->name, 0, 1)) }}
                    </div>
                    <div class="alert-item-info">
                        <span class="alert-item-name">{{ $rental->name }}</span>
                        <span class="alert-item-product">{{ $rental->product->name ?? '—' }} · {{ $rental->duration_label }}</span>
                        <span class="alert-item-date">
                            Berakhir: {{ $rental->end_date->format('d M Y') }}
                            &nbsp;·&nbsp;
                            <strong>{{ $daysOver }} hari yang lalu</strong>
                        </span>
                    </div>
                    <div class="alert-item-actions">
                        <form method="POST" action="{{ route('admin.rentals.remind', $rental->id) }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="alert-wa-btn" onclick="return confirm('Kirim pengingat WA ke {{ $rental->name }}?')">
                                <i class="fab fa-whatsapp"></i> Hubungi
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                @if($expiredRentals->count() > 5)
                <div class="alert-more-link">
                    <a href="{{ route('admin.rentals.index') }}">+{{ $expiredRentals->count() - 5 }} lainnya — Lihat semua di kelola sewa</a>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- EXPIRING SOON --}}
        @if($expiringSoonRentals->count() > 0)
        <div class="alert-card alert-card--warning">
            <div class="alert-card-header">
                <div class="alert-card-icon">
                    <i class="ti ti-clock-exclamation"></i>
                </div>
                <div>
                    <h3 class="alert-card-title">Masa Sewa Akan Habis</h3>
                    <p class="alert-card-subtitle">{{ $expiringSoonRentals->count() }} penyewa dengan sisa ≤ 30 hari</p>
                </div>
                <span class="alert-card-badge alert-badge--warning">{{ $expiringSoonRentals->count() }} Segera Habis</span>
            </div>
            <div class="alert-list">
                @foreach($expiringSoonRentals as $rental)
                <div class="alert-item alert-item--warning">
                    <div class="alert-item-avatar alert-item-avatar--warning">
                        {{ strtoupper(substr($rental->name, 0, 1)) }}
                    </div>
                    <div class="alert-item-info">
                        <span class="alert-item-name">{{ $rental->name }}</span>
                        <span class="alert-item-product">{{ $rental->product->name ?? '—' }} · {{ $rental->duration_label }}</span>
                        <span class="alert-item-date">
                            Berakhir: {{ $rental->end_date->format('d M Y') }}
                            &nbsp;·&nbsp;
                            @if($rental->days_remaining === 0)
                                <strong style="color:#dc2626;">Hari ini!</strong>
                            @elseif($rental->days_remaining === 1)
                                <strong style="color:#ea580c;">Besok</strong>
                            @else
                                <strong>{{ $rental->days_remaining }} hari lagi</strong>
                            @endif
                        </span>
                    </div>
                    <div class="alert-item-meta">
                        @if($rental->days_remaining === 0)
                            <span class="alert-urgency alert-urgency--critical">Hari Ini</span>
                        @elseif($rental->days_remaining <= 3)
                            <span class="alert-urgency alert-urgency--high">Mendesak</span>
                        @elseif($rental->days_remaining <= 14)
                            <span class="alert-urgency alert-urgency--medium">Segera</span>
                        @else
                            <span class="alert-urgency alert-urgency--low">Perlu Perhatian</span>
                        @endif
                    </div>
                    <div class="alert-item-actions">
                        <form method="POST" action="{{ route('admin.rentals.remind', $rental->id) }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="alert-wa-btn alert-wa-btn--warning" onclick="return confirm('Kirim pengingat WA ke {{ $rental->name }}?')">
                                <i class="fab fa-whatsapp"></i> Ingatkan
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <style>
        /* ── Rental Alert Section ───────────────────────── */
        .rental-alerts-section { }

        .alert-card {
            border-radius: var(--radius-lg, 14px);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .alert-card--expired {
            border: 1.5px solid #fecaca;
            background: white;
        }
        .alert-card--warning {
            border: 1.5px solid #fed7aa;
            background: white;
        }

        /* Header */
        .alert-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
        }
        .alert-card--expired .alert-card-header { background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%); }
        .alert-card--warning .alert-card-header { background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); }

        .alert-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .alert-card--expired .alert-card-icon { background: #fee2e2; color: #dc2626; }
        .alert-card--warning .alert-card-icon { background: #fef3c7; color: #d97706; }

        .alert-card-title {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 2px 0;
        }
        .alert-card--expired .alert-card-title { color: #991b1b; }
        .alert-card--warning .alert-card-title { color: #92400e; }

        .alert-card-subtitle {
            font-size: 12.5px;
            margin: 0;
            color: #6b7280;
        }
        .alert-card-badge {
            margin-left: auto;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .alert-badge--expired { background: #fee2e2; color: #dc2626; }
        .alert-badge--warning { background: #fef3c7; color: #b45309; }

        /* List */
        .alert-list { padding: 8px 0; }

        .alert-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 24px;
            border-bottom: 1px solid #f8fafc;
            transition: background 0.15s;
        }
        .alert-item:last-child { border-bottom: none; }
        .alert-item:hover { background: #fafafa; }

        /* Avatar */
        .alert-item-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            flex-shrink: 0;
            color: white;
            background: #dc2626;
        }
        .alert-item-avatar--warning { background: #d97706; }

        /* Info */
        .alert-item-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }
        .alert-item-name {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .alert-item-product {
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .alert-item-date {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Urgency badge */
        .alert-item-meta { flex-shrink: 0; }
        .alert-urgency {
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }
        .alert-urgency--critical { background: #fee2e2; color: #dc2626; }
        .alert-urgency--high     { background: #ffedd5; color: #ea580c; }
        .alert-urgency--medium   { background: #fef3c7; color: #b45309; }
        .alert-urgency--low      { background: #fefce8; color: #ca8a04; }

        /* WA Button */
        .alert-item-actions { flex-shrink: 0; }
        .alert-wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            transition: all 0.2s;
        }
        .alert-wa-btn:hover {
            background: #16a34a;
            color: white;
            border-color: #16a34a;
            transform: translateY(-1px);
        }
        .alert-wa-btn--warning {
            background: #fef3c7;
            color: #b45309;
            border-color: #fde68a;
        }
        .alert-wa-btn--warning:hover {
            background: #f59e0b;
            color: white;
            border-color: #f59e0b;
        }

        /* "More" link */
        .alert-more-link {
            padding: 10px 24px;
            text-align: center;
        }
        .alert-more-link a {
            font-size: 12.5px;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
        }
        .alert-more-link a:hover { color: #0a2540; text-decoration: underline; }
    </style>
    @endif



    {{-- ── ROW 2: Charts ── --}}
    <div class="charts-grid">

        {{-- Monthly Products Chart --}}
        <div class="admin-card chart-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-chart-bar"></i>
                    Produk per Bulan
                </h3>
                <span class="admin-card-badge">{{ date('Y') }}</span>
            </div>
            <div class="admin-card-body">
                <div id="monthlyChart"></div>
            </div>
        </div>

        {{-- Category Distribution --}}
        <div class="admin-card chart-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-chart-donut-3"></i>
                    Distribusi Kategori
                </h3>
                <span class="admin-card-badge">{{ $categoryBreakdown->count() }} Kategori</span>
            </div>
            <div class="admin-card-body">
                @if($categoryBreakdown->count() > 0)
                    <div id="categoryChart"></div>
                    <div class="category-legend">
                        @foreach($categoryBreakdown as $cat)
                        <div class="legend-item">
                            <span class="legend-dot" style="background: {{ ['#0a2540','#2c6b9e','#4a90c4','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#ec4899'][$loop->index % 8] }}"></span>
                            <span class="legend-name">{{ $cat->name }}</span>
                            <span class="legend-count">{{ $cat->products_count }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-chart">
                        <i class="ti ti-chart-pie-off"></i>
                        <p>Belum ada kategori</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

        {{-- ── TABEL MASA SEWA AKAN HABIS ── --}}
    @php
        $allExpiringRentals = \App\Models\Rental::where('status', 'approved')
            ->with(['product', 'user'])
            ->get()
            ->sortBy('days_remaining')
            ->values();
    @endphp

    @if($allExpiringRentals->count() > 0)
    <div class="admin-card mb-4 border-0 shadow-sm" style="border-radius: var(--radius-lg, 14px); overflow: hidden;">
        <div class="admin-card-header d-flex align-items-center justify-content-between" style="background: var(--off-white, #f8fafc); border-bottom: 1.5px solid #f1f5f9; padding: 18px 24px;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:40px;height:40px;border-radius:10px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:20px;">
                    <i class="ti ti-calendar-time"></i>
                </div>
                <div>
                    <h3 class="admin-card-title mb-0" style="font-size:15px;">Monitor Masa Sewa Aktif</h3>
                    <p class="text-muted mb-0" style="font-size:12.5px;">{{ $allExpiringRentals->count() }} penyewa aktif · diurutkan berdasarkan sisa hari</p>
                </div>
            </div>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;border-radius:8px;font-size:12.5px;font-weight:600;padding:6px 14px;text-decoration:none;">
                <i class="ti ti-external-link me-1"></i> Kelola Sewa
            </a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle" style="font-size:13.5px;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9; background: #fafafa;">
                        <th class="ps-4 py-3 text-muted" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;width:40px;">#</th>
                        <th class="py-3 text-muted" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Penyewa</th>
                        <th class="py-3 text-muted" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Produk</th>
                        <th class="py-3 text-muted" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Durasi</th>
                        <th class="py-3 text-muted" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Mulai</th>
                        <th class="py-3 text-muted" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Berakhir</th>
                        <th class="py-3 text-muted text-center" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Sisa / Status</th>
                        <th class="py-3 pe-4 text-muted text-center" style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allExpiringRentals as $i => $rental)
                    @php
                        $days = $rental->days_remaining;
                        if ($days < 0) {
                            $urgencyClass = 'urgency-expired';
                            $urgencyText  = 'Kedaluwarsa';
                            $sisaText     = abs($days) . ' hari lalu';
                            $sisaColor    = '#dc2626';
                        } elseif ($days === 0) {
                            $urgencyClass = 'urgency-critical';
                            $urgencyText  = 'Hari Ini!';
                            $sisaText     = 'Hari ini';
                            $sisaColor    = '#dc2626';
                        } elseif ($days <= 3) {
                            $urgencyClass = 'urgency-high';
                            $urgencyText  = 'Mendesak';
                            $sisaText     = $days . ' hari';
                            $sisaColor    = '#ea580c';
                        } elseif ($days <= 14) {
                            $urgencyClass = 'urgency-medium';
                            $urgencyText  = 'Segera';
                            $sisaText     = $days . ' hari';
                            $sisaColor    = '#b45309';
                        } elseif ($days <= 30) {
                            $urgencyClass = 'urgency-low';
                            $urgencyText  = 'Perlu Perhatian';
                            $sisaText     = $days . ' hari';
                            $sisaColor    = '#ca8a04';
                        } else {
                            $urgencyClass = 'urgency-ok';
                            $urgencyText  = 'Aman';
                            $sisaText     = $days . ' hari';
                            $sisaColor    = '#16a34a';
                        }
                    @endphp
                    <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''">
                        <td class="ps-4 text-muted" style="font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#0a2540,#1e4d7b);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                                    {{ strtoupper(substr($rental->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="color:#111827;font-size:13.5px;">{{ $rental->name }}</div>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $rental->whatsapp_number) }}" target="_blank" style="font-size:11.5px;color:#16a34a;text-decoration:none;font-weight:500;">
                                        <i class="fab fa-whatsapp"></i> {{ $rental->whatsapp_number }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-semibold" style="color:#1d4ed8;font-size:13px;">{{ $rental->product->name ?? '—' }}</span>
                        </td>
                        <td>
                            <span style="color:#374151;font-size:13px;">{{ $rental->duration_label }}</span>
                        </td>
                        <td>
                            <span style="color:#6b7280;font-size:12.5px;">{{ $rental->start_date->format('d M Y') }}</span>
                        </td>
                        <td>
                            <span style="color:#374151;font-weight:600;font-size:12.5px;">{{ $rental->end_date->format('d M Y') }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <span style="font-weight:700;font-size:13px;color:{{ $sisaColor }};">{{ $sisaText }}</span>
                                <span class="expiry-badge expiry-badge--{{ $urgencyClass }}">{{ $urgencyText }}</span>
                            </div>
                        </td>
                        <td class="pe-4 text-center">
                            <form method="POST" action="{{ route('admin.rentals.remind', $rental->id) }}" style="margin:0;">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm d-inline-flex align-items-center gap-1"
                                        style="background:#f0fdf4;color:#15803d;border:1.5px solid #86efac;border-radius:8px;font-size:12px;font-weight:600;padding:5px 12px;transition:all .2s;"
                                        onmouseover="this.style.background='#16a34a';this.style.color='white';"
                                        onmouseout="this.style.background='#f0fdf4';this.style.color='#15803d';"
                                        onclick="return confirm('Kirim pengingat WA ke {{ $rental->name }}?')">
                                    <i class="fab fa-whatsapp"></i> Ingatkan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .expiry-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
        }
        .expiry-badge--urgency-expired  { background: #fee2e2; color: #dc2626; }
        .expiry-badge--urgency-critical { background: #fee2e2; color: #dc2626; }
        .expiry-badge--urgency-high     { background: #ffedd5; color: #ea580c; }
        .expiry-badge--urgency-medium   { background: #fef3c7; color: #b45309; }
        .expiry-badge--urgency-low      { background: #fefce8; color: #ca8a04; }
        .expiry-badge--urgency-ok       { background: #dcfce7; color: #16a34a; }
    </style>
    @endif

    {{-- ── ROW 3: Lists ── --}}
    <div class="lists-grid">

        {{-- Top Products --}}
        <div class="admin-card list-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-trending-up"></i>
                    Produk Termahal
                </h3>
                <a href="{{ route('products.index') }}" class="admin-card-link">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <ul class="admin-list">
                    @forelse($topProducts as $product)
                    <li class="admin-list-item">
                        <div class="admin-list-img">
                            @if($product->display_image)
                                <img src="{{ asset('storage/' . $product->display_image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="img-placeholder">
                                    <i class="ti ti-package"></i>
                                </div>
                            @endif
                        </div>
                        <div class="admin-list-info">
                            <p class="admin-list-name">{{ $product->name }}</p>
                            <span class="admin-list-meta">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="admin-list-value">
                            Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                        </div>
                    </li>
                    @empty
                    <li class="admin-list-empty">
                        <i class="ti ti-package-off"></i>
                        <span>Belum ada produk</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Low Price Products --}}
        <div class="admin-card list-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-tag"></i>
                    Produk Termurah
                </h3>
                <a href="{{ route('products.index') }}" class="admin-card-link">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <ul class="admin-list">
                    @forelse($lowPriceProducts as $product)
                    <li class="admin-list-item">
                        <div class="admin-list-img">
                            @if($product->display_image)
                                <img src="{{ asset('storage/' . $product->display_image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="img-placeholder">
                                    <i class="ti ti-package"></i>
                                </div>
                            @endif
                        </div>
                        <div class="admin-list-info">
                            <p class="admin-list-name">{{ $product->name }}</p>
                            <span class="admin-list-meta">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="admin-list-value admin-list-value--low">
                            Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                        </div>
                    </li>
                    @empty
                    <li class="admin-list-empty">
                        <i class="ti ti-package-off"></i>
                        <span>Belum ada produk</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Recent Products --}}
        <div class="admin-card list-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-clock"></i>
                    Produk Terbaru
                </h3>
                <a href="{{ route('products.index') }}" class="admin-card-link">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <ul class="admin-list">
                    @forelse($recentProducts as $product)
                    <li class="admin-list-item">
                        <div class="admin-list-img">
                            @if($product->display_image)
                                <img src="{{ asset('storage/' . $product->display_image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="img-placeholder">
                                    <i class="ti ti-package"></i>
                                </div>
                            @endif
                        </div>
                        <div class="admin-list-info">
                            <p class="admin-list-name">{{ $product->name }}</p>
                            <span class="admin-list-meta">{{ $product->created_at->diffForHumans() }}</span>
                        </div>
                        <span class="admin-list-badge">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </li>
                    @empty
                    <li class="admin-list-empty">
                        <i class="ti ti-package-off"></i>
                        <span>Belum ada produk</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <footer class="admin-footer">
        <p>Copyright &copy; {{ date('Y') }} <strong>Nepertech</strong> — BLUD SMKN 1 Cirebon</p>
    </footer>

@endsection

@push('scripts')
<script>
    // ── Monthly Products Bar Chart ──
    var monthlyOptions = {
        series: [{
            name: 'Products Added',
            data: @json($monthlyProducts)
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#0a2540'],
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '50%',
                distributed: false,
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: 'vertical',
                shadeIntensity: 0.3,
                gradientToColors: ['#2c6b9e'],
                opacityFrom: 1,
                opacityTo: 0.85,
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            labels: {
                style: { fontSize: '11px', fontFamily: 'Inter, sans-serif', colors: '#94a3b8' }
            },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                style: { fontSize: '11px', fontFamily: 'Inter, sans-serif', colors: '#94a3b8' },
                formatter: val => Math.round(val)
            }
        },
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4,
            padding: { left: 8, right: 8 }
        },
        tooltip: {
            theme: 'dark',
            style: { fontFamily: 'Inter, sans-serif' },
            y: { formatter: val => val + ' produk' }
        }
    };
    new ApexCharts(document.querySelector("#monthlyChart"), monthlyOptions).render();

    // ── Category Donut Chart ──
    @if($categoryBreakdown->count() > 0)
    var catOptions = {
        series: @json($categoryBreakdown->pluck('products_count')->values()),
        labels: @json($categoryBreakdown->pluck('name')->values()),
        chart: {
            type: 'donut',
            height: 260,
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#0a2540','#2c6b9e','#4a90c4','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#ec4899'],
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        name: { fontSize: '13px', fontWeight: 600 },
                        value: { fontSize: '20px', fontWeight: 700, color: '#0a2540' },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '12px',
                            color: '#94a3b8',
                            formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: { width: 3, colors: ['#fff'] },
        tooltip: {
            style: { fontFamily: 'Inter, sans-serif' },
            y: { formatter: val => val + ' produk' }
        }
    };
    new ApexCharts(document.querySelector("#categoryChart"), catOptions).render();
    @endif

    // ── WA Simulation Modal ──
    const simulatedWaModal = document.getElementById('waSimulationModal');
    if (simulatedWaModal && typeof bootstrap !== 'undefined') {
        new bootstrap.Modal(simulatedWaModal).show();
    }

    // ── Auto-dismiss toast ──
    const dashToast = document.getElementById('dashToast');
    if (dashToast) setTimeout(() => dashToast.remove(), 6000);
</script>

<style>
@keyframes slideInRight {
    from { transform: translateX(120%); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
}
</style>

<script>
    function closeWaModal() {
        const el = document.getElementById('waSimulationModal');
        if (el) {
            el.remove();
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            document.body.style.overflow = '';
        }
    }
</script>
@endpush