@extends('layouts.landing')

@section('content')

    <section class="page-hero">

        <div class="page-hero-bg"></div>

        <div class="container">

            <div>
                <span class="section-tag animate-fade-up">
                    Products & Services
                </span>

                <h1 class="animate-fade-up" style="animation-delay:.15s">

                    Layanan Kami

                </h1>

                <p class="page-hero-sub animate-fade-up" style="animation-delay:.3s">

                    {{ $categories->count() }} layanan & {{ $products->count() }} produk dari
                    tim TEFA profesional

                </p>
            </div>

            <div class="page-hero-visual" aria-hidden="true">
                <div class="page-hero-ring page-hero-ring-1"></div>
                <div class="page-hero-ring page-hero-ring-2"></div>
                <div class="page-hero-center"><i class="fas fa-cogs"></i></div>
                <div class="page-hero-float page-hero-float-1"><i class="fas fa-code"></i> Development</div>
                <div class="page-hero-float page-hero-float-2"><i class="fas fa-robot"></i> AI & IoT</div>
                <div class="page-hero-float page-hero-float-3"><i class="fas fa-mobile-alt"></i> Mobile</div>
                <div class="page-hero-dot page-hero-dot-1"></div>
                <div class="page-hero-dot page-hero-dot-2"></div>
                <div class="page-hero-dot page-hero-dot-3"></div>
            </div>

        </div>

    </section>

    <div class="container">

        <!-- LAYANAN -->
        <section>

            <div class="grid-3">

                @forelse($categories as $cat)
                <div class="card card-program reveal" style="transition-delay:{{ $loop->index * 0.12 }}s">

                    <div class="card-program-num">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="card-icon-wrap">
                        <i class="fas fa-layer-group"></i>
                    </div>

                    <h3>{{ $cat->name }}</h3>

                    <p>
                        {{ $cat->products_count }} produk tersedia.
                        Dikerjakan oleh tim TEFA profesional.
                    </p>

                    <div class="cert-badge">
                        <i class="fas fa-check-circle"></i>
                        Dikerjakan Tim TEFA Profesional
                    </div>

                </div>
                @empty
                <div class="card card-program reveal">
                    <div class="card-icon-wrap">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3>Segera Hadir</h3>
                    <p>Layanan sedang disiapkan.</p>
                </div>
                @endforelse

            </div>

        </section>

        <!-- KEUNGGULAN -->
        <section>

            <div class="section-header reveal">

                <span class="section-tag">
                    Keunggulan Kami
                </span>

                <h2>
                    Mengapa Pilih
                    <span class="gradient-text">
                        Nepertech?
                    </span>
                </h2>

            </div>

            <div class="grid-3">

                <!-- CARD 1 -->
                <div class="card reveal" style="transition-delay:0s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-users"></i>
                    </div>

                    <h3>Tim Terlatih</h3>

                    <p>
                        Siswa-siswi kompeten yang
                        dibimbing langsung oleh tenaga
                        pendidik berpengalaman dan
                        praktisi industri.
                    </p>

                </div>

                <!-- CARD 2 -->
                <div class="card reveal" style="transition-delay:.12s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-dollar-sign"></i>
                    </div>

                    <h3>Harga Kompetitif</h3>

                    <p>
                        Sebagai TEFA pendidikan, kami
                        menawarkan solusi berkualitas
                        dengan harga lebih terjangkau
                        dibanding vendor komersial.
                    </p>

                </div>

                <!-- CARD 3 -->
                <div class="card reveal" style="transition-delay:.24s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-headset"></i>
                    </div>

                    <h3>Purna Jual Andal</h3>

                    <p>
                        Dukungan teknis dan layanan
                        after-sales yang responsif untuk
                        memastikan produk berjalan optimal.
                    </p>

                </div>

            </div>

        </section>

    </div>

@endsection