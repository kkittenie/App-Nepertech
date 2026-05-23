@extends('layouts.landing')

@section('title', $product->name . ' — Nepertech')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing/project-detail.css') }}">
<style>
    #navbar {
        background: rgba(255, 255, 255, 0.45) !important;
        backdrop-filter: blur(24px) saturate(1.5) !important;
        -webkit-backdrop-filter: blur(24px) saturate(1.5) !important;
        padding: 24px 64px !important;
        box-shadow: none !important;
        border-bottom: 1px solid rgba(255,255,255,0.15) !important;
    }
    @media (max-width: 900px) {
        #navbar {
            padding: 16px 24px !important;
        }
    }

    /* ── Rental Request Modal ── */
    .rental-modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .rental-modal-overlay.open {
        display: flex;
    }
    .rental-modal-backdrop {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(10, 37, 64, 0.45);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        transition: opacity 0.3s ease;
    }
    .rental-modal-card {
        position: relative;
        z-index: 10;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(10, 37, 64, 0.15);
        width: 100%;
        max-width: 680px;
        padding: 36px;
        max-height: 90vh;
        overflow-y: auto;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        animation: modalReveal 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes modalReveal {
        from { opacity: 0; transform: scale(0.95) translateY(15px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .rental-modal-close {
        position: absolute;
        top: 24px; right: 24px;
        background: rgba(10, 37, 64, 0.05);
        border: none;
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: #0a2540;
        transition: background 0.2s, color 0.2s;
    }
    .rental-modal-close:hover {
        background: #0a2540;
        color: #fff;
    }
    .rental-modal-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }
    .rental-modal-icon-wrap {
        width: 48px; height: 48px;
        border-radius: 12px;
        background: rgba(44, 107, 158, 0.1);
        color: #2c6b9e;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
    }
    .rental-modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #0a2540;
        margin-bottom: 4px;
    }
    .rental-modal-subtitle {
        font-size: 14px;
        color: #94a3b8;
        margin: 0;
    }
    .rental-modal-form .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }
    .rental-modal-form .form-group {
        padding-right: 10px;
        padding-left: 10px;
        margin-bottom: 20px;
    }
    .rental-label {
        font-size: 13px;
        font-weight: 600;
        color: #0a2540;
        margin-bottom: 8px;
        display: block;
    }
    .rental-input, .rental-select, .rental-textarea {
        width: 100%;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #0a2540;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    .rental-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 14px;
        padding-right: 40px;
        cursor: pointer;
    }
    .rental-input:focus, .rental-select:focus, .rental-textarea:focus {
        border-color: #2c6b9e;
        box-shadow: 0 0 0 3px rgba(44, 107, 158, 0.12);
    }
    /* ── Hide native number input spinners ── */
    .rental-input[type="number"]::-webkit-inner-spin-button,
    .rental-input[type="number"]::-webkit-outer-spin-button,
    .duration-input::-webkit-inner-spin-button,
    .duration-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .rental-input[type="number"],
    .duration-input {
        -moz-appearance: textfield;
    }
    .rental-field-hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
        display: block;
    }
    .rental-duration-control {
        display: flex;
        align-items: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #fff;
        overflow: hidden;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .rental-duration-control:focus-within {
        border-color: #2c6b9e;
        box-shadow: 0 0 0 3px rgba(44, 107, 158, 0.12);
    }
    .rental-duration-control .duration-btn {
        border: none;
        background: transparent;
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: #2c6b9e;
        font-size: 14px;
        transition: background 0.2s;
        flex-shrink: 0;
    }
    .rental-duration-control .duration-btn:hover {
        background: rgba(44, 107, 158, 0.08);
    }
    .rental-duration-control .duration-input {
        border: none;
        padding: 0;
        height: 44px;
        font-weight: 600;
        font-size: 15px;
        background: transparent;
        -webkit-appearance: none;
        -moz-appearance: textfield;
        appearance: none;
    }
    .rental-duration-control .duration-input:focus {
        box-shadow: none;
        border: none;
    }
    .rental-price-card {
        background: rgba(44, 107, 158, 0.04);
        border: 1px solid rgba(44, 107, 158, 0.1);
        border-radius: 16px;
        padding: 20px;
        margin-top: 24px;
        margin-bottom: 28px;
        width: 100%;
    }
    .rental-price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .rental-price-row .price-label {
        font-size: 13px;
        color: #64748b;
    }
    .rental-price-row .price-value {
        font-size: 14px;
        font-weight: 600;
        color: #0a2540;
    }
    .rental-price-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 12px 0;
    }
    .rental-price-row.total .price-label {
        font-size: 14px;
        font-weight: 700;
        color: #0a2540;
    }
    .rental-price-row.total .price-value.highlight {
        font-size: 18px;
        font-weight: 800;
        color: #2c6b9e;
    }
    .rental-submit-btn {
        width: 100%;
        padding: 14px 24px;
        border-radius: 12px;
        background: #0a2540;
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
    }
    .rental-submit-btn:hover {
        background: #2c6b9e;
        transform: translateY(-2px);
    }
    .rental-submit-btn:active {
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

    {{-- ── IMMERSIVE HERO ── --}}
    <section class="pd-hero" id="pdHero">
        <div class="pd-hero-bg">
            @if($product->hero_image)
            <img src="{{ asset('storage/' . $product->hero_image) }}"
                 alt="{{ $product->name }}"
                 class="pd-hero-bg-img">
            @elseif($product->display_image)
            <img src="{{ asset('storage/' . $product->display_image) }}"
                 alt="{{ $product->name }}"
                 class="pd-hero-bg-img">
            @endif
            <div class="pd-hero-overlay"></div>
        </div>

        <div class="pd-hero-content">
            <a href="{{ route('project') }}" class="pd-back-link animate-fade-up">
                <span class="pd-back-icon"><i class="fas fa-arrow-left"></i></span>
                <span>Kembali ke Produk</span>
            </a>


            <h1 class="pd-hero-title animate-fade-up" style="animation-delay:.18s">
                {{ $product->name }}
            </h1>

            @if($product->subtitle)
            <p class="pd-hero-subtitle animate-fade-up" style="animation-delay:.26s">
                {{ $product->subtitle }}
            </p>
            @endif

            <div class="pd-hero-actions animate-fade-up" style="animation-delay:.34s">
                @if($product->link)
                <a href="{{ $product->link }}" target="_blank" class="pd-hero-btn pd-hero-btn--primary">
                    <span>Kunjungi Produk</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                @endif
                <div class="pd-hero-scroll-hint">
                    <span>Scroll untuk melihat</span>
                    <div class="pd-scroll-indicator">
                        <div class="pd-scroll-dot"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── TOP DESCRIPTION (Left-only, no sidebar) ── --}}
    <section class="pd-overview">
        <div class="container pd-overview-grid">
            <div class="pd-overview-main reveal">
                <div class="pd-section-label">
                    <span class="pd-label-line"></span>
                    <span class="pd-label-text">Tentang Produk</span>
                </div>
                <h2 class="pd-section-title">{{ $product->subjudul_atas ?: $product->name }}</h2>
                <div class="pd-description">
                    {!! nl2br(e($product->description)) !!}
                </div>

                @if($product->link)
                <a href="{{ $product->link }}" target="_blank" class="pd-visit-link" style="margin-top: 32px">
                    <span class="pd-visit-text">Kunjungi Produk</span>
                    <span class="pd-visit-icon">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </a>
                @endif
            </div>

            <div class="pd-overview-sidebar reveal" style="transition-delay: .15s">
                <div class="pd-sidebar-card" style="background: var(--primary); color: white; border-color: transparent;">
                    <h3 class="pd-sidebar-title" style="color: white; border-color: rgba(255,255,255,0.1);">Mulai Proyek Anda</h3>
                    <p style="font-size: 14px; line-height: 1.6; margin-bottom: 24px; color: rgba(255,255,255,0.8);">
                        Tertarik dengan solusi teknologi seperti ini? Tim TEFA Nepertech siap membantu mewujudkan ide bisnis Anda menjadi kenyataan.
                    </p>
                    <a href="{{ url('/kontak') }}" class="btn btn-primary" style="background: white; color: var(--primary); width: 100%; justify-content: center;">
                        Konsultasi Gratis <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── DISPLAY IMAGE + GALLERY THUMBNAILS ── --}}
    <section class="pd-gallery-section">
        <div class="container">
            <div class="pd-gallery-wrap reveal">

                {{-- Display Image (the main product display_image) --}}
                @if($product->display_image)
                <div class="pd-display-image">
                    <div class="pd-display-frame">
                        <img src="{{ asset('storage/' . $product->display_image) }}"
                             alt="{{ $product->name }}"
                             onclick="showLightbox(this.src)">
                    </div>
                </div>
                @endif

                {{-- Exactly 3 Gallery Thumbnails --}}
                @if($product->images->count() > 0)
                <div class="pd-thumb-row">
                    @foreach($product->images->take(3) as $img)
                    <button class="pd-thumb-item"
                            data-index="{{ $loop->index }}"
                            onclick="openGalleryPreview({{ $loop->index }})"
                            aria-label="View image {{ $loop->iteration }}">
                        <img src="{{ asset('storage/' . $img->image_path) }}"
                             alt="{{ $product->name }} — {{ $loop->iteration }}"
                             loading="lazy">
                        <div class="pd-thumb-overlay">
                            <i class="fas fa-expand"></i>
                        </div>
                    </button>
                    @endforeach
                </div>
                @endif

            </div>
        </div>
    </section>

    {{-- ── GALLERY PREVIEW OVERLAY (opens when clicking a thumbnail) ── --}}
    @if($product->images->count() > 0)
    <div class="pd-preview-overlay" id="galleryPreview">
        <div class="pd-preview-backdrop" onclick="closeGalleryPreview()"></div>
        <div class="pd-preview-container">
            {{-- Close button --}}
            <button class="pd-preview-close" onclick="closeGalleryPreview()" aria-label="Close preview">
                <i class="fas fa-times"></i>
            </button>

            {{-- Main preview image --}}
            <div class="pd-preview-image-wrap">
                <img src="" alt="" id="previewMainImg">
            </div>

            {{-- Counter --}}
            <div class="pd-preview-counter">
                <span id="previewCurrent">1</span> / <span id="previewTotal">{{ $product->images->count() }}</span>
            </div>

            {{-- Navigation --}}
            @if($product->images->count() > 1)
            <button class="pd-preview-nav pd-preview-nav--prev" id="previewPrev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="pd-preview-nav pd-preview-nav--next" id="previewNext" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
            @endif

            {{-- Thumbnail strip inside preview --}}
            <div class="pd-preview-thumbs">
                @foreach($product->images as $img)
                <button class="pd-preview-thumb {{ $loop->first ? 'active' : '' }}"
                        data-index="{{ $loop->index }}"
                        data-src="{{ asset('storage/' . $img->image_path) }}"
                        data-alt="{{ $product->name }} — {{ $loop->iteration }}">
                    <img src="{{ asset('storage/' . $img->image_path) }}"
                         alt="{{ $product->name }} — {{ $loop->iteration }}"
                         loading="lazy">
                </button>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if($product->deskripsi_bawah)
    {{-- ── DETAILED DESCRIPTION (Below gallery) ── --}}
    <section class="pd-detail-desc">
        <div class="container">
            <div class="pd-detail-desc-grid reveal">
                <div class="pd-detail-desc-content">
                    <div class="pd-section-label">
                        <span class="pd-label-line"></span>
                        <span class="pd-label-text">Detail Lengkap</span>
                    </div>
                    @if($product->subjudul_bawah)
                    <h2 class="pd-section-title" style="font-size: 2rem; margin-bottom: 24px;">{{ $product->subjudul_bawah }}</h2>
                    @endif
                    <div class="pd-detail-desc-text">
                        {!! nl2br(e($product->deskripsi_bawah)) !!}
                    </div>
                </div>

                {{-- Meta sidebar --}}
                <div class="pd-detail-meta">
                    <div class="pd-meta-block">
                        <span class="pd-meta-label">Kategori</span>
                        <span class="pd-meta-value">{{ $product->category->name ?? '—' }}</span>
                    </div>
                    <div class="pd-meta-block">
                        <span class="pd-meta-label">Galeri</span>
                        <span class="pd-meta-value">{{ $product->images->count() + ($product->display_image ? 1 : 0) }} foto</span>
                    </div>
                    <div class="pd-meta-block">
                        <span class="pd-meta-label">Ditambahkan</span>
                        <span class="pd-meta-value">{{ $product->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── PRICING SECTION ── --}}
    @if($product->harga_jual)
    <section class="pd-pricing-section">
        <div class="container">
            <div class="pd-pricing-wrap reveal">
                <div class="pd-pricing-left">
                    <div class="pd-section-label">
                        <span class="pd-label-line"></span>
                        <span class="pd-label-text">Harga</span>
                    </div>
                    <h2 class="pd-pricing-title">Investasi untuk<br>proyek Anda</h2>
                    <p class="pd-pricing-desc">Pilih model yang sesuai dengan kebutuhan bisnis Anda.</p>
                </div>
                <div class="pd-pricing-cards">
                    <div class="pd-price-card pd-price-card--featured">
                        <span class="pd-price-badge">Populer</span>
                        <h4 class="pd-price-type">Jual Lepas</h4>
                        <p class="pd-price-note">Harga beli penuh / sekali bayar</p>
                        <div class="pd-price-amount">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</div>
                        <button class="btn btn-primary mt-3 w-100 btn-sale-trigger" style="background:#0a2540; border-color:#0a2540; border-radius:8px; padding:10px 16px; font-weight:600; font-size:13px;">
                            <i class="fas fa-shopping-cart me-2"></i> Beli Sekarang
                        </button>
                    </div>

                    @if($product->harga_sewa_bulanan)
                    <div class="pd-price-card">
                        <h4 class="pd-price-type">Sewa / Bulan</h4>
                        <p class="pd-price-note">Langganan bulanan</p>
                        <div class="pd-price-amount">Rp {{ number_format($product->harga_sewa_bulanan, 0, ',', '.') }}</div>
                        <button class="btn btn-primary mt-3 w-100 btn-rental-trigger" data-type="bulanan" style="background:#0a2540; border-color:#0a2540; border-radius:8px; padding:10px 16px; font-weight:600; font-size:13px;">
                            <i class="fas fa-calendar-alt me-2"></i> Sewa Bulanan
                        </button>
                    </div>
                    @endif

                    @if($product->harga_sewa_tahunan)
                    <div class="pd-price-card">
                        <h4 class="pd-price-type">Sewa / Tahun</h4>
                        <p class="pd-price-note">Hemat lebih banyak</p>
                        <div class="pd-price-amount">Rp {{ number_format($product->harga_sewa_tahunan, 0, ',', '.') }}</div>
                        <button class="btn btn-primary mt-3 w-100 btn-rental-trigger" data-type="tahunan" style="background:#2c6b9e; border-color:#2c6b9e; border-radius:8px; padding:10px 16px; font-weight:600; font-size:13px;">
                            <i class="fas fa-calendar-check me-2"></i> Sewa Tahunan
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── NEXT PROJECT ── --}}
    @if($nextProduct)
    <section class="pd-next-section" id="pdNext">
        <a href="{{ route('project.detail', $nextProduct->slug) }}" class="pd-next-link">
            <div class="pd-next-bg">
                @if($nextProduct->display_image)
                <img src="{{ asset('storage/' . $nextProduct->display_image) }}"
                     alt="{{ $nextProduct->name }}"
                     class="pd-next-bg-img">
                @endif
                <div class="pd-next-overlay"></div>
            </div>
            <div class="pd-next-content">
                <span class="pd-next-label reveal">Produk Selanjutnya</span>
                <h2 class="pd-next-title reveal">{{ $nextProduct->name }}</h2>
                <span class="pd-next-arrow reveal">
                    <span>Lihat Produk</span>
                    <i class="fas fa-long-arrow-alt-right"></i>
                </span>
            </div>
        </a>
    </section>
    @else
    <section class="pd-all-projects">
        <div class="container">
            <div class="pd-all-inner reveal">
                <a href="{{ route('project') }}" class="pd-all-link">
                    <i class="fas fa-th-large"></i>
                    <span>Lihat Semua Produk</span>
                    <i class="fas fa-arrow-right pd-all-arrow"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ALERT POPUPS --}}
    @if(session('success'))
    <div class="toast-alert toast-success" id="toastAlert" style="position: fixed; top: 100px; right: 24px; z-index: 10000; background: #dcfce7; border: 1.5px solid #86efac; border-radius: 12px; padding: 16px 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); animation: toastEntrance 0.3s ease forwards;">
        <div class="toast-icon" style="color: #15803d; font-size: 18px;"><i class="fas fa-check-circle"></i></div>
        <span style="color: #166534; font-weight: 600; font-size: 14px;">{{ session('success') }}</span>
        <button class="toast-close" onclick="this.parentElement.remove()" style="border: none; background: transparent; cursor: pointer; color: #166534; font-size: 16px; margin-left: 12px;"><i class="fas fa-times"></i></button>
    </div>
    @endif

    @if(session('error'))
    <div class="toast-alert toast-error" id="toastAlert" style="position: fixed; top: 100px; right: 24px; z-index: 10000; background: #fee2e2; border: 1.5px solid #fca5a5; border-radius: 12px; padding: 16px 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); animation: toastEntrance 0.3s ease forwards;">
        <div class="toast-icon" style="color: #b91c1c; font-size: 18px;"><i class="fas fa-exclamation-circle"></i></div>
        <span style="color: #991b1b; font-weight: 600; font-size: 14px;">{{ session('error') }}</span>
        <button class="toast-close" onclick="this.parentElement.remove()" style="border: none; background: transparent; cursor: pointer; color: #991b1b; font-size: 16px; margin-left: 12px;"><i class="fas fa-times"></i></button>
    </div>
    @endif

    {{-- RENTAL REQUEST MODAL --}}
    <div class="rental-modal-overlay" id="rentalModal">
        <div class="rental-modal-backdrop" id="rentalBackdrop"></div>
        <div class="rental-modal-card">
            <button class="rental-modal-close" id="rentalClose" aria-label="Close modal">
                <i class="fas fa-times"></i>
            </button>
            <div class="rental-modal-header">
                <div class="rental-modal-icon-wrap">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h3 class="rental-modal-title">Formulir Pengajuan Sewa</h3>
                    <p class="rental-modal-subtitle">{{ $product->name }}</p>
                </div>
            </div>
            
            <form action="{{ route('rental.request') }}" method="POST" class="rental-modal-form" id="rentalRequestForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="form-row">
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="rentalName" class="rental-label">Nama Lengkap <span class="text-danger"></span></label>
                        <input type="text" name="name" id="rentalName" class="rental-input" placeholder="Masukkan nama lengkap..." value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                    </div>
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="rentalEmail" class="rental-label">Alamat Email <span class="text-danger"></span></label>
                        <input type="email" name="email" id="rentalEmail" class="rental-input" placeholder="contoh@domain.com" value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                    </div>
                </div>

                <div class="form-row" style="margin-top: 10px;">
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="rentalWhatsApp" class="rental-label">No. WhatsApp <span class="text-danger"></span></label>
                        <input type="text" name="whatsapp_number" id="rentalWhatsApp" class="rental-input" placeholder="Contoh: 08123456789" required>
                        <span class="rental-field-hint">Pastikan nomor aktif untuk notifikasi WhatsApp.</span>
                    </div>
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="rentalStartDate" class="rental-label">Tanggal Mulai Sewa <span class="text-danger"></span></label>
                        <input type="date" name="start_date" id="rentalStartDate" class="rental-input" min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="form-row" style="margin-top: 10px;">
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="rentalDurationType" class="rental-label">Opsi Penyewaan <span class="text-danger"></span></label>
                        <select name="duration_type" id="rentalDurationType" class="rental-select" required>
                            @if($product->harga_sewa_bulanan)
                                <option value="bulanan">Bulanan</option>
                            @endif
                            @if($product->harga_sewa_tahunan)
                                <option value="tahunan">Tahunan</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="rentalDurationValue" class="rental-label">Durasi Sewa <span class="text-danger"></span></label>
                        <select name="duration_value" id="rentalDurationValue" class="rental-select" required>
                            <!-- Will be populated dynamically via JavaScript based on duration_type -->
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 15px; width: 100%;">
                    <label for="clientNotes" class="rental-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="client_notes" id="clientNotes" class="rental-textarea" rows="3" placeholder="Tuliskan catatan tambahan jika ada..."></textarea>
                </div>

                {{-- Price breakdown area --}}
                <div class="rental-price-card">
                    <div class="rental-price-row">
                        <span class="price-label">Biaya Sewa per Unit</span>
                        <span class="price-value" id="unitPriceLabel">Rp 0</span>
                    </div>
                    <div class="rental-price-divider"></div>
                    <div class="rental-price-row total">
                        <span class="price-label">Estimasi Total Biaya</span>
                        <span class="price-value highlight" id="totalPriceLabel">Rp 0</span>
                    </div>
                </div>

                <button type="submit" class="rental-submit-btn">
                    <span>Ajukan Penyewaan</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

@endsection

    {{-- SALE REQUEST MODAL --}}
    <div class="rental-modal-overlay" id="saleModal">
        <div class="rental-modal-backdrop" id="saleBackdrop"></div>
        <div class="rental-modal-card">
            <button class="rental-modal-close" id="saleClose" aria-label="Close modal">
                <i class="fas fa-times"></i>
            </button>
            <div class="rental-modal-header">
                <div class="rental-modal-icon-wrap">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h3 class="rental-modal-title">Formulir Pembelian</h3>
                    <p class="rental-modal-subtitle">{{ $product->name }}</p>
                </div>
            </div>
            
            <form action="{{ route('sale.request') }}" method="POST" class="rental-modal-form" id="saleRequestForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="form-row">
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="saleName" class="rental-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="saleName" class="rental-input" placeholder="Masukkan nama lengkap..." value="{{ auth()->user() ? auth()->user()->name : '' }}" required>
                    </div>
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="saleEmail" class="rental-label">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="saleEmail" class="rental-input" placeholder="contoh@domain.com" value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                    </div>
                </div>

                <div class="form-row" style="margin-top: 10px;">
                    <div class="form-group col-md-6" style="flex: 1 0 50%; min-width: 250px;">
                        <label for="saleWhatsApp" class="rental-label">No. WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="whatsapp_number" id="saleWhatsApp" class="rental-input" placeholder="Contoh: 08123456789" required>
                        <span class="rental-field-hint">Pastikan nomor aktif untuk notifikasi WhatsApp.</span>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 15px; width: 100%;">
                    <label for="saleClientNotes" class="rental-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="client_notes" id="saleClientNotes" class="rental-textarea" rows="3" placeholder="Tuliskan catatan tambahan jika ada..."></textarea>
                </div>

                {{-- Price breakdown area --}}
                <div class="rental-price-card">
                    <div class="rental-price-row total">
                        <span class="price-label">Total Harga (Jual Lepas)</span>
                        <span class="price-value highlight">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" class="rental-submit-btn">
                    <span>Ajukan Pembelian</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    gsap.registerPlugin(ScrollTrigger);

    // ── Parallax Hero ──
    const hero = document.getElementById('pdHero');
    const heroBgImg = hero ? hero.querySelector('.pd-hero-bg-img') : null;

    if (heroBgImg) {
        gsap.to(heroBgImg, {
            yPercent: 35,
            ease: "none",
            scrollTrigger: {
                trigger: hero,
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });
        
        gsap.to(hero.querySelector('.pd-hero-content'), {
            yPercent: 15,
            opacity: 0.2,
            ease: "none",
            scrollTrigger: {
                trigger: hero,
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });
    }

    // ── Next project parallax ──
    const nextSection = document.getElementById('pdNext');
    const nextBgImg = nextSection ? nextSection.querySelector('.pd-next-bg-img') : null;
    if (nextBgImg) {
        gsap.to(nextBgImg, {
            yPercent: 20,
            ease: "none",
            scrollTrigger: {
                trigger: nextSection,
                start: "top bottom",
                end: "bottom top",
                scrub: true
            }
        });
    }
});

// ── Gallery Preview System ──
(function() {
    const overlay = document.getElementById('galleryPreview');
    if (!overlay) return;

    const mainImg = document.getElementById('previewMainImg');
    const currentEl = document.getElementById('previewCurrent');
    const prevBtn = document.getElementById('previewPrev');
    const nextBtn = document.getElementById('previewNext');
    const thumbs = overlay.querySelectorAll('.pd-preview-thumb');
    const totalImages = thumbs.length;
    let currentIndex = 0;

    function setImage(index) {
        if (index < 0) index = totalImages - 1;
        if (index >= totalImages) index = 0;
        currentIndex = index;

        const thumb = thumbs[index];
        const src = thumb.dataset.src;
        const alt = thumb.dataset.alt;

        // Animate
        mainImg.style.opacity = '0';
        mainImg.style.transform = 'scale(0.95)';

        setTimeout(() => {
            mainImg.src = src;
            mainImg.alt = alt;
            mainImg.style.opacity = '1';
            mainImg.style.transform = 'scale(1)';
        }, 180);

        // Update thumbs
        thumbs.forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');

        // Update counter
        if (currentEl) currentEl.textContent = index + 1;

        // Scroll thumb into view
        thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }

    // Open preview
    window.openGalleryPreview = function(index) {
        currentIndex = index;
        const thumb = thumbs[index];
        mainImg.src = thumb.dataset.src;
        mainImg.alt = thumb.dataset.alt;
        mainImg.style.opacity = '1';
        mainImg.style.transform = 'scale(1)';

        thumbs.forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
        if (currentEl) currentEl.textContent = index + 1;

        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    // Close preview
    window.closeGalleryPreview = function() {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    };

    // Thumb clicks inside preview
    thumbs.forEach((thumb, i) => {
        thumb.addEventListener('click', () => setImage(i));
    });

    // Nav buttons
    if (prevBtn) prevBtn.addEventListener('click', () => setImage(currentIndex - 1));
    if (nextBtn) nextBtn.addEventListener('click', () => setImage(currentIndex + 1));

    // Keyboard
    document.addEventListener('keydown', (e) => {
        if (!overlay.classList.contains('open')) return;
        if (e.key === 'ArrowLeft') setImage(currentIndex - 1);
        if (e.key === 'ArrowRight') setImage(currentIndex + 1);
        if (e.key === 'Escape') closeGalleryPreview();
    });
})();

// ── Rental Modal System ──
(function() {
    const modal = document.getElementById('rentalModal');
    if (!modal) return;

    const closeBtn = document.getElementById('rentalClose');
    const backdrop = document.getElementById('rentalBackdrop');
    const triggers = document.querySelectorAll('.btn-rental-trigger');

    const durationSelect = document.getElementById('rentalDurationValue');
    const selectType = document.getElementById('rentalDurationType');
    
    const unitPriceLabel = document.getElementById('unitPriceLabel');
    const totalPriceLabel = document.getElementById('totalPriceLabel');

    // Lease prices from PHP
    const priceMonthly = {{ $product->harga_sewa_bulanan ?? 0 }};
    const priceYearly = {{ $product->harga_sewa_tahunan ?? 0 }};

    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(amount);
    }

    function updateDurationOptions() {
        if (!durationSelect || !selectType) return;
        
        const type = selectType.value;
        const currentVal = durationSelect.value;
        durationSelect.innerHTML = '';
        
        if (type === 'bulanan') {
            const options = [
                { value: '1', label: '1 Bulan' },
                { value: '3', label: '3 Bulan' },
                { value: '6', label: '6 Bulan' }
            ];
            options.forEach(opt => {
                const el = document.createElement('option');
                el.value = opt.value;
                el.textContent = opt.label;
                durationSelect.appendChild(el);
            });
        } else if (type === 'tahunan') {
            const options = [
                { value: '1', label: '1 Tahun' }
            ];
            options.forEach(opt => {
                const el = document.createElement('option');
                el.value = opt.value;
                el.textContent = opt.label;
                durationSelect.appendChild(el);
            });
        }

        // Restore value if still valid, otherwise default to first option
        if ([...durationSelect.options].some(opt => opt.value === currentVal)) {
            durationSelect.value = currentVal;
        } else {
            durationSelect.selectedIndex = 0;
        }
    }

    function calculateTotal() {
        if (!durationSelect || !selectType) return;
        
        const type = selectType.value;
        const val = parseInt(durationSelect.value) || 1;
        const pricePerUnit = type === 'tahunan' ? priceYearly : priceMonthly;
        const total = pricePerUnit * val;

        unitPriceLabel.textContent = formatRupiah(pricePerUnit) + (type === 'tahunan' ? ' / Tahun' : ' / Bulan');
        totalPriceLabel.textContent = formatRupiah(total);
    }

    function openModal(type) {
        if (selectType) {
            selectType.value = type;
            // Check if option exists, otherwise fall back to the first available
            if (!selectType.value && selectType.options.length > 0) {
                selectType.selectedIndex = 0;
            }
        }
        updateDurationOptions();
        calculateTotal();

        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    triggers.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const type = btn.dataset.type || 'bulanan';
            openModal(type);
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (backdrop) backdrop.addEventListener('click', closeModal);

    if (selectType) {
        selectType.addEventListener('change', () => {
            updateDurationOptions();
            calculateTotal();
        });
    }

    if (durationSelect) {
        durationSelect.addEventListener('change', calculateTotal);
    }

    // ── Sale Modal System ──
    const saleModal = document.getElementById('saleModal');
    if (saleModal) {
        const saleCloseBtn = document.getElementById('saleClose');
        const saleBackdrop = document.getElementById('saleBackdrop');
        const saleTriggers = document.querySelectorAll('.btn-sale-trigger');

        function openSaleModal() {
            saleModal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeSaleModal() {
            saleModal.classList.remove('open');
            document.body.style.overflow = '';
        }

        saleTriggers.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                openSaleModal();
            });
        });

        if (saleCloseBtn) saleCloseBtn.addEventListener('click', closeSaleModal);
        if (saleBackdrop) saleBackdrop.addEventListener('click', closeSaleModal);
    }

    // Dismiss flash alert automatically after 5 seconds
    const toast = document.getElementById('toastAlert');
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px) scale(0.95)';
            toast.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            setTimeout(() => toast.remove(), 400);
        }, 5000);
    }
})();
</script>
@endpush

