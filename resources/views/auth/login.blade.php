@extends('layouts.landing')

@section('content')

    <div class="auth-page-wrap">

        {{-- Animated background --}}
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
        <div class="bg-orb bg-orb-3"></div>
        <div class="bg-noise"></div>
        <div class="particles" id="particles"></div>

        <div class="auth-card" style="max-width: 480px; margin: 100px auto 60px;">

            {{-- ===== RIGHT PANEL (NOW MAIN FORM) ===== --}}
            <div class="auth-right" style="width: 100%;">
                <div class="auth-heading">Selamat Datang</div>
                <p class="auth-sub">
                    Belum punya akun?
                    <a href="{{ route('register') }}">Daftar sekarang →</a>
                </p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email / Username --}}
                    <div class="auth-form-group">
                        <label class="auth-form-label" for="login">Email atau Username</label>

                        <div class="auth-input-wrap">
                            <input type="text" id="login" name="login"
                                class="auth-input no-right-icon @error('login') is-invalid @enderror"
                                placeholder="Masukkan email atau username" value="{{ old('login') }}"
                                autocomplete="username" autofocus>

                            <i class="fas fa-user auth-input-icon"></i>
                        </div>

                        @error('login')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="auth-form-group">
                        <label class="auth-form-label" for="password">Password</label>
                        <div class="auth-input-wrap">
                            <input type="password" id="password" name="password"
                                class="auth-input @error('password') is-invalid @enderror" placeholder="Password Anda"
                                autocomplete="current-password">
                            <i class="fas fa-lock auth-input-icon"></i>
                            <button class="auth-toggle-pw" type="button" onclick="togglePw('password', 'eyeIcon')">
                                <i class="fas fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Remember me + Forgot password --}}
                    <div class="auth-check-row">
                        <label class="auth-check-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Ingat saya
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-forgot-link">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="auth-btn-submit">
                        Masuk <i class="fas fa-arrow-right"></i>
                    </button>

                </form>

            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    /* ---- Floating particles ---- */
    (function () {
        const container = document.getElementById('particles');
        const style = document.createElement('style');
        style.textContent = `
        @keyframes particleRise {
            0%   { transform: translateY(0) scale(1); opacity: .12 }
            80%  { opacity: .04 }
            100% { transform: translateY(-105vh) scale(.5); opacity: 0 }
        }
    `;
        document.head.appendChild(style);

        for (let i = 0; i < 18; i++) {
            const p = document.createElement('div');
            const size = Math.random() * 6 + 3;
            const x = Math.random() * 100;
            const delay = Math.random() * 12;
            const dur = Math.random() * 20 + 15;
            const opacity = Math.random() * .2 + .04;
            p.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(44,107,158,.2);
            width: ${size}px; height: ${size}px;
            left: ${x}%; bottom: -${size}px;
            opacity: ${opacity};
            animation: particleRise ${dur}s linear ${delay}s infinite;
        `;
            container.appendChild(p);
        }
    })();

    /* ---- Password visibility toggle ---- */
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye-slash';
        }
    }
</script>