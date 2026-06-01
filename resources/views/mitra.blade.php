@extends('layouts.landing')

@section('content')

    <section class="page-hero">

        <div class="page-hero-bg"></div>

        <div class="container">

            <div>
                <h1 class="animate-fade-up" style="animation-delay:.15s">
                    Mitra Industri Kami
                </h1>

                <p class="page-hero-sub animate-fade-up" style="animation-delay:.3s">
                    Dunia Industri Pengembangan Perangkat Lunak dan Gim adalah sektor ekonomi yang berkaitan dengan menciptakan, merancang, mengembangkan, dan menghasilkan perangkat lunak dan gim yang digunakan di berbagai perangkat elektronik.
                </p>
            </div>

            <div class="page-hero-visual" aria-hidden="true">
                <div class="page-hero-ring page-hero-ring-1"></div>
                <div class="page-hero-ring page-hero-ring-2"></div>
                <div class="page-hero-center"><i class="fas fa-handshake"></i></div>
                <div class="page-hero-float page-hero-float-1"><i class="fas fa-building"></i> Mitra</div>
                <div class="page-hero-float page-hero-float-2"><i class="fas fa-network-wired"></i> Sinergi</div>
                <div class="page-hero-float page-hero-float-3"><i class="fas fa-lightbulb"></i> Inovasi</div>
                <div class="page-hero-dot page-hero-dot-1"></div>
                <div class="page-hero-dot page-hero-dot-2"></div>
                <div class="page-hero-dot page-hero-dot-3"></div>
            </div>

        </div>

    </section>

    <div class="container">

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; padding: 80px 0;">

            @forelse($mitras as $index => $mitra)
                <div class="card reveal" style="transition-delay:{{ ($index % 4) * 0.12 }}s; text-align: center; padding: 40px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 200px;">
                    @if($mitra->logo)
                        <div style="width: 120px; height: 80px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                    @else
                        <div style="width: 64px; height: 64px; border-radius: 16px; background: rgba(10,37,64,0.05); display: flex; align-items: center; justify-content: center; font-size: 24px; color: var(--primary); margin-bottom: 20px;">
                            <i class="fas fa-building"></i>
                        </div>
                    @endif
                    <h3 style="margin: 0; font-size: 1.25rem;">{{ $mitra->name }}</h3>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);">
                    <i class="fas fa-building" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px; display: block;"></i>
                    <h3 style="margin-bottom: 8px;">Belum ada mitra industri</h3>
                    <p style="margin: 0;">Data mitra industri akan segera ditampilkan.</p>
                </div>
            @endforelse

        </div>

    </div>

@endsection