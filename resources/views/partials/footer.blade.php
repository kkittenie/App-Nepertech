<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col footer-brand">
                <div class="footer-logo">
                    <img src="images/logo.png" alt="Nepertech"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                    <span style="display:none;"></span>
                    <span class="footer-logo-name">Nepertech</span>
                </div>
                <p>Teaching Factory Software Development profesional di bawah BLUD SMKN 1 Cirebon. Membangun teknologi,
                    membangun masa depan.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                @forelse(\App\Models\Category::all() as $cat)
                    <a href="{{ url('/layanan') }}">{{ $cat->name }}</a>
                @empty
                    <a href="{{ url('/layanan') }}">Website Development</a>
                    <a href="{{ url('/layanan') }}">Mobile App</a>
                    <a href="{{ url('/layanan') }}">Desktop Development</a>
                    <a href="{{ url('/layanan') }}">Game Development</a>
                    <a href="{{ url('/layanan') }}">IoT Solutions</a>
                @endforelse
            </div>
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ url('/profil') }}">Profil</a>
                <a href="{{ url('/project') }}">Produk</a>
                <a href="{{ url('/layanan') }}">Layanan</a>
                <a href="{{ url('/mitra') }}">Mitra</a>
                <a href="{{ url('/kontak') }}">Kontak</a>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <p><i class="fas fa-map-marker-alt" style="margin-right:8px;color:var(--accent)"></i>SMKN 1 Cirebon, Jl. Perjuangan, Kota Cirebon, Jawa Barat 45132</p>
                <p><i class="fas fa-phone" style="margin-right:8px;color:var(--accent)"></i><a href="tel:+6285129935749" style="display:inline;padding:0;color:inherit;text-decoration:none;">+62 851 2993 5749</a></p>
                <p><i class="fas fa-envelope" style="margin-right:8px;color:var(--accent)"></i><a href="mailto:info@nepertech.id" style="display:inline;padding:0;color:inherit;text-decoration:none;">info@nepertech.id</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2025 Nepertech · BLUD SMKN 1 Cirebon · All rights reserved.</span>
            <span>Teaching Factory Software Development</span>
        </div>
    </div>
</footer>