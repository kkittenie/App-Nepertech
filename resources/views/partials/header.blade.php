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
                <a href="{{ url('/project') }}" class="nav-link {{ request()->is('project') || request()->is('project/*') ? 'active' : '' }}">

                    Produk

                </a>
            </li>

            <li>
                <a href="{{ url('/layanan') }}" class="nav-link {{ request()->is('layanan') ? 'active' : '' }}">

                    Layanan

                </a>
            </li>

            <li>
                <a href="{{ url('/kontak') }}" class="nav-link {{ request()->is('kontak') ? 'active' : '' }}">

                    Kontak

                </a>
            </li>

            @guest
                <li>
                    <a href="{{ url('/register') }}"
                        class="nav-link btn-nav-cta {{ request()->is('register') ? 'active' : '' }}">

                        Daftar

                    </a>
                </li>
            @endguest

            @auth
                <li>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}"
                            class="nav-profile-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="nav-avatar-img">
                            @else
                                <div class="nav-avatar-icon"><i class="fas fa-user-circle"></i></div>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('profile') }}"
                            class="nav-profile-link {{ request()->is('profile') ? 'active' : '' }}">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="nav-avatar-img">
                            @else
                                <div class="nav-avatar-icon"><i class="fas fa-user-circle"></i></div>
                            @endif
                        </a>
                    @endif
                </li>
            @endauth

        </ul>

    </div>

</nav>