@extends('layouts.landing')

@section('title', $product->name . ' — Nepertech')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing/project-detail.css') }}">
@endpush

@section('content')

    {{-- ── IMMERSIVE HERO ── --}}
    <section class="pd-hero" id="pdHero">
        <div class="pd-hero-bg">
            @if($product->display_image)
            <img src="{{ asset('storage/' . $product->display_image) }}"
                 alt="{{ $product->name }}"
                 class="pd-hero-bg-img">
            @endif
            <div class="pd-hero-overlay"></div>
        </div>

        <div class="pd-hero-content">
            <a href="{{ route('project') }}" class="pd-back-link animate-fade-up">
                <span class="pd-back-icon"><i class="fas fa-arrow-left"></i></span>
                <span>Kembali ke Project</span>
            </a>

            @if($product->category)
            <div class="pd-hero-tags animate-fade-up" style="animation-delay:.1s">
                <span class="pd-hero-tag">{{ $product->category->name }}</span>
                @if($product->harga_sewa_bulanan)
                <span class="pd-hero-tag pd-hero-tag--accent">Sewa Tersedia</span>
                @endif
            </div>
            @endif

            <h1 class="pd-hero-title animate-fade-up" style="animation-delay:.18s">
                {{ $product->name }}
            </h1>

            <p class="pd-hero-subtitle animate-fade-up" style="animation-delay:.26s">
                {{ Str::limit($product->description, 160) }}
            </p>

            <div class="pd-hero-actions animate-fade-up" style="animation-delay:.34s">
                @if($product->link)
                <a href="{{ $product->link }}" target="_blank" class="pd-hero-btn pd-hero-btn--primary">
                    <span>Kunjungi Project</span>
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

    {{-- ── PROJECT OVERVIEW ── --}}
    <section class="pd-overview">
        <div class="container">
            <div class="pd-overview-grid">

                {{-- Left: Description --}}
                <div class="pd-overview-main reveal">
                    <div class="pd-section-label">
                        <span class="pd-label-line"></span>
                        <span class="pd-label-text">Tentang Project</span>
                    </div>
                    <h2 class="pd-section-title">{{ $product->name }}</h2>
                    <div class="pd-description">
                        {!! nl2br(e($product->description)) !!}
                    </div>

                    @if($product->link)
                    <a href="{{ $product->link }}" target="_blank" class="pd-visit-link">
                        <span class="pd-visit-text">Kunjungi Project</span>
                        <span class="pd-visit-icon">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>
                    @endif
                </div>

                {{-- Right: Meta Info --}}
                <div class="pd-overview-sidebar reveal">
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
                    @if($product->harga_jual)
                    <div class="pd-meta-block pd-meta-block--highlight">
                        <span class="pd-meta-label">Harga Jual</span>
                        <span class="pd-meta-value pd-meta-value--price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($product->harga_sewa_bulanan)
                    <div class="pd-meta-block">
                        <span class="pd-meta-label">Sewa / Bulan</span>
                        <span class="pd-meta-value">Rp {{ number_format($product->harga_sewa_bulanan, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($product->harga_sewa_tahunan)
                    <div class="pd-meta-block">
                        <span class="pd-meta-label">Sewa / Tahun</span>
                        <span class="pd-meta-value">Rp {{ number_format($product->harga_sewa_tahunan, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ── FEATURED COVER IMAGE ── --}}
    @if($product->display_image)
    <section class="pd-cover-section">
        <div class="pd-cover-container">
            <div class="pd-cover-frame reveal">
                <img src="{{ asset('storage/' . $product->display_image) }}"
                     alt="{{ $product->name }}"
                     class="pd-cover-img"
                     onclick="showLightbox(this.src)">
            </div>
        </div>
    </section>
    @endif

    {{-- ── DYNAMIC IMAGE SHOWCASE ── --}}
    @if($product->images->count() > 0)
    <section class="pd-showcase">
        <div class="container">
            <div class="pd-showcase-header reveal">
                <div class="pd-section-label">
                    <span class="pd-label-line"></span>
                    <span class="pd-label-text">Galeri</span>
                </div>
                <h2 class="pd-section-title">Screenshot & Preview</h2>
                <p class="pd-showcase-subtitle">Explore the visual journey of this project</p>
            </div>
        </div>

        <div class="pd-showcase-flow">
            @foreach($product->images as $idx => $img)
                @php
                    $pattern = $idx % 5;
                @endphp

                @if($pattern === 0)
                    {{-- Pattern A: Full-width immersive --}}
                    <div class="pd-showcase-block pd-block-full reveal">
                        <div class="pd-showcase-img-wrap pd-img-cinematic"
                             onclick="showLightbox(this.querySelector('img').src)">
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                 alt="{{ $product->name }} — {{ $loop->iteration }}"
                                 loading="lazy">
                            <div class="pd-img-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>

                @elseif($pattern === 1)
                    {{-- Pattern B: Offset left with breathing room --}}
                    <div class="pd-showcase-block pd-block-offset-left reveal">
                        <div class="container">
                            <div class="pd-offset-wrap pd-offset-left">
                                <div class="pd-showcase-img-wrap"
                                     onclick="showLightbox(this.querySelector('img').src)">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                         alt="{{ $product->name }} — {{ $loop->iteration }}"
                                         loading="lazy">
                                    <div class="pd-img-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($pattern === 2)
                    {{-- Pattern C: Offset right --}}
                    <div class="pd-showcase-block pd-block-offset-right reveal">
                        <div class="container">
                            <div class="pd-offset-wrap pd-offset-right">
                                <div class="pd-showcase-img-wrap"
                                     onclick="showLightbox(this.querySelector('img').src)">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                         alt="{{ $product->name }} — {{ $loop->iteration }}"
                                         loading="lazy">
                                    <div class="pd-img-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($pattern === 3)
                    {{-- Pattern D: Two-up side by side --}}
                    <div class="pd-showcase-block pd-block-duo reveal">
                        <div class="container">
                            <div class="pd-duo-grid">
                                <div class="pd-showcase-img-wrap"
                                     onclick="showLightbox(this.querySelector('img').src)">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                         alt="{{ $product->name }} — {{ $loop->iteration }}"
                                         loading="lazy">
                                    <div class="pd-img-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                                </div>
                                @if(!$loop->last && isset($product->images[$idx + 1]))
                                    {{-- Peek-ahead: use the next image for the second slot --}}
                                @endif
                            </div>
                        </div>
                    </div>

                @elseif($pattern === 4)
                    {{-- Pattern E: Contained centered --}}
                    <div class="pd-showcase-block pd-block-centered reveal">
                        <div class="container">
                            <div class="pd-centered-wrap">
                                <div class="pd-showcase-img-wrap"
                                     onclick="showLightbox(this.querySelector('img').src)">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                         alt="{{ $product->name }} — {{ $loop->iteration }}"
                                         loading="lazy">
                                    <div class="pd-img-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
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
                    <h2 class="pd-pricing-title">Investasi untuk<br>project Anda</h2>
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
                <span class="pd-next-label reveal">Project Selanjutnya</span>
                <h2 class="pd-next-title reveal">{{ $nextProduct->name }}</h2>
                <span class="pd-next-arrow reveal">
                    <span>Lihat Project</span>
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
                    <span>Lihat Semua Project</span>
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
    // ── Parallax Hero ──
    const hero = document.getElementById('pdHero');
    const heroBgImg = hero ? hero.querySelector('.pd-hero-bg-img') : null;

    if (heroBgImg) {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            const heroH = hero.offsetHeight;
            if (scrollY < heroH * 1.5) {
                const parallax = scrollY * 0.35;
                heroBgImg.style.transform = `scale(1.1) translateY(${parallax}px)`;
                hero.querySelector('.pd-hero-content').style.transform = `translateY(${scrollY * 0.15}px)`;
                hero.querySelector('.pd-hero-content').style.opacity = 1 - (scrollY / heroH) * 0.8;
            }
        }, { passive: true });
    }

    // ── Image hover tilt ──
    document.querySelectorAll('.pd-showcase-img-wrap').forEach(wrap => {
        wrap.addEventListener('mousemove', (e) => {
            const rect = wrap.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            wrap.style.transform = `perspective(800px) rotateY(${x * 6}deg) rotateX(${-y * 6}deg)`;
        });
        wrap.addEventListener('mouseleave', () => {
            wrap.style.transform = 'perspective(800px) rotateY(0) rotateX(0)';
        });
    });

    // ── Reveal observer for showcase blocks ──
    const showcaseObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                showcaseObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll('.pd-showcase-block.reveal').forEach(el => {
        showcaseObserver.observe(el);
    });

    // ── Next project parallax ──
    const nextSection = document.getElementById('pdNext');
    const nextBgImg = nextSection ? nextSection.querySelector('.pd-next-bg-img') : null;
    if (nextBgImg) {
        window.addEventListener('scroll', () => {
            const rect = nextSection.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                const progress = (window.innerHeight - rect.top) / (window.innerHeight + rect.height);
                nextBgImg.style.transform = `scale(1.15) translateY(${(progress - 0.5) * -60}px)`;
            }
        }, { passive: true });
    }
});
</script>
@endpush
