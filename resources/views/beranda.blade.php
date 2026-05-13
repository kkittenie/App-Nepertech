@extends('layouts.app')

@section('content')

    <section class="hero">
        <div class="hero-lines"></div>
        <div class="hero-noise"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-inner">
            <div class="hero-content">

                <div class="hero-accent-line"></div>

                <div class="hero-eyebrow">
                    <div class="hero-badge">
                        <span class="hero-badge-dot"></span>
                        TEFA · BLUD SMKN 1 Cirebon
                    </div>
                </div>

                <h1 class="hero-title">
                    Solusi Teknologi oleh<br>
                    <span class="gradient-text">
                        Talenta <em>Masa Depan</em>
                    </span>
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

                        <span class="stat-number" data-target="5" data-suffix="+">

                            5+

                        </span>

                        <span class="stat-label">
                            Jenis Layanan
                        </span>

                    </div>

                    <div class="stat-divider"></div>

                    <div class="stat-item">

                        <span class="stat-number" data-target="100" data-suffix="+">

                            100+

                        </span>

                        <span class="stat-label">
                            Siswa Aktif
                        </span>

                    </div>

                    <div class="stat-divider"></div>

                    <div class="stat-item">

                        <span class="stat-number" data-target="10" data-suffix="th">

                            10th

                        </span>

                        <span class="stat-label">
                            Pengalaman
                        </span>

                    </div>

                </div>

            </div>
        </div>

        <div class="hero-visual animate-scale-in" style="animation-delay:.5s">
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

        <div class="hero-scroll-hint">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- About -->
    <section class="section-about">
        <div class="container">

            <div class="section-header reveal">
                <span class="section-tag">Tentang Kami</span>

                <h2>
                    Membangun Teknologi,<br>
                    <span class="gradient-text">
                        Membangun Masa Depan
                    </span>
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

                <!-- CARD 1 -->
                <div class="card card-hover reveal" style="transition-delay:.0s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-bullseye"></i>
                    </div>

                    <h3>Teaching Factory</h3>

                    <p>
                        Seluruh produk dikerjakan oleh
                        siswa-siswi kompeten di bawah
                        bimbingan tenaga pendidik dan
                        standar industri nyata.
                    </p>

                    <a href="{{ url('/profil') }}" class="card-link">
                        Selengkapnya
                        <i class="fas fa-arrow-right"></i>
                    </a>

                </div>

                <!-- CARD 2 -->
                <div class="card card-hover reveal" style="transition-delay:.12s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-microchip"></i>
                    </div>

                    <h3>Smart Technology</h3>

                    <p>
                        Solusi komprehensif mulai dari
                        website, mobile, desktop, game,
                        IoT, hingga aplikasi berbasis AI
                        yang relevan dengan kebutuhan pasar.
                    </p>

                    <a href="{{ url('/profil') }}" class="card-link">
                        Selengkapnya
                        <i class="fas fa-arrow-right"></i>
                    </a>

                </div>

                <!-- CARD 3 -->
                <div class="card card-hover reveal" style="transition-delay:.24s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-medal"></i>
                    </div>

                    <h3>BLUD SMKN 1 Cirebon</h3>

                    <p>
                        Secara resmi berada di bawah
                        naungan BLUD SMKN 1 Cirebon
                        dengan standar profesional industri
                        dan komitmen kualitas tinggi.
                    </p>

                    <a href="{{ url('/profil') }}" class="card-link">
                        Selengkapnya
                        <i class="fas fa-arrow-right"></i>
                    </a>

                </div>

            </div>
        </div>
    </section>

    <!-- Layanan -->
    <section class="section-alt">
        <div class="container">
            <div class="section-header reveal">
                <span class="section-tag">Produk & Layanan</span>
                <h2>Solusi <span class="gradient-text">Teknologi Lengkap</span></h2>
                <p class="section-desc">
                    Lima lini layanan dirancang untuk memenuhi kebutuhan teknologi bisnis Anda secara menyeluruh.
                </p>
            </div>

            <div class="grid-3">

                <!-- CARD 1 -->
                <div class="card card-program reveal" style="transition-delay:.0s">
                    <div class="card-program-num">01</div>

                    <div class="card-icon-wrap">
                        <i class="fas fa-globe"></i>
                    </div>

                    <h3>Website Development</h3>

                    <p>
                        Perancangan dan pengembangan website profesional,
                        responsif, dan SEO-friendly.
                    </p>

                    <a href="{{ url('/layanan') }}" class="card-link">
                        Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- CARD 2 -->
                <div class="card card-program reveal" style="transition-delay:.12s">
                    <div class="card-program-num">02</div>

                    <div class="card-icon-wrap">
                        <i class="fas fa-mobile-alt"></i>
                    </div>

                    <h3>Mobile App</h3>

                    <p>
                        Aplikasi mobile inovatif dan intuitif
                        untuk Android & iOS.
                    </p>

                    <a href="{{ url('/layanan') }}" class="card-link">
                        Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- CARD 3 -->
                <div class="card card-program reveal" style="transition-delay:.24s">
                    <div class="card-program-num">03</div>

                    <div class="card-icon-wrap">
                        <i class="fas fa-desktop"></i>
                    </div>

                    <h3>Desktop Development</h3>

                    <p>
                        Aplikasi desktop custom yang stabil
                        dan andal untuk bisnis.
                    </p>

                    <a href="{{ url('/layanan') }}" class="card-link">
                        Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>

@endsection