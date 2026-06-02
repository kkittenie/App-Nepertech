@extends('layouts.admin')

@section('title', 'Kelola Penyewaan')

@section('content')

@if(session('success'))
<div class="toast-alert toast-success" id="toastAlert">
    <div class="toast-icon"><i class="ti ti-check"></i></div>
    <span>{{ session('success') }}</span>
    <button class="toast-close" onclick="dismissToast()"><i class="ti ti-x"></i></button>
</div>
@endif

@if(session('error'))
<div class="toast-alert toast-error" id="toastAlert">
    <div class="toast-icon"><i class="ti ti-alert-circle"></i></div>
    <span>{{ session('error') }}</span>
    <button class="toast-close" onclick="dismissToast()"><i class="ti ti-x"></i></button>
</div>
@endif

{{-- ── WHATSAPP SIMULATION PREVIEW MODAL ── --}}
@if(session('whatsapp_simulated'))
<div class="modal fade show" id="waSimulationModal" tabindex="-1" style="display: block; background: rgba(10, 37, 64, 0.45); backdrop-filter: blur(8px); z-index: 1050;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-md); overflow: hidden;">
            <div class="d-flex align-items-center justify-content-between p-3 text-white" style="background: linear-gradient(135deg, #075e54 0%, #128c7e 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="wa-chat-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; font-weight: bold; border: 1.5px solid rgba(255, 255, 255, 0.4);">NP</div>
                    <div>
                        <h6 class="mb-0 fw-bold">Nepertech WA Gateway</h6>
                        <small class="text-white-50" style="font-size: 11px;"><i class="fa fa-circle text-success me-1" style="font-size: 9px;"></i> Simulasi Aktif (Fonnte API)</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="closeWaModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #efeae2; background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); background-size: contain; min-height: 380px; max-height: 480px; overflow-y: auto;">
                <div class="d-flex flex-column align-items-start">
                    <div class="align-self-center text-center py-1 px-3 mb-3 bg-white text-muted shadow-sm rounded-pill" style="font-size: 11px; border: 1px solid rgba(0,0,0,0.05);">
                        🔒 Pesan ini disimulasikan & dicatat di laravel.log
                    </div>
                    <div class="bg-white rounded-3 shadow-sm p-3 mb-2 border-0" style="max-width: 85%; align-self: flex-start; border-top-left-radius: 0px !important; position: relative;">
                        <span class="text-secondary fw-semibold d-block mb-1" style="font-size: 11px;">Ke: +{{ session('whatsapp_simulated')['phone'] }}</span>
                        <div class="wa-message-text" style="white-space: pre-wrap; font-size: 13.5px; line-height: 1.5; color: #303030;">{!! e(session('whatsapp_simulated')['message']) !!}</div>
                        <span class="text-muted d-block text-end mt-2" style="font-size: 10px;">{{ now()->format('H:i') }} <i class="fa fa-check-double text-primary ms-1" style="font-size: 11px;"></i></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-3 d-flex justify-content-between">
                <span class="text-muted small" style="font-size: 12px;"><i class="fa fa-info-circle text-primary me-1"></i> LOGGED IN `storage/logs`</span>
                <button type="button" class="btn btn-secondary px-4 fw-semibold" style="border-radius: 8px; font-size: 13px;" onclick="closeWaModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title">Penyewaan Produk</h1>
            <p class="page-subtitle">Kelola pengajuan sewa produk digital & notifikasi otomatis client</p>
        </div>
        <div class="page-header-actions">
            <span class="header-date">
                <i class="ti ti-calendar"></i>
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- Top Stats Cards --}}
    @php
        $pendingCount   = $pendingRentals->count();
        $awaitingCount  = $awaitingRentals->count();
        $submittedCount = $submittedRentals->count();
        $completedCount = $completedRentals->count();
        $rejectedCount  = $rejectedRentals->count();
        $totalEarnings  = $completedRentals->sum('total_price');
        $totalRequests  = $pendingCount + $awaitingCount + $submittedCount + $completedCount + $rejectedCount;
    @endphp
    <div class="stats-grid mb-4">
        <div class="stat-card stat-card--primary">
            <div class="stat-card-icon" style="background: rgba(10,37,64,0.08); color: var(--primary);">
                <i class="ti ti-history"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Total Pengajuan</span>
                <h3 class="stat-card-value">{{ number_format($totalRequests) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--gold">
            <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: var(--gold);">
                <i class="ti ti-loader"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Menunggu Review</span>
                <h3 class="stat-card-value">{{ number_format($pendingCount) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--teal">
            <div class="stat-card-icon" style="background: rgba(20,184,166,0.1); color: var(--teal);">
                <i class="ti ti-circle-check"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Sewa Selesai</span>
                <h3 class="stat-card-value">{{ number_format($completedCount) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--accent">
            <div class="stat-card-icon" style="background: rgba(44,107,158,0.1); color: var(--accent);">
                <i class="ti ti-currency-dollar"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Total Omset Sewa</span>
                <h3 class="stat-card-value">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>
    </div>

    {{-- Main Content Section --}}
    <div class="card main-card border-0 shadow-sm" style="border-radius: var(--radius-lg); background: white;">
        {{-- Custom Navigation Tabs --}}
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: var(--off-white);">
            <div class="filter-tabs m-0">
                <button class="filter-tab active" data-tab="tab-pending">
                    <i class="ti ti-clock me-1"></i> Pending
                    <span class="tab-count">{{ $pendingCount }}</span>
                </button>
                <button class="filter-tab" data-tab="tab-awaiting">
                    <i class="ti ti-credit-card me-1"></i> Menunggu Bayar
                    <span class="tab-count">{{ $awaitingCount }}</span>
                </button>
                <button class="filter-tab" data-tab="tab-submitted">
                    <i class="ti ti-file-upload me-1"></i> Bukti Masuk
                    @if($submittedCount > 0)
                    <span class="tab-count" style="background: #dc2626; color: white;">{{ $submittedCount }}</span>
                    @else
                    <span class="tab-count">0</span>
                    @endif
                </button>
                <button class="filter-tab" data-tab="tab-completed">
                    <i class="ti ti-circle-check me-1"></i> Selesai
                    <span class="tab-count">{{ $completedCount }}</span>
                </button>
                <button class="filter-tab" data-tab="tab-rejected">
                    <i class="ti ti-circle-x me-1"></i> Ditolak
                    <span class="tab-count">{{ $rejectedCount }}</span>
                </button>
            </div>
            <span class="text-muted small fw-semibold"><i class="fa fa-info-circle me-1 text-accent"></i> Klik tab untuk menyaring</span>
        </div>

        {{-- ── TAB 1: PENDING ── --}}
        <div class="tab-content" id="tab-pending">
            @if($pendingRentals->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Penyewa / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Durasi &amp; Mulai</th>
                                <th class="py-3 text-muted small uppercase">Total Biaya</th>
                                <th class="py-3 text-muted small uppercase text-center" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingRentals as $index => $rental)
                                <tr class="rental-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $rental->name }}</span>
                                            <span class="text-muted small mb-1">{{ $rental->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $rental->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $rental->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($rental->product->display_image)
                                                    <img src="{{ asset('storage/' . $rental->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $rental->product->name }}</span>
                                                <span class="badge bg-primary-subtle text-primary align-self-start mt-1" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:6px;">{{ $rental->product->category->name ?? 'Default' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark" style="font-size:13.5px;"><i class="ti ti-calendar-event text-accent"></i> {{ $rental->duration_label }}</span>
                                            <span class="text-muted small mt-1">Mulai: {{ $rental->start_date->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 btn-action-trigger"
                                                    style="border-radius: 8px; padding: 6px 12px; font-weight: 600; font-size: 12.5px; background: #16a34a; border: none;"
                                                    data-action="approve"
                                                    data-id="{{ $rental->id }}"
                                                    data-name="{{ $rental->name }}"
                                                    data-product="{{ $rental->product->name }}">
                                                <i class="ti ti-circle-check"></i> Setujui
                                            </button>
                                            <button class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 btn-action-trigger"
                                                    style="border-radius: 8px; padding: 6px 12px; font-weight: 600; font-size: 12.5px; background: #dc2626; border: none;"
                                                    data-action="reject"
                                                    data-id="{{ $rental->id }}"
                                                    data-name="{{ $rental->name }}"
                                                    data-product="{{ $rental->product->name }}">
                                                <i class="ti ti-circle-x"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state py-5 text-center">
                    <div class="empty-icon bg-light rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-clipboard-list text-muted" style="font-size:36px;"></i>
                    </div>
                    <h5 class="fw-semibold text-primary">Tidak Ada Pengajuan Masuk</h5>
                    <p class="text-muted small">Saat ini belum ada pengajuan rental yang berstatus pending.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 2: AWAITING PAYMENT ── --}}
        <div class="tab-content d-none" id="tab-awaiting">
            @if($awaitingRentals->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Penyewa / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Durasi &amp; Mulai</th>
                                <th class="py-3 text-muted small uppercase">Total Biaya</th>
                                <th class="py-3 text-muted small uppercase">Link Pembayaran</th>
                                <th class="py-3 text-muted small uppercase text-center" style="width: 100px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($awaitingRentals as $index => $rental)
                                <tr class="rental-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $rental->name }}</span>
                                            <span class="text-muted small mb-1">{{ $rental->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $rental->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $rental->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($rental->product->display_image)
                                                    <img src="{{ asset('storage/' . $rental->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $rental->product->name }}</span>
                                                <span class="badge bg-primary-subtle text-primary align-self-start mt-1" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:6px;">{{ $rental->product->category->name ?? 'Default' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark" style="font-size:13.5px;"><i class="ti ti-calendar text-accent"></i> {{ $rental->duration_label }}</span>
                                            <span class="text-muted small mt-1">Mulai: {{ $rental->start_date->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('rental.payment', $rental->payment_token) }}" target="_blank" class="d-inline-flex align-items-center gap-1 small fw-semibold text-primary" style="text-decoration:none; font-size:12.5px;">
                                            <i class="ti ti-external-link"></i> Buka Halaman
                                        </a>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <span class="badge px-3 py-2 fw-semibold" style="font-size:11.5px; border-radius:30px; background:#fef3c7; color:#b45309;">
                                            <i class="ti ti-clock"></i> Menunggu
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state py-5 text-center">
                    <div class="empty-icon bg-light rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-credit-card text-muted" style="font-size:36px;"></i>
                    </div>
                    <h5 class="fw-semibold text-primary">Tidak Ada Menunggu Pembayaran</h5>
                    <p class="text-muted small">Pengajuan yang sudah disetujui dan menunggu pembayaran akan tampil di sini.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 3: PAYMENT SUBMITTED (Bukti Masuk) ── --}}
        <div class="tab-content d-none" id="tab-submitted">
            @if($submittedRentals->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Penyewa / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Durasi</th>
                                <th class="py-3 text-muted small uppercase">Total Biaya</th>
                                <th class="py-3 text-muted small uppercase">Bukti Bayar</th>
                                <th class="py-3 text-muted small uppercase text-center" style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submittedRentals as $index => $rental)
                                <tr class="rental-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $rental->name }}</span>
                                            <span class="text-muted small mb-1">{{ $rental->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $rental->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $rental->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($rental->product->display_image)
                                                    <img src="{{ asset('storage/' . $rental->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $rental->product->name }}</span>
                                                <span class="badge bg-primary-subtle text-primary align-self-start mt-1" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:6px;">{{ $rental->product->category->name ?? 'Default' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark" style="font-size:13.5px;">{{ $rental->duration_label }}</span>
                                            <span class="text-muted small mt-1">Mulai: {{ $rental->start_date->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @if($rental->payment_receipt)
                                            <a href="{{ asset('storage/' . $rental->payment_receipt) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $rental->payment_receipt) }}"
                                                     alt="Bukti"
                                                     style="width: 54px; height: 54px; object-fit: cover; border-radius: 8px; border: 1.5px solid #e2e8f0; cursor: pointer; transition: transform .2s;"
                                                     onmouseover="this.style.transform='scale(1.1)'"
                                                     onmouseout="this.style.transform='scale(1)'">
                                            </a>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center">
                                        <button class="btn btn-sm d-inline-flex align-items-center gap-1 btn-approve-payment-trigger"
                                                style="border-radius: 8px; padding: 6px 12px; font-weight: 600; font-size: 12.5px; background: #16a34a; border: none; color: white;"
                                                data-id="{{ $rental->id }}"
                                                data-name="{{ $rental->name }}"
                                                data-product="{{ $rental->product->name }}">
                                            <i class="ti ti-circle-check"></i> Konfirmasi
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state py-5 text-center">
                    <div class="empty-icon bg-light rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-file-upload text-muted" style="font-size:36px;"></i>
                    </div>
                    <h5 class="fw-semibold text-primary">Belum Ada Bukti Pembayaran</h5>
                    <p class="text-muted small">Bukti pembayaran yang dikirim penyewa akan tampil di sini untuk dikonfirmasi.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 4: COMPLETED ── --}}
        <div class="tab-content d-none" id="tab-completed">
            @if($completedRentals->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Penyewa / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Masa Sewa</th>
                                <th class="py-3 text-muted small uppercase">Total Biaya</th>
                                <th class="py-3 text-muted small uppercase text-center" style="width: 120px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedRentals as $index => $rental)
                                <tr class="rental-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $rental->name }}</span>
                                            <span class="text-muted small mb-1">{{ $rental->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $rental->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $rental->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($rental->product->display_image)
                                                    <img src="{{ asset('storage/' . $rental->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $rental->product->name }}</span>
                                                <span class="badge bg-primary-subtle text-primary align-self-start mt-1" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:6px;">{{ $rental->product->category->name ?? 'Default' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark" style="font-size:13.5px;"><i class="ti ti-calendar text-teal"></i> {{ $rental->duration_label }}</span>
                                            <span class="text-muted small mt-1">{{ $rental->start_date->format('d M Y') }} — {{ $rental->end_date->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                                    </td>
                                     <td class="pe-4 text-center">
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <span class="badge bg-success-subtle text-success px-3 py-2 fw-semibold" style="font-size:11.5px; border-radius:30px;"><i class="ti ti-circle-check"></i> Lunas</span>
                                        </div>
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state py-5 text-center">
                    <div class="empty-icon bg-light rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-circle-check text-muted" style="font-size:36px;"></i>
                    </div>
                    <h5 class="fw-semibold text-primary">Belum Ada Sewa Selesai</h5>
                    <p class="text-muted small">Transaksi sewa yang sudah lunas akan terekam di sini.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 5: REJECTED ── --}}
        <div class="tab-content d-none" id="tab-rejected">
            @if($rejectedRentals->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Penyewa / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Durasi Rencana</th>
                                <th class="py-3 text-muted small uppercase">Estimasi Biaya</th>
                                <th class="py-3 text-muted small uppercase">Catatan Penolakan</th>
                                <th class="py-3 text-muted small uppercase text-center" style="width: 100px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedRentals as $index => $rental)
                                <tr class="rental-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $rental->name }}</span>
                                            <span class="text-muted small mb-1">{{ $rental->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $rental->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $rental->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($rental->product->display_image)
                                                    <img src="{{ asset('storage/' . $rental->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $rental->product->name }}</span>
                                                <span class="badge bg-primary-subtle text-primary align-self-start mt-1" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:6px;">{{ $rental->product->category->name ?? 'Default' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark" style="font-size:13.5px;"><i class="ti ti-calendar text-danger"></i> {{ $rental->duration_label }}</span>
                                            <span class="text-muted small mt-1">Mulai Rencana: {{ $rental->start_date->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-muted small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $rental->admin_notes }}">
                                        {{ $rental->admin_notes ?? '—' }}
                                    </td>
                                    <td class="pe-4 text-center">
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 fw-semibold" style="font-size:11.5px; border-radius:30px;"><i class="ti ti-circle-x"></i> Ditolak</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state py-5 text-center">
                    <div class="empty-icon bg-light rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-circle-x text-muted" style="font-size:36px;"></i>
                    </div>
                    <h5 class="fw-semibold text-primary">Tidak Ada Pengajuan Ditolak</h5>
                    <p class="text-muted small">Pengajuan sewa yang Anda tolak akan terekam dalam arsip ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ── INTERACTIVE REVIEW MODAL (APPROVE / REJECT) ── --}}
<div class="modal fade" id="reviewRentalModal" tabindex="-1" aria-hidden="true" style="background: rgba(10,37,64,0.4); backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-md);">
            <div class="modal-header border-bottom py-3 px-4" style="background: var(--off-white);">
                <div class="d-flex align-items-center gap-2">
                    <div class="modal-action-icon-wrap rounded bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ti ti-license" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold" id="reviewModalTitle" style="color: var(--primary); font-size: 16px;">Tinjau Pengajuan Sewa</h5>
                        <small class="text-muted" id="reviewModalSubtitle">Penyewa: John Doe</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="POST" id="reviewRentalForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-3 border">
                        <i class="ti ti-box text-accent" style="font-size: 28px;"></i>
                        <div>
                            <span class="text-muted small d-block">Produk yang Diajukan</span>
                            <span class="fw-bold text-dark" id="modalProductName" style="font-size: 14.5px;">Product Name</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="adminNotes" class="form-label" id="notesLabel">Catatan Admin / WhatsApp Note</label>
                        <textarea class="form-control" name="admin_notes" id="adminNotes" rows="4" placeholder="Tulis catatan di sini..."></textarea>
                        <span class="text-muted small mt-2 d-block" id="modalActionHint" style="font-size: 11.5px; line-height: 1.4;">
                            <i class="fa fa-info-circle text-accent"></i>
                            Pesan WhatsApp notifikasi yang disetujui akan menyertakan catatan ini jika diisi.
                        </span>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-cancel py-2 px-3" data-bs-dismiss="modal" style="height: 38px; line-height: 1;">Batal</button>
                    <button type="submit" class="btn text-white fw-bold py-2 px-4" id="btnSubmitAction" style="height: 38px; line-height: 1; border: none; border-radius: var(--radius-sm);">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── CONFIRM PAYMENT MODAL ── --}}
<div class="modal fade" id="approvePaymentModal" tabindex="-1" aria-hidden="true" style="background: rgba(10,37,64,0.4); backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-md);">
            <div class="modal-header border-bottom py-3 px-4" style="background: var(--off-white);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(22,163,74,0.1);">
                        <i class="ti ti-receipt-2 text-success" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold" style="color: var(--primary); font-size: 16px;">Konfirmasi Pembayaran Sewa</h5>
                        <small class="text-muted" id="approvePaymentSubtitle">Penyewa: —</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3 border" style="background: #f0fdf4; border-color: #86efac !important;">
                    <i class="ti ti-check text-success" style="font-size: 28px;"></i>
                    <div>
                        <span class="text-muted small d-block">Produk</span>
                        <span class="fw-bold text-dark" id="approvePaymentProduct" style="font-size: 14.5px;">Product Name</span>
                    </div>
                </div>
                <p class="text-muted small mb-0">
                    <i class="fab fa-whatsapp text-success me-1"></i>
                    Setelah dikonfirmasi, WA otomatis terkirim ke penyewa berisi notifikasi pembayaran diterima. Admin kemudian mengirim detail akses langsung via WA.
                </p>
            </div>
            <form action="" method="POST" id="approvePaymentForm">
                @csrf
                <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-cancel py-2 px-3" data-bs-dismiss="modal" style="height: 38px; line-height: 1;">Batal</button>
                    <button type="submit" class="btn text-white fw-bold py-2 px-4" style="height: 38px; line-height: 1; border: none; border-radius: var(--radius-sm); background: #16a34a;">
                        <i class="ti ti-check me-1"></i> Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        animateRows();

        // ── Tabs Functionality ──
        const tabs = document.querySelectorAll('.filter-tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.add('d-none'));

                tab.classList.add('active');
                const targetTabId = tab.getAttribute('data-tab');
                document.getElementById(targetTabId).classList.remove('d-none');

                animateRows();
            });
        });

        // ── Review Modal Trigger (Approve / Reject) ──
        const reviewModal = new bootstrap.Modal(document.getElementById('reviewRentalModal'));
        const form = document.getElementById('reviewRentalForm');
        const modalTitle = document.getElementById('reviewModalTitle');
        const modalSubtitle = document.getElementById('reviewModalSubtitle');
        const modalProductName = document.getElementById('modalProductName');
        const adminNotesTextarea = document.getElementById('adminNotes');
        const notesLabel = document.getElementById('notesLabel');
        const modalActionHint = document.getElementById('modalActionHint');
        const btnSubmitAction = document.getElementById('btnSubmitAction');

        document.querySelectorAll('.btn-action-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = btn.dataset.action;
                const id = btn.dataset.id;
                const clientName = btn.dataset.name;
                const productName = btn.dataset.product;

                modalSubtitle.textContent = `Penyewa: ${clientName}`;
                modalProductName.textContent = productName;
                adminNotesTextarea.value = '';

                if (action === 'approve') {
                    modalTitle.textContent = 'Setujui Pengajuan Penyewaan';
                    notesLabel.textContent = 'Catatan untuk Penyewa (Opsional)';
                    adminNotesTextarea.placeholder = 'Tulis catatan tambahan... (Link pembayaran QRIS akan dikirim otomatis via WA)';
                    modalActionHint.innerHTML = '<i class="fab fa-whatsapp text-success me-1"></i> Client akan mendapatkan <strong>Notifikasi WhatsApp</strong> berisi link halaman pembayaran QRIS.';
                    btnSubmitAction.style.background = '#16a34a';
                    btnSubmitAction.textContent = 'Setujui & Kirim Link Bayar';
                    form.action = `/admin/rentals/${id}/approve`;
                } else {
                    modalTitle.textContent = 'Tolak Pengajuan Penyewaan';
                    notesLabel.textContent = 'Alasan Penolakan Pengajuan';
                    adminNotesTextarea.placeholder = 'Tuliskan alasan penolakan dengan sopan dan detail...';
                    modalActionHint.innerHTML = '<i class="fab fa-whatsapp text-danger me-1"></i> Client akan mendapatkan <strong>Notifikasi WhatsApp</strong> berisi detail penolakan dan alasan Anda.';
                    btnSubmitAction.style.background = '#dc2626';
                    btnSubmitAction.textContent = 'Tolak Pengajuan';
                    form.action = `/admin/rentals/${id}/reject`;
                }

                reviewModal.show();
            });
        });

        // ── Approve Payment Modal ──
        const approvePaymentModal = new bootstrap.Modal(document.getElementById('approvePaymentModal'));
        const approvePaymentForm = document.getElementById('approvePaymentForm');
        const approvePaymentSubtitle = document.getElementById('approvePaymentSubtitle');
        const approvePaymentProduct = document.getElementById('approvePaymentProduct');

        document.querySelectorAll('.btn-approve-payment-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const product = btn.dataset.product;

                approvePaymentSubtitle.textContent = `Penyewa: ${name}`;
                approvePaymentProduct.textContent = product;
                approvePaymentForm.action = `/admin/rentals/${id}/approve-payment`;

                approvePaymentModal.show();
            });
        });

        // WhatsApp Simulated Modal auto show
        const simulatedWaModal = document.getElementById('waSimulationModal');
        if (simulatedWaModal) {
            const waModal = new bootstrap.Modal(simulatedWaModal);
            waModal.show();
        }
    });

    function animateRows() {
        document.querySelectorAll('.rental-row').forEach((row, i) => {
            row.classList.remove('fade-in');
            void row.offsetWidth;
            setTimeout(() => row.classList.add('fade-in'), i * 35);
        });
    }

    function dismissToast() {
        const toast = document.getElementById('toastAlert');
        if (!toast) return;
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }

    function closeWaModal() {
        const waModalEl = document.getElementById('waSimulationModal');
        if (waModalEl) {
            waModalEl.remove();
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(b => b.remove());
            document.body.style.overflow = '';
        }
    }

    setTimeout(() => dismissToast(), 5000);
</script>
@endpush
