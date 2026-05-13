@extends('layouts.landing')

@section('content')

    <section class="page-hero">

        <div class="page-hero-bg"></div>

        <div class="container">

            <span class="section-tag animate-fade-up">
                Support
            </span>

            <h1 class="animate-fade-up" style="animation-delay:.15s">

                Hubungi Kami

            </h1>

            <p class="page-hero-sub animate-fade-up" style="animation-delay:.3s">

                Tim Nepertech siap membantu Anda

            </p>

        </div>

    </section>

    <div class="container">

        <!-- INFO KONTAK -->
        <section>

            <div class="grid-3">

                <!-- CARD 1 -->
                <div class="card reveal" style="transition-delay:0s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>

                    <h3>Alamat</h3>

                    <p>
                        BLUD SMKN 1 Cirebon<br>
                        Kota Cirebon, Jawa Barat
                    </p>

                </div>

                <!-- CARD 2 -->
                <div class="card reveal" style="transition-delay:.12s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-phone-alt"></i>
                    </div>

                    <h3>Telepon</h3>

                    <p>
                        +62 XXX XXXX XXXX<br>
                        Senin–Jumat 08.00–16.00
                    </p>

                </div>

                <!-- CARD 3 -->
                <div class="card reveal" style="transition-delay:.24s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-envelope"></i>
                    </div>

                    <h3>Email</h3>

                    <p>
                        info@nepertech.id<br>
                        project@nepertech.id
                    </p>

                </div>

            </div>

        </section>

        <!-- FORM -->
        <section>

            <div class="kontak-grid reveal">

                <!-- FORM CARD -->
                <div class="card">

                    <h3>
                        Kirim
                        <span class="gradient-text">
                            Pesan
                        </span>
                    </h3>

                    <form id="contactForm" class="contact-form">

                        <input type="text" placeholder="Nama Lengkap / Instansi" required>

                        <input type="email" placeholder="Alamat Email" required>

                        <textarea rows="5" placeholder="Ceritakan kebutuhan proyek Anda..." required></textarea>

                        <button type="submit" class="btn btn-primary">

                            Kirim Pesan
                            <i class="fas fa-paper-plane"></i>

                        </button>

                    </form>

                </div>

                <!-- MAP -->
                <div class="map-wrap">

                    <iframe width="100%" height="100%" style="border:0;min-height:300px;" loading="lazy"
                        src="https://maps.google.com/maps?q=SMKN+1+Cirebon&t=&z=15&ie=UTF8&iwloc=&output=embed">

                    </iframe>

                </div>

            </div>

        </section>

    </div>

@endsection