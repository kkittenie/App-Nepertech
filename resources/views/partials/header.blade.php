<nav class="navbar" id="navbar">

    <div class="nav-container">

        <a href="{{ url('/') }}" class="logo">

            <img src="{{ asset('images/logo.png') }}" alt="Nepertech" class="nav-logo-img" onerror="this.style.display='none';
                 this.nextElementSibling.style.display='block'">

            <span class="nav-logo-fallback" style="display:none;">

                NP

            </span>

            <span class="nav-logo-name">
                Nepertech
            </span>

        </a>

        <div class="menu-icon" id="menuIcon">
            <i class="fas fa-bars"></i>
        </div>

        <ul class="nav-links" id="navLinks">

            <li>
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">

                    Beranda

                </a>
            </li>

            <li>
                <a href="{{ url('/profil') }}" class="nav-link {{ request()->is('profil') ? 'active' : '' }}">

                    Profil

                </a>
            </li>

            <li>
                <a href="{{ url('/layanan') }}" class="nav-link {{ request()->is('layanan') ? 'active' : '' }}">

                    Layanan

                </a>
            </li>

            <li>
                <a href="{{ url('/fasilitas') }}" class="nav-link {{ request()->is('fasilitas') ? 'active' : '' }}">

                    Fasilitas

                </a>
            </li>

            <li>
                <a href="{{ url('/galeri') }}" class="nav-link {{ request()->is('galeri') ? 'active' : '' }}">

                    Galeri

                </a>
            </li>

            <li>
                <a href="{{ url('/kontak') }}" class="nav-link {{ request()->is('kontak') ? 'active' : '' }}">

                    Kontak

                </a>
            </li>

            @guest
                <li>
                    <a href="{{ url('/pendaftaran') }}"
                        class="nav-link btn-nav-cta {{ request()->is('pendaftaran') ? 'active' : '' }}">

                        Daftar

                    </a>
                </li>
            @endguest

            @auth
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="nav-profile-link {{ request()->is('dashboard') ? 'active' : '' }}">

                        <i class="fas fa-user-circle"></i>

                    </a>
                </li>
            @endauth

        </ul>

    </div>

</nav>