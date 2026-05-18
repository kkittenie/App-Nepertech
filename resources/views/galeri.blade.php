@extends('layouts.landing')

@section('content')

    <section class="page-hero">

        <div class="page-hero-bg"></div>

        <div class="container">

            <div>
                <span class="section-tag animate-fade-up">
                    Dokumentasi
                </span>

                <h1 class="animate-fade-up" style="animation-delay:.15s">
                    Galeri Kegiatan
                </h1>

                <p class="page-hero-sub animate-fade-up" style="animation-delay:.3s">
                    Momen inspiratif tim Nepertech
                </p>
            </div>

            <div class="page-hero-visual" aria-hidden="true">
                <div class="page-hero-ring page-hero-ring-1"></div>
                <div class="page-hero-ring page-hero-ring-2"></div>
                <div class="page-hero-center"><i class="fas fa-camera"></i></div>
                <div class="page-hero-float page-hero-float-1"><i class="fas fa-image"></i> Gallery</div>
                <div class="page-hero-float page-hero-float-2"><i class="fas fa-video"></i> Moments</div>
                <div class="page-hero-float page-hero-float-3"><i class="fas fa-star"></i> Highlights</div>
                <div class="page-hero-dot page-hero-dot-1"></div>
                <div class="page-hero-dot page-hero-dot-2"></div>
                <div class="page-hero-dot page-hero-dot-3"></div>
            </div>

        </div>

    </section>

    <div class="container" style="padding:60px 24px">

        <div class="gallery-grid reveal">

            <!-- ITEM 1 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1011/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

            <!-- ITEM 2 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1015/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

            <!-- ITEM 3 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1016/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

            <!-- ITEM 4 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1020/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

            <!-- ITEM 5 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1024/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

            <!-- ITEM 6 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1035/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

            <!-- ITEM 7 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1039/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

            <!-- ITEM 8 -->
            <div class="gallery-item">

                <img src="https://picsum.photos/id/1040/600/400" alt="galeri" loading="lazy">

                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                </div>

            </div>

        </div>

    </div>

@endsection