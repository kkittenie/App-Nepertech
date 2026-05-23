@extends('layouts.admin')

@section('title', 'Kelola Jual Lepas')

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
                    <div class="wa-chat-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; font-weight: bold; border: 1.5px solid rgba(255, 255, 255, 0.4);">
                        NP
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Nepertech WA Gateway</h6>
                        <small class="text-white-50" style="font-size: 11px;"><i class="fa fa-circle text-success me-1" style="font-size: 9px;"></i> Simulasi Aktif (Fonnte API)</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" onclick="closeWaModal()" aria-label="Close"></button>
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

{{-- ── PAYMENT PROOF PREVIEW MODAL ── --}}
<div class="modal fade" id="proofPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-md); overflow: hidden;">
            <div class="modal-header border-bottom py-3 px-4" style="background: var(--off-white);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ti ti-photo" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" style="color: var(--primary); font-size: 16px;">Bukti Pembayaran</h5>
                        <small class="text-muted" id="proofModalSubtitle">Verifikasi bukti transfer dari user</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center" style="background: #f8fafc;">
                <img id="proofPreviewImg" src="" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 500px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1px solid #e2e8f0;">
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-between">
                <a id="proofDownloadLink" href="#" target="_blank" class="btn btn-outline-primary fw-semibold" style="border-radius: 8px; font-size: 13px;">
                    <i class="ti ti-download me-1"></i> Buka di Tab Baru
                </a>
                <button type="button" class="btn btn-secondary px-4 fw-semibold" style="border-radius: 8px; font-size: 13px;" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title">Jual Lepas</h1>
            <p class="page-subtitle">Kelola pengajuan pembelian produk digital (beli penuh) & notifikasi otomatis client</p>
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
        $pendingCount   = $pendingSales->count();
        $awaitingCount  = $awaitingSales->count();
        $submittedCount = $submittedSales->count();
        $completedCount = $completedSales->count();
        $rejectedCount  = $rejectedSales->count();
        $totalRevenue   = $completedSales->sum('total_price');
        $totalRequests  = $pendingCount + $awaitingCount + $submittedCount + $completedCount + $rejectedCount;
    @endphp
    <div class="stats-grid mb-4">
        <div class="stat-card stat-card--primary">
            <div class="stat-card-icon" style="background: rgba(10,37,64,0.08); color: var(--primary);">
                <i class="ti ti-shopping-cart"></i>
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

        <div class="stat-card" style="--stat-color: #7c3aed;">
            <div class="stat-card-icon" style="background: rgba(124,58,237,0.1); color: #7c3aed;">
                <i class="ti ti-file-upload"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Bukti Dikirim</span>
                <h3 class="stat-card-value">{{ number_format($submittedCount) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--accent">
            <div class="stat-card-icon" style="background: rgba(44,107,158,0.1); color: var(--accent);">
                <i class="ti ti-currency-dollar"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Revenue Selesai</span>
                <h3 class="stat-card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
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
                    @if($pendingCount > 0)
                        <span class="tab-count" style="background: #f59e0b; color: white;">{{ $pendingCount }}</span>
                    @else
                        <span class="tab-count">{{ $pendingCount }}</span>
                    @endif
                </button>
                <button class="filter-tab" data-tab="tab-awaiting">
                    <i class="ti ti-credit-card me-1"></i> Menunggu Bayar
                    <span class="tab-count">{{ $awaitingCount }}</span>
                </button>
                <button class="filter-tab" data-tab="tab-submitted">
                    <i class="ti ti-file-upload me-1"></i> Bukti Dikirim
                    @if($submittedCount > 0)
                        <span class="tab-count" style="background: #7c3aed; color: white;">{{ $submittedCount }}</span>
                    @else
                        <span class="tab-count">{{ $submittedCount }}</span>
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
            @if($pendingSales->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Pembeli / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Harga Jual Lepas</th>
                                <th class="py-3 text-muted small uppercase">Catatan Client</th>
                                <th class="py-3 text-muted small uppercase">Tanggal</th>
                                <th class="py-3 text-muted small uppercase text-center" style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingSales as $index => $sale)
                                <tr class="sale-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $sale->name }}</span>
                                            <span class="text-muted small mb-1">{{ $sale->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $sale->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($sale->product->display_image)
                                                    <img src="{{ asset('storage/' . $sale->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $sale->product->name }}</span>
                                                <span class="badge bg-primary-subtle text-primary align-self-start mt-1" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:6px;">{{ $sale->product->category->name ?? 'Default' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-muted small" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $sale->client_notes }}">
                                        {{ $sale->client_notes ?? '—' }}
                                    </td>
                                    <td class="text-muted small">{{ $sale->created_at->format('d M Y') }}</td>
                                    <td class="pe-4 text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 btn-action-trigger"
                                                    style="border-radius: 8px; padding: 6px 12px; font-weight: 600; font-size: 12.5px; background: #16a34a; border: none;"
                                                    data-action="approve"
                                                    data-id="{{ $sale->id }}"
                                                    data-name="{{ $sale->name }}"
                                                    data-product="{{ $sale->product->name }}">
                                                <i class="ti ti-circle-check"></i> Setujui
                                            </button>
                                            <button class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 btn-action-trigger"
                                                    style="border-radius: 8px; padding: 6px 12px; font-weight: 600; font-size: 12.5px; background: #dc2626; border: none;"
                                                    data-action="reject"
                                                    data-id="{{ $sale->id }}"
                                                    data-name="{{ $sale->name }}"
                                                    data-product="{{ $sale->product->name }}">
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
                        <i class="ti ti-shopping-cart text-muted" style="font-size:36px;"></i>
                    </div>
                    <h5 class="fw-semibold text-primary">Tidak Ada Pengajuan Masuk</h5>
                    <p class="text-muted small">Saat ini belum ada pengajuan pembelian yang berstatus pending.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 2: MENUNGGU PEMBAYARAN ── --}}
        <div class="tab-content d-none" id="tab-awaiting">
            @if($awaitingSales->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Pembeli / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Total</th>
                                <th class="py-3 text-muted small uppercase">Link Pembayaran</th>
                                <th class="py-3 text-muted small uppercase">Disetujui</th>
                                <th class="py-3 text-muted small uppercase text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($awaitingSales as $index => $sale)
                                <tr class="sale-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $sale->name }}</span>
                                            <span class="text-muted small mb-1">{{ $sale->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $sale->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($sale->product->display_image)
                                                    <img src="{{ asset('storage/' . $sale->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $sale->product->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('sale.payment', $sale->payment_token) }}" target="_blank" class="btn btn-sm d-inline-flex align-items-center gap-1" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 8px; padding: 5px 10px; font-size: 12px; font-weight: 600; text-decoration:none;">
                                            <i class="ti ti-external-link" style="font-size:13px;"></i> Lihat Halaman
                                        </a>
                                    </td>
                                    <td class="text-muted small">{{ $sale->updated_at->format('d M Y') }}</td>
                                    <td class="pe-4 text-center">
                                        <span class="badge px-3 py-2 fw-semibold" style="font-size:11.5px; border-radius:30px; background:#fef3c7; color:#b45309;">
                                            <i class="ti ti-clock me-1"></i> Menunggu Bayar
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
                    <h5 class="fw-semibold text-primary">Tidak Ada yang Menunggu Pembayaran</h5>
                    <p class="text-muted small">Pengajuan yang sudah disetujui dan menunggu pembayaran akan muncul di sini.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 3: BUKTI DIKIRIM (payment_submitted) ── --}}
        <div class="tab-content d-none" id="tab-submitted">
            @if($submittedSales->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Pembeli / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Total</th>
                                <th class="py-3 text-muted small uppercase text-center">Bukti Bayar</th>
                                <th class="py-3 text-muted small uppercase">Dikirim Pada</th>
                                <th class="py-3 text-muted small uppercase text-center" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submittedSales as $index => $sale)
                                <tr class="sale-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $sale->name }}</span>
                                            <span class="text-muted small mb-1">{{ $sale->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $sale->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($sale->product->display_image)
                                                    <img src="{{ asset('storage/' . $sale->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $sale->product->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($sale->payment_receipt)
                                            <button type="button"
                                                    class="btn-proof-preview"
                                                    data-img="{{ asset('storage/' . $sale->payment_receipt) }}"
                                                    data-name="{{ $sale->name }}"
                                                    style="background: #f0fdf4; border: 1.5px solid #86efac; color: #15803d; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                                                <i class="ti ti-photo" style="font-size:15px;"></i> Lihat Bukti
                                            </button>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $sale->updated_at->format('d M Y · H:i') }}</td>
                                    <td class="pe-4 text-center">
                                        <button class="btn btn-sm d-inline-flex align-items-center gap-1 btn-confirm-payment"
                                                style="border-radius: 8px; padding: 7px 14px; font-weight: 600; font-size: 12.5px; background: linear-gradient(135deg, #0a2540 0%, #1a4a75 100%); border: none; color: white;"
                                                data-id="{{ $sale->id }}"
                                                data-name="{{ $sale->name }}"
                                                data-product="{{ $sale->product->name }}"
                                                data-price="Rp {{ number_format($sale->total_price, 0, ',', '.') }}">
                                            <i class="ti ti-shield-check"></i> Konfirmasi Bayar
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
                    <p class="text-muted small">Bukti pembayaran yang dikirim user akan muncul di sini untuk diverifikasi.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 4: SELESAI (completed) ── --}}
        <div class="tab-content d-none" id="tab-completed">
            @if($completedSales->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Pembeli / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Total</th>
                                <th class="py-3 text-muted small uppercase text-center">Bukti Bayar</th>
                                <th class="py-3 text-muted small uppercase">Selesai Pada</th>
                                <th class="py-3 text-muted small uppercase text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedSales as $index => $sale)
                                <tr class="sale-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $sale->name }}</span>
                                            <span class="text-muted small mb-1">{{ $sale->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $sale->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($sale->product->display_image)
                                                    <img src="{{ asset('storage/' . $sale->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $sale->product->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success" style="font-size: 14.5px;">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($sale->payment_receipt)
                                            <button type="button"
                                                    class="btn-proof-preview"
                                                    data-img="{{ asset('storage/' . $sale->payment_receipt) }}"
                                                    data-name="{{ $sale->name }}"
                                                    style="background: #f0fdf4; border: 1.5px solid #86efac; color: #15803d; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                                <i class="ti ti-photo" style="font-size:15px;"></i> Lihat Bukti
                                            </button>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $sale->updated_at->format('d M Y') }}</td>
                                    <td class="pe-4 text-center">
                                        <span class="badge bg-success-subtle text-success px-3 py-2 fw-semibold" style="font-size:11.5px; border-radius:30px;">
                                            <i class="ti ti-circle-check me-1"></i> Selesai
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
                        <i class="ti ti-circle-check text-muted" style="font-size:36px;"></i>
                    </div>
                    <h5 class="fw-semibold text-primary">Belum Ada Transaksi Selesai</h5>
                    <p class="text-muted small">Pembelian yang sudah lunas dan terverifikasi akan tercatat di sini.</p>
                </div>
            @endif
        </div>

        {{-- ── TAB 5: DITOLAK ── --}}
        <div class="tab-content d-none" id="tab-rejected">
            @if($rejectedSales->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-border);">
                                <th class="ps-4 py-3 text-muted small uppercase" style="width: 50px;">#</th>
                                <th class="py-3 text-muted small uppercase">Pembeli / Kontak</th>
                                <th class="py-3 text-muted small uppercase">Produk</th>
                                <th class="py-3 text-muted small uppercase">Harga Jual Lepas</th>
                                <th class="py-3 text-muted small uppercase">Alasan Penolakan</th>
                                <th class="py-3 text-muted small uppercase text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedSales as $index => $sale)
                                <tr class="sale-row fade-in" style="animation-delay: {{ $index * 0.05 }}s; border-bottom: 1px solid #f1f5f9;">
                                    <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $sale->name }}</span>
                                            <span class="text-muted small mb-1">{{ $sale->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->whatsapp_number) }}" target="_blank" class="d-inline-flex align-items-center gap-1 text-success fw-semibold small" style="text-decoration:none;">
                                                <i class="fab fa-whatsapp"></i> {{ $sale->whatsapp_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="p-1 rounded bg-light border" style="width: 42px; height: 42px; display:flex; align-items:center; justify-content:center;">
                                                @if($sale->product->display_image)
                                                    <img src="{{ asset('storage/' . $sale->product->display_image) }}" alt="Img" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                                                @else
                                                    <i class="ti ti-package text-muted" style="font-size:20px;"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-primary" style="font-size: 14px;">{{ $sale->product->name }}</span>
                                                <span class="badge bg-primary-subtle text-primary align-self-start mt-1" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:6px;">{{ $sale->product->category->name ?? 'Default' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark" style="font-size: 14.5px;">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-muted small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $sale->admin_notes }}">
                                        {{ $sale->admin_notes ?? '—' }}
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
                    <p class="text-muted small">Pengajuan pembelian yang Anda tolak akan terekam dalam arsip ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ── REVIEW MODAL (APPROVE / REJECT) ── --}}
<div class="modal fade" id="reviewSaleModal" tabindex="-1" aria-hidden="true" style="background: rgba(10,37,64,0.4); backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-md);">
            <div class="modal-header border-bottom py-3 px-4" style="background: var(--off-white);">
                <div class="d-flex align-items-center gap-2">
                    <div class="modal-action-icon-wrap rounded bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ti ti-shopping-cart" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold" id="reviewModalTitle" style="color: var(--primary); font-size: 16px;">Tinjau Pengajuan Pembelian</h5>
                        <small class="text-muted" id="reviewModalSubtitle">Pembeli: —</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="reviewSaleForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-3 border">
                        <i class="ti ti-box text-accent" style="font-size: 28px;"></i>
                        <div>
                            <span class="text-muted small d-block">Produk yang Diajukan</span>
                            <span class="fw-bold text-dark" id="modalProductName" style="font-size: 14.5px;">—</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="adminNotes" class="form-label" id="notesLabel">Catatan Admin</label>
                        <textarea class="form-control" name="admin_notes" id="adminNotes" rows="4" placeholder="Tulis catatan di sini..."></textarea>
                        <span class="text-muted small mt-2 d-block" id="modalActionHint" style="font-size: 11.5px; line-height: 1.4;">
                            <i class="fab fa-whatsapp text-success me-1"></i>
                            Notifikasi WhatsApp otomatis akan dikirim ke client.
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
<div class="modal fade" id="confirmPaymentModal" tabindex="-1" aria-hidden="true" style="background: rgba(10,37,64,0.4); backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-md);">
            <div class="modal-header border-bottom py-3 px-4" style="background: linear-gradient(135deg, #0a2540 0%, #1a4a75 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-center rounded" style="width: 36px; height: 36px; background: rgba(255,255,255,0.15);">
                        <i class="ti ti-shield-check text-white" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white" style="font-size: 16px;">Konfirmasi Pembayaran</h5>
                        <small style="color: rgba(255,255,255,0.65);" id="confirmPaymentSubtitle">Verifikasi pembayaran user</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="confirmPaymentForm">
                @csrf
                <div class="modal-body p-4">
                    {{-- Summary card --}}
                    <div class="p-4 rounded-3 mb-4 text-center" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1.5px solid #86efac;">
                        <div class="mb-2 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 56px; height: 56px; background: #16a34a; color: white; font-size: 26px;">
                            <i class="ti ti-check"></i>
                        </div>
                        <div class="fw-bold text-dark mt-2" id="confirmPaymentName" style="font-size: 16px;">—</div>
                        <div class="text-muted small" id="confirmPaymentProduct">—</div>
                        <div class="fw-bold mt-1" id="confirmPaymentPrice" style="color: #15803d; font-size: 18px;">—</div>
                    </div>

                    <div class="p-3 rounded-3" style="background: #fffbeb; border: 1px solid #fde68a;">
                        <p class="mb-0 small" style="color: #92400e; line-height: 1.6;">
                            <i class="fas fa-whatsapp text-success me-1"></i>
                            Setelah dikonfirmasi, WA otomatis akan terkirim ke user bahwa pembayaran diterima. Lanjutkan dengan mengirim detail akses web langsung via WhatsApp.
                        </p>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-cancel py-2 px-3" data-bs-dismiss="modal" style="height: 38px; line-height: 1;">Batal</button>
                    <button type="submit" class="btn fw-bold py-2 px-4 text-white" style="height: 38px; line-height: 1; border: none; border-radius: var(--radius-sm); background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);">
                        <i class="ti ti-shield-check me-1"></i> Konfirmasi Pembayaran
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

        // ── Approve / Reject Modal ──
        const reviewModal = new bootstrap.Modal(document.getElementById('reviewSaleModal'));
        const form = document.getElementById('reviewSaleForm');
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

                modalSubtitle.textContent = `Pembeli: ${clientName}`;
                modalProductName.textContent = productName;
                adminNotesTextarea.value = '';

                if (action === 'approve') {
                    modalTitle.textContent = 'Setujui Pengajuan Pembelian';
                    notesLabel.textContent = 'Catatan untuk Client (opsional)';
                    adminNotesTextarea.placeholder = 'Contoh: Terima kasih! Silakan cek link pembayaran yang sudah dikirim...';
                    modalActionHint.innerHTML = '<i class="fab fa-whatsapp text-success me-1"></i> Client akan mendapat <strong>WA otomatis</strong> berisi link halaman pembayaran QRIS.';
                    btnSubmitAction.style.background = '#16a34a';
                    btnSubmitAction.textContent = 'Setujui & Kirim Link Bayar';
                    form.action = `/admin/sales/${id}/approve`;
                } else {
                    modalTitle.textContent = 'Tolak Pengajuan Pembelian';
                    notesLabel.textContent = 'Alasan Penolakan';
                    adminNotesTextarea.placeholder = 'Tuliskan alasan penolakan dengan sopan...';
                    modalActionHint.innerHTML = '<i class="fab fa-whatsapp text-danger me-1"></i> Client akan mendapat <strong>WA otomatis</strong> berisi notifikasi penolakan.';
                    btnSubmitAction.style.background = '#dc2626';
                    btnSubmitAction.textContent = 'Tolak Pengajuan';
                    form.action = `/admin/sales/${id}/reject`;
                }

                reviewModal.show();
            });
        });

        // ── Confirm Payment Modal ──
        const confirmPaymentModal = new bootstrap.Modal(document.getElementById('confirmPaymentModal'));
        const confirmPaymentForm = document.getElementById('confirmPaymentForm');
        const confirmPaymentName = document.getElementById('confirmPaymentName');
        const confirmPaymentProduct = document.getElementById('confirmPaymentProduct');
        const confirmPaymentPrice = document.getElementById('confirmPaymentPrice');
        const confirmPaymentSubtitle = document.getElementById('confirmPaymentSubtitle');

        document.querySelectorAll('.btn-confirm-payment').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const product = btn.dataset.product;
                const price = btn.dataset.price;

                confirmPaymentSubtitle.textContent = `Pembeli: ${name}`;
                confirmPaymentName.textContent = name;
                confirmPaymentProduct.textContent = product;
                confirmPaymentPrice.textContent = price;
                confirmPaymentForm.action = `/admin/sales/${id}/approve-payment`;

                confirmPaymentModal.show();
            });
        });

        // ── Proof Preview Modal ──
        const proofPreviewModal = new bootstrap.Modal(document.getElementById('proofPreviewModal'));
        const proofPreviewImg = document.getElementById('proofPreviewImg');
        const proofModalSubtitle = document.getElementById('proofModalSubtitle');
        const proofDownloadLink = document.getElementById('proofDownloadLink');

        document.querySelectorAll('.btn-proof-preview').forEach(btn => {
            btn.addEventListener('click', function() {
                const imgUrl = btn.dataset.img;
                const name = btn.dataset.name;

                proofPreviewImg.src = imgUrl;
                proofModalSubtitle.textContent = `Bukti bayar dari: ${name}`;
                proofDownloadLink.href = imgUrl;

                proofPreviewModal.show();
            });
        });

        // ── WA Simulation Modal ──
        const simulatedWaModal = document.getElementById('waSimulationModal');
        if (simulatedWaModal) {
            const waModal = new bootstrap.Modal(simulatedWaModal);
            waModal.show();
        }
    });

    function animateRows() {
        document.querySelectorAll('.sale-row').forEach((row, i) => {
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
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            document.body.style.overflow = '';
        }
    }

    setTimeout(() => dismissToast(), 5000);
</script>
@endpush
