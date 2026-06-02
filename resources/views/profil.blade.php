@extends('layouts.landing')

@section('content')

    <section class="page-hero">
        <div class="page-hero-bg"></div>

        <div class="container">

            <div>
                <h1 class="animate-fade-up" style="animation-delay:.15s">
                    Profil Nepertech
                </h1>

                <p class="page-hero-sub animate-fade-up" style="animation-delay:.3s">
                    Teaching Factory Software Development · BLUD SMKN 1 Cirebon
                </p>
            </div>

            <div class="page-hero-visual" aria-hidden="true">
                <div class="page-hero-ring page-hero-ring-1"></div>
                <div class="page-hero-ring page-hero-ring-2"></div>
                <div class="page-hero-center"><i class="fas fa-building"></i></div>
                <div class="page-hero-float page-hero-float-1"><i class="fas fa-users"></i> TEFA Team</div>
                <div class="page-hero-float page-hero-float-2"><i class="fas fa-award"></i> Profesional</div>
                <div class="page-hero-float page-hero-float-3"><i class="fas fa-school"></i> SMKN 1</div>
                <div class="page-hero-dot page-hero-dot-1"></div>
                <div class="page-hero-dot page-hero-dot-2"></div>
                <div class="page-hero-dot page-hero-dot-3"></div>
            </div>

        </div>
    </section>

    <div class="container">

        <!-- Tentang -->
        <section>

            <div class="profil-sambutan reveal">

                <div class="sambutan-icon-wrap">
                    <i class="fas fa-laptop-code"></i>
                </div>

                <div>

                    <span class="section-tag">
                        Tentang Kami
                    </span>

                    <h2 style="margin-bottom:16px">
                        Apa itu Nepertech?
                    </h2>

                    <blockquote>
                        "Kami bukan hanya membangun teknologi —
                        kami juga membangun masa depan talenta
                        digital Indonesia."
                    </blockquote>

                    <p style="margin-top:16px;line-height:1.8;">

                        Nepertech adalah
                        <strong>Teaching Factory (TEFA)</strong>
                        yang bergerak di bidang Software Development
                        profesional, secara resmi berada di bawah
                        naungan
                        <strong>BLUD SMKN 1 Cirebon</strong>.

                        Kami berfokus pada penyediaan solusi
                        teknologi cerdas dan komprehensif —
                        mulai dari website, aplikasi mobile,
                        desktop, game, IoT, hingga aplikasi
                        berbasis AI.

                    </p>

                    <p style="margin-top:12px;line-height:1.8;">

                        Inti kekuatan kami terletak pada model
                        bisnis TEFA, di mana seluruh produk
                        dikerjakan dan didesain oleh siswa-siswi
                        kompeten di bawah bimbingan tenaga pendidik
                        dan standar industri nyata.

                    </p>

                </div>

            </div>

        </section>

        <!-- VISI MISI -->
        <section>

            <div class="section-header reveal" style="text-align:left;margin-bottom:40px">

                <span class="section-tag">
                    Visi & Misi
                </span>

                <h2>
                    Arah &
                    <span class="gradient-text">
                        Tujuan
                    </span>
                </h2>

            </div>

            <div class="visi-misi-grid reveal">

                <!-- VISI -->
                <div class="card visi-card">

                    <div class="card-icon-wrap">
                        <i class="fas fa-eye"></i>
                    </div>

                    <h3>Visi</h3>

                    <p style="font-size:16px;line-height:1.8;color:var(--text);">

                        Menjadi pengembang perangkat lunak
                        berbasis pendidikan yang
                        <strong>
                            terdepan, terpercaya, dan inovatif
                        </strong>,

                        serta menjadi pusat unggulan
                        (<em>center of excellence</em>)
                        dalam penyiapan dan pengembangan
                        talenta muda digital yang berdaya
                        saing global.

                    </p>

                </div>

                <!-- MISI -->
                <div class="card">

                    <div class="card-icon-wrap">
                        <i class="fas fa-rocket"></i>
                    </div>

                    <h3>Misi</h3>

                    <ul class="misi-list">

                        <li>
                            <i class="fas fa-check-circle"></i>

                            Menciptakan produk perangkat lunak
                            yang cerdas (<em>smart tech</em>)
                            dan berkualitas tinggi serta
                            memberikan solusi teknologi
                            komprehensif (website, mobile,
                            game, IoT, dan AI) yang relevan
                            dengan kebutuhan pasar.
                        </li>

                        <li>
                            <i class="fas fa-check-circle"></i>

                            Menyelenggarakan proses kerja
                            profesional berbasis standar
                            industri untuk meningkatkan
                            kompetensi dan pengalaman praktis
                            siswa-siswi SMKN 1 Cirebon.
                        </li>

                        <li>
                            <i class="fas fa-check-circle"></i>

                            Membangun kemitraan dan kepercayaan
                            pelanggan melalui komitmen terhadap
                            kualitas, pengerjaan proyek yang
                            profesional, dan pelayanan purna
                            jual yang andal.
                        </li>

                    </ul>

                </div>

            </div>

        </section>

    </div>

    <!-- NILAI PERUSAHAAN -->
    <!-- NILAI PERUSAHAAN -->
    <section class="nilai-carousel-section reveal">

        <div class="container">

            <div class="section-header" style="margin-bottom:48px">

                <span class="section-tag">
                    Nilai Perusahaan
                </span>

                <h2>
                    Panduan
                    <span class="gradient-text">
                        Setiap Langkah
                    </span>
                </h2>

                <p class="section-desc">
                    Empat nilai inti yang menjadi fondasi
                    dalam setiap proses kerja Nepertech.
                </p>

            </div>

            <div class="carousel-wrapper">

                <!-- NAV -->
                <button class="carousel-btn carousel-btn-prev" aria-label="Sebelumnya">

                    <i class="fas fa-chevron-left"></i>

                </button>

                <button class="carousel-btn carousel-btn-next" aria-label="Berikutnya">

                    <i class="fas fa-chevron-right"></i>

                </button>

                <!-- TRACK -->
                <div class="nilai-carousel-track" tabindex="0">

                    <!-- CARD 1 -->
                    <div class="nilai-card nilai-card-active" style="--idx:0">

                        <div class="nilai-card-number">
                            01
                        </div>

                        <div class="nilai-card-icon-wrap">
                            <i class="fas fa-graduation-cap"></i>
                        </div>

                        <h3 class="nilai-card-title">
                            Educational Excellence
                        </h3>

                        <p class="nilai-card-desc">

                            Berkomitmen menjadi lingkungan
                            belajar profesional yang memastikan
                            transfer pengetahuan dan keterampilan
                            industri terbaik, menghasilkan lulusan
                            siap kerja dan berdaya saing global.

                        </p>

                        <div class="nilai-card-bar"></div>

                    </div>

                    <!-- CARD 2 -->
                    <div class="nilai-card" style="--idx:1">

                        <div class="nilai-card-number">
                            02
                        </div>

                        <div class="nilai-card-icon-wrap">
                            <i class="fas fa-lightbulb"></i>
                        </div>

                        <h3 class="nilai-card-title">
                            Innovation
                        </h3>

                        <p class="nilai-card-desc">

                            Selalu mencari solusi kreatif
                            dan menguasai teknologi terbaru
                            untuk memberikan produk yang
                            cerdas dan mutakhir kepada pasar.

                        </p>

                        <div class="nilai-card-bar"></div>

                    </div>

                    <!-- CARD 3 -->
                    <div class="nilai-card" style="--idx:2">

                        <div class="nilai-card-number">
                            03
                        </div>

                        <div class="nilai-card-icon-wrap">
                            <i class="fas fa-handshake"></i>
                        </div>

                        <h3 class="nilai-card-title">
                            Collaboration
                        </h3>

                        <p class="nilai-card-desc">

                            Mendorong sinergi dan komunikasi
                            efektif di dalam tim, serta
                            membangun kerja sama harmonis
                            dengan klien dan mitra untuk
                            mencapai tujuan bersama.

                        </p>

                        <div class="nilai-card-bar"></div>

                    </div>

                    <!-- CARD 4 -->
                    <div class="nilai-card" style="--idx:3">

                        <div class="nilai-card-number">
                            04
                        </div>

                        <div class="nilai-card-icon-wrap">
                            <i class="fas fa-shield-alt"></i>
                        </div>

                        <h3 class="nilai-card-title">
                            Professionalism
                        </h3>

                        <p class="nilai-card-desc">

                            Bekerja dengan disiplin,
                            tanggung jawab, dan standar
                            layanan terbaik, mencerminkan
                            komitmen kami sebagai bagian
                            dari Teaching Factory.

                        </p>

                        <div class="nilai-card-bar"></div>

                    </div>

                </div>

                <!-- DOTS -->
                <div class="carousel-dots"></div>

            </div>

            <!-- PROGRESS -->
            <div class="carousel-progress-wrap">

                <div class="carousel-progress-line">

                    <div class="carousel-progress-fill"></div>

                </div>

            </div>

        </div>

    </section>

    <div class="container">

        <!-- Struktur Organisasi -->
        <section>

            <div class="section-header reveal">

                <span class="section-tag">
                    Tim Kami
                </span>

                <h2>
                    Struktur
                    <span class="gradient-text">
                        Organisasi
                    </span>
                </h2>

                <p class="section-desc">
                    Jajaran kepemimpinan dan tim yang menggerakkan Nepertech.
                </p>

            </div>

            @if($structures->count() > 0)

            @php
                $topMembers = $structures->take(3);
                $bottomMembers = $structures->slice(3);
            @endphp

            <div class="org-chart reveal">

                {{-- Top 3 members: each displayed individually, stacked vertically --}}
                @foreach($topMembers as $idx => $member)

                <div class="org-top">
                    <div class="org-card {{ $idx === 0 ? 'org-card-leader' : '' }}">
                        <div class="org-card-avatar">
                            @if($member->image)
                                <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                            @else
                                <div class="org-card-avatar-fallback">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="org-card-name">{{ $member->name }}</h3>
                        <p class="org-card-position">{{ $member->position }}</p>
                        <div class="org-card-bar"></div>
                    </div>
                </div>

                {{-- Connector line between each top member --}}
                @if(!$loop->last || $bottomMembers->count() > 0)
                <div class="org-connector">
                    <div class="org-connector-line"></div>
                </div>
                @endif

                @endforeach

                {{-- Bottom members: 4+ displayed in rows of 3 --}}
                @if($bottomMembers->count() > 0)

                <div class="org-members org-cols-{{ min(3, $bottomMembers->count()) }}">
                    @foreach($bottomMembers as $member)
                    <div class="org-member-col">
                        <div class="org-member-vline"></div>
                        <div class="org-card">
                            <div class="org-card-avatar">
                                @if($member->image)
                                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                                @else
                                    <div class="org-card-avatar-fallback">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="org-card-name">{{ $member->name }}</h3>
                            <p class="org-card-position">{{ $member->position }}</p>
                            <div class="org-card-bar"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @endif

            </div>

            @else

            <div class="reveal" style="text-align:center; padding:60px 20px; color:var(--text-muted);">
                <i class="fas fa-users" style="font-size:48px; opacity:0.3; margin-bottom:16px; display:block;"></i>
                <p>Data struktur organisasi belum tersedia.</p>
            </div>

            @endif

        </section>

    </div>

@endsection