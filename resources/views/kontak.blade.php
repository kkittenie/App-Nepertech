@extends('layouts.landing')

@section('content')

    <section class="page-hero">

        <div class="page-hero-bg"></div>

        <div class="container">

            <div>
                <h1 class="animate-fade-up" style="animation-delay:.15s">
                    Hubungi Kami
                </h1>

                <p class="page-hero-sub animate-fade-up" style="animation-delay:.3s">
                    Tim Nepertech siap membantu Anda
                </p>
            </div>

            <div class="page-hero-visual" aria-hidden="true">
                <div class="page-hero-ring page-hero-ring-1"></div>
                <div class="page-hero-ring page-hero-ring-2"></div>
                <div class="page-hero-center"><i class="fas fa-headset"></i></div>
                <div class="page-hero-float page-hero-float-1"><i class="fas fa-envelope"></i> Email</div>
                <div class="page-hero-float page-hero-float-2"><i class="fas fa-phone"></i> Telepon</div>
                <div class="page-hero-float page-hero-float-3"><i class="fas fa-map-marker-alt"></i> Cirebon</div>
                <div class="page-hero-dot page-hero-dot-1"></div>
                <div class="page-hero-dot page-hero-dot-2"></div>
                <div class="page-hero-dot page-hero-dot-3"></div>
            </div>

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
                        SMKN 1 Cirebon<br>
                        Jl. Perjuangan, Sunyaragi, Kec. Kesambi, Kota Cirebon, Jawa Barat 45132
                    </p>

                </div>

                <!-- CARD 2 -->
                <div class="card reveal" style="transition-delay:.12s">

                    <div class="card-icon-wrap">
                        <i class="fas fa-phone-alt"></i>
                    </div>

                    <h3>Telepon</h3>

                    <p>
                        +62 851 2993 5749 <br>
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
                        info@smkn1-cirebon.sch.id
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

                        <input type="text" id="contactName" placeholder="Nama Lengkap / Instansi" required>

                        <input type="email" id="contactEmail" placeholder="Alamat Email" required>

                        <textarea id="contactMessage" rows="5" placeholder="Ceritakan kebutuhan proyek Anda..." required></textarea>

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

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var name = document.getElementById('contactName').value;
        var email = document.getElementById('contactEmail').value;
        var message = document.getElementById('contactMessage').value;
        
        var subject = encodeURIComponent('Pesan dari ' + name);
        var body = encodeURIComponent('Nama/Instansi: ' + name + '\nEmail: ' + email + '\n\nPesan:\n' + message);
        
        window.location.href = 'mailto:info@nepertech.id?subject=' + subject + '&body=' + body;
    });
</script>
@endpush

@endsection