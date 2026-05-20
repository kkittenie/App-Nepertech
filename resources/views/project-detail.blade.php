@extends('layouts.landing')

@section('title', $product->name . ' — Nepertech')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing/project-detail.css') }}">
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
                    </div>

                    @if($product->harga_sewa_bulanan)
                    <div class="pd-price-card">
                        <h4 class="pd-price-type">Sewa / Bulan</h4>
                        <p class="pd-price-note">Langganan bulanan</p>
                        <div class="pd-price-amount">Rp {{ number_format($product->harga_sewa_bulanan, 0, ',', '.') }}</div>
                    </div>
                    @endif

                    @if($product->harga_sewa_tahunan)
                    <div class="pd-price-card">
                        <h4 class="pd-price-type">Sewa / Tahun</h4>
                        <p class="pd-price-note">Hemat lebih banyak</p>
                        <div class="pd-price-amount">Rp {{ number_format($product->harga_sewa_tahunan, 0, ',', '.') }}</div>
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

@endsection

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
</script>
@endpush
