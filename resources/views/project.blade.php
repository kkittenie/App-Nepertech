@extends('layouts.landing')

@section('title', 'Produk — Nepertech')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing/project.css') }}">
@endpush

@section('content')

    {{-- ── HERO (same layout as all other pages) ── --}}
    <section class="page-hero">
        <div class="page-hero-bg"></div>

        <div class="container">
            <div>
                <h1 class="animate-fade-up" style="animation-delay:.15s">
                    Karya & <span class="gradient-text">Produk Kami</span>
                </h1>

                <p class="page-hero-sub animate-fade-up" style="animation-delay:.3s">
                    Eksplorasi {{ $products->count() }} produk dari {{ $categories->count() }} kategori layanan yang dikembangkan oleh tim TEFA profesional Nepertech.
                </p>
            </div>

            <div class="page-hero-visual" aria-hidden="true">
                <div class="page-hero-ring page-hero-ring-1"></div>
                <div class="page-hero-ring page-hero-ring-2"></div>
                <div class="page-hero-center"><i class="fas fa-project-diagram"></i></div>
                <div class="page-hero-float page-hero-float-1"><i class="fas fa-cubes"></i> {{ $products->count() }} Produk</div>
                <div class="page-hero-float page-hero-float-2"><i class="fas fa-tags"></i> Premium</div>
                <div class="page-hero-float page-hero-float-3"><i class="fas fa-th-large"></i> {{ $categories->count() }} Kategori</div>
                <div class="page-hero-dot page-hero-dot-1"></div>
                <div class="page-hero-dot page-hero-dot-2"></div>
                <div class="page-hero-dot page-hero-dot-3"></div>
            </div>
        </div>
    </section>

    {{-- ── FILTER + GRID ── --}}
    <section class="project-section">
        <div class="container">

            {{-- Category Filter --}}
            <div class="project-filters reveal">
                <button class="project-filter-btn active" data-filter="all">
                    <i class="fas fa-th-large"></i>
                    Semua Produk
                    <span class="filter-count">{{ $products->count() }}</span>
                </button>
                @foreach($categories as $cat)
                    @if($cat->products_count > 0)
                    <button class="project-filter-btn" data-filter="{{ $cat->id }}">
                        {{ $cat->name }}
                        <span class="filter-count">{{ $cat->products_count }}</span>
                    </button>
                    @endif
                @endforeach
            </div>

            {{-- Project Grid --}}
            <div class="project-grid" id="projectGrid">
                @forelse($products as $product)
                <a href="{{ route('project.detail', $product->slug) }}"
                   class="project-card produk-card"
                   data-category="{{ $product->category_id }}">

                    <div class="project-card-img">
                        @if($product->display_image)
                            <img src="{{ asset('storage/' . $product->display_image) }}"
                                 alt="{{ $product->name }}"
                                 loading="lazy">
                        @else
                            <div class="project-card-placeholder">
                                <i class="fas fa-cube"></i>
                            </div>
                        @endif
                        <div class="project-card-overlay">
                            <div class="project-card-overlay-content">
                                <span class="project-card-cta">
                                    <span>Lihat Produk</span>
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                        @if($product->category)
                        <span class="project-card-badge">{{ $product->category->name }}</span>
                        @endif
                    </div>

                    <div class="project-card-body">
                        <h3 class="project-card-title">{{ $product->name }}</h3>
                        <p class="project-card-desc">{{ Str::limit($product->description, 120) }}</p>
                        <div class="project-card-footer">
                            <div class="project-card-tags">
                                @if($product->harga_jual)
                                    <span class="project-tag">
                                        <i class="fas fa-tag"></i>
                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                    </span>
                                @endif
                                @if($product->harga_sewa_bulanan)
                                    <span class="project-tag project-tag--sewa">
                                        <i class="fas fa-sync-alt"></i>
                                        Sewa
                                    </span>
                                @endif
                            </div>
                            <span class="project-card-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>

                </a>
                @empty
                <div class="project-empty">
                    <div class="project-empty-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3>Belum Ada Produk</h3>
                    <p>Produk akan muncul di sini saat sudah ditambahkan oleh admin.</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

    {{-- ── CTA SECTION ── --}}
    <section class="project-cta">
        <div class="container">
            <div class="project-cta-inner">
                <div class="project-cta-content">
                    <h2>Punya Proyek yang Perlu Dikerjakan?</h2>
                    <p>Tim TEFA kami siap membantu mewujudkan id digital Anda menjadi kenyataan.</p>
                </div>
                <a href="{{ url('/kontak') }}" class="project-cta-btn">
                    Hubungi Kami
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // ── GSAP Animations ──
    if (typeof gsap !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Staggered grid entrance
        gsap.utils.toArray('.project-card').forEach((item) => {
            // Temporarily kill CSS transitions so they do not fight with GSAP
            item.style.transition = 'none';

            gsap.fromTo(item, 
                { y: 50, opacity: 0 },
                {
                    y: 0, opacity: 1, duration: 0.75,
                    ease: 'power3.out',
                    clearProps: 'transform,opacity,transition', // restore CSS transitions for hover behavior
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 88%',
                        toggleActions: 'play none none none'
                    }
                }
            );
        });

        // CTA section entrance
        gsap.from('.project-cta-inner', {
            y: 40, opacity: 0, duration: 0.8,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: '.project-cta',
                start: 'top 82%'
            }
        });
    }

    // ── Category Filter (vanilla JS — no GSAP dependency) ──
    const filterBtns = document.querySelectorAll('.project-filter-btn');
    const cards = document.querySelectorAll('.project-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;
            let visibleIdx = 0;

            cards.forEach((card) => {
                const match = filter === 'all' || card.dataset.category === filter;

                if (match) {
                    card.style.display = '';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(24px)';
                    setTimeout(() => {
                        card.style.transition = 'opacity 0.45s ease, transform 0.45s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, visibleIdx * 80);
                    visibleIdx++;
                } else {
                    card.style.transition = 'opacity 0.2s ease';
                    card.style.opacity = '0';
                    setTimeout(() => { card.style.display = 'none'; }, 200);
                }
            });
        });
    });
});
</script>
@endpush
