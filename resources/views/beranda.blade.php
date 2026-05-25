@extends('layouts.landing')

@section('content')

    <section class="hero">
        <div class="hero-lines"></div>
        <div class="hero-noise"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-inner">
            <div class="hero-content">

                <div class="hero-accent-line"></div>

                <h1 class="hero-title">
                    Solusi Teknologi untuk<br>
                    <span class="hero-title-highlight">Masa Depan</span>
                </h1>

                <p class="hero-sub">
                    Teaching Factory software development profesional —
                    membangun teknologi cerdas sekaligus mencetak
                    talenta digital Indonesia yang berdaya saing global.
                </p>

                <div class="hero-buttons">
                    <a href="{{ url('/kontak') }}" class="btn btn-primary btn-arrow">
                        Konsultasi Gratis
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ url('/layanan') }}" class="btn btn-outline btn-arrow">
                        Lihat Layanan
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number" data-target="{{ $totalCategories }}" data-suffix="+">{{ $totalCategories }}+</span>
                        <span class="stat-label">Jenis Layanan</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="{{ $totalProducts }}" data-suffix="+">{{ $totalProducts }}+</span>
                        <span class="stat-label">Produk Digital</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="{{ $totalUsers }}" data-suffix="+">{{ $totalUsers }}+</span>
                        <span class="stat-label">Konsumen</span>
                    </div>
                </div>

            </div>

            {{-- Hero visual: hidden on mobile via CSS --}}
            <div class="hero-visual animate-scale-in" style="animation-delay:.5s" aria-hidden="true">
                <div class="hero-card-float card-float-1"><i class="fas fa-code"></i> Software Dev</div>
                <div class="hero-card-float card-float-2"><i class="fas fa-robot"></i> AI Solutions</div>
                <div class="hero-card-float card-float-3"><i class="fas fa-network-wired"></i> IoT & Mobile</div>
                <svg class="hero-ring" viewBox="0 0 400 400" fill="none">
                    <circle cx="200" cy="200" r="160" stroke="url(#ringGrad)" stroke-width="1.5" stroke-dasharray="12 6" />
                    <circle cx="200" cy="200" r="110" stroke="url(#ringGrad)" stroke-width="1" stroke-dasharray="6 8"
                        opacity=".5" />
                    <circle cx="200" cy="200" r="60" fill="url(#centerGrad)" opacity=".15" />
                    <defs>
                        <linearGradient id="ringGrad" x1="0" y1="0" x2="400" y2="400">
                            <stop offset="0%" stop-color="#0a2540" />
                            <stop offset="100%" stop-color="#2c6b9e" />
                        </linearGradient>
                        <radialGradient id="centerGrad">
                            <stop offset="0%" stop-color="#0a2540" />
                            <stop offset="100%" stop-color="transparent" />
                        </radialGradient>
                    </defs>
                </svg>
                <div class="hero-center-icon"><i class="fas fa-laptop-code"></i></div>
            </div>

        </div>

        <div class="hero-scroll-hint" aria-hidden="true">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- ==================== ABOUT ==================== -->
    <section class="section-about">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag">Tentang Kami</span>
                <h2>
                    Membangun Teknologi,<br>
                    <span class="gradient-text">Membangun Masa Depan</span>
                </h2>
                <p class="section-desc">
                    Nepertech adalah Teaching Factory (TEFA)
                    software development profesional di bawah
                    BLUD SMKN 1 Cirebon — bukan sekadar
                    membangun teknologi, tapi juga mencetak
                    talenta digital Indonesia.
                </p>
            </div>

            <div class="grid-3 stagger-children">

                <div class="card card-hover reveal" style="transition-delay:.0s">
                    <div class="card-icon-wrap">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Teaching Factory</h3>
                    <p>
                        Seluruh produk dikerjakan oleh siswa-siswi kompeten
                        di bawah bimbingan tenaga pendidik dan standar industri nyata.
                    </p>
                </div>

                <div class="card card-hover reveal" style="transition-delay:.12s">
                    <div class="card-icon-wrap">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3>Smart Technology</h3>
                    <p>
                        Solusi komprehensif mulai dari website, mobile, desktop,
                        game, IoT, hingga aplikasi berbasis AI yang relevan dengan kebutuhan pasar.
                    </p>
                </div>

                <div class="card card-hover reveal" style="transition-delay:.24s">
                    <div class="card-icon-wrap">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3>BLUD SMKN 1 Cirebon</h3>
                    <p>
                        Secara resmi berada di bawah naungan BLUD SMKN 1 Cirebon
                        dengan standar profesional industri dan komitmen kualitas tinggi.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== LAYANAN ==================== -->
    <section class="section-alt">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag">Produk & Layanan</span>
                <h2>Solusi <span class="gradient-text">Teknologi Lengkap</span></h2>
                <p class="section-desc">
                    {{ $categories->count() }} lini layanan dirancang untuk memenuhi kebutuhan teknologi bisnis Anda secara menyeluruh.
                </p>
            </div>

            <div class="grid-3">

                @forelse($categories as $cat)
                <div class="card card-program reveal" style="transition-delay:{{ $loop->index * 0.12 }}s">
                    <div class="card-program-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="card-icon-wrap">
                        <i class="{{ $cat->icon ?? 'fas fa-layer-group' }}"></i>
                    </div>
                    <h3>{{ $cat->name }}</h3>
                    <p>
                        {{ $cat->products_count }} produk tersedia dalam kategori ini.
                    </p>
                    <a href="{{ url('/layanan') }}" class="card-link">
                        Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @empty
                <div class="card card-program reveal">
                    <div class="card-icon-wrap">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3>Segera Hadir</h3>
                    <p>Layanan sedang disiapkan. Nantikan update terbaru.</p>
                </div>
                @endforelse

            </div>
        </div>
    </section>

@endsection