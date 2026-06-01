
@extends('layouts.landing')

@section('content')

    <div class="auth-page-wrap">

        {{-- Animated background --}}
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
        <div class="bg-orb bg-orb-3"></div>
        <div class="bg-noise"></div>
        <div class="particles" id="particles"></div>

        <div class="auth-card" style="max-width: 650px; margin: 0 auto;">

            {{-- ===== RIGHT PANEL (NOW MAIN FORM) ===== --}}
            <div class="auth-right" style="width: 100%;">
                <div class="auth-heading">Buat Akun</div>
                <p class="auth-sub">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Masuk →</a>
                </p>

                {{-- Progress bar --}}
                <div class="reg-progress">
                    <div class="reg-progress-label">
                        <span>Kelengkapan profil</span>
                        <span id="progressPct">0%</span>
                    </div>
                    <div class="reg-progress-track">
                        <div class="reg-progress-fill" id="progressFill"></div>
                    </div>
                </div>

                <form method="POST" action="{{ route('register.process') }}">
                    @csrf

                    {{-- Name row --}}
                    <div class="auth-form-row">
                        <div class="auth-form-group">
                            <label class="auth-form-label" for="first_name">Nama Depan</label>
                            <div class="auth-input-wrap">
                                <input type="text" id="first_name" name="first_name"
                                    class="auth-input no-right-icon @error('first_name') is-invalid @enderror"
                                    placeholder="cth. Budi" value="{{ old('first_name') }}" data-track autofocus>
                                <i class="fas fa-user auth-input-icon"></i>
                            </div>
                            @error('first_name')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="auth-form-group">
                            <label class="auth-form-label" for="last_name">Nama Belakang</label>
                            <div class="auth-input-wrap">
                                <input type="text" id="last_name" name="last_name"
                                    class="auth-input no-right-icon @error('last_name') is-invalid @enderror"
                                    placeholder="cth. Santoso" value="{{ old('last_name') }}" data-track>
                                <i class="fas fa-user auth-input-icon"></i>
                            </div>
                            @error('last_name')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Username & Email row --}}
                    <div class="auth-form-row">
                        <div class="auth-form-group">
                            <label class="auth-form-label" for="username">Username</label>
                            <div class="auth-input-wrap">
                                <input type="text" id="username" name="username"
                                    class="auth-input no-right-icon @error('username') is-invalid @enderror"
                                    placeholder="username" value="{{ old('username') }}" data-track>
                                <i class="fas fa-at auth-input-icon"></i>
                            </div>
                            @error('username')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="auth-form-group">
                            <label class="auth-form-label" for="email">Email</label>
                            <div class="auth-input-wrap">
                                <input type="email" id="email" name="email"
                                    class="auth-input no-right-icon @error('email') is-invalid @enderror"
                                    placeholder="kamu@email.com" value="{{ old('email') }}" autocomplete="email" data-track>
                                <i class="fas fa-envelope auth-input-icon"></i>
                            </div>
                            @error('email')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password row --}}
                    <div class="auth-form-row">
                        <div class="auth-form-group">
                            <label class="auth-form-label" for="password">Password</label>
                            <div class="auth-input-wrap">
                                <input type="password" id="password" name="password"
                                    class="auth-input @error('password') is-invalid @enderror" placeholder="Min. 8 karakter"
                                    autocomplete="new-password" data-track oninput="checkStrength(this.value)">
                                <i class="fas fa-lock auth-input-icon"></i>
                                <button class="auth-toggle-pw" type="button" onclick="togglePw('password', 'eye1')">
                                    <i class="fas fa-eye-slash" id="eye1"></i>
                                </button>
                            </div>
                            <div class="pw-strength" id="pwStrength">
                                <div class="pw-bar" id="bar1"></div>
                                <div class="pw-bar" id="bar2"></div>
                                <div class="pw-bar" id="bar3"></div>
                                <div class="pw-bar" id="bar4"></div>
                            </div>
                            @error('password')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="auth-form-group">
                            <label class="auth-form-label" for="password_confirmation">Konfirmasi Password</label>
                            <div class="auth-input-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="auth-input" placeholder="Ulangi password" autocomplete="new-password" data-track>
                                <i class="fas fa-lock auth-input-icon"></i>
                                <button class="auth-toggle-pw" type="button"
                                    onclick="togglePw('password_confirmation', 'eye2')">
                                    <i class="fas fa-eye-slash" id="eye2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Bidang Minat --}}
                    <div class="minat-section-label">
                        Bidang Minat <span class="minat-optional">Opsional</span>
                    </div>
                    <div class="minat-grid">
                        <label class="minat-option">
                            <input type="radio" name="minat" value="web" {{ old('minat') === 'web' ? 'checked' : '' }}>
                            <div class="minat-card">
                                <span class="minat-emoji">🌐</span>
                                <span>Web Dev</span>
                            </div>
                        </label>
                        <label class="minat-option">
                            <input type="radio" name="minat" value="mobile" {{ old('minat') === 'mobile' ? 'checked' : '' }}>
                            <div class="minat-card">
                                <span class="minat-emoji">📱</span>
                                <span>Mobile</span>
                            </div>
                        </label>
                        <label class="minat-option">
                            <input type="radio" name="minat" value="ai" {{ old('minat') === 'ai' ? 'checked' : '' }}>
                            <div class="minat-card">
                                <span class="minat-emoji">🤖</span>
                                <span>AI / ML</span>
                            </div>
                        </label>
                        <label class="minat-option">
                            <input type="radio" name="minat" value="iot" {{ old('minat') === 'iot' ? 'checked' : '' }}>
                            <div class="minat-card">
                                <span class="minat-emoji">📡</span>
                                <span>IoT</span>
                            </div>
                        </label>
                    </div>

                    {{-- Terms --}}
                    <div class="auth-terms-row">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            Saya menyetujui
                            <a href="{{ url('/syarat-ketentuan') }}">Syarat &amp; Ketentuan</a>
                            dan
                            <a href="{{ url('/privasi') }}">Kebijakan Privasi</a>
                            Nepertech.
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="auth-btn-submit">
                        Buat Akun <i class="fas fa-arrow-right"></i>
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
                100% { transform: translateY(-105vh) scale(.4); opacity: 0 }
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
                position: absolute; border-radius: 50%;
                background: rgba(44,107,158,.2);
                width: ${size}px; height: ${size}px;
                left: ${x}%; bottom: -${size}px;
                opacity: ${opacity};
                animation: particleRise ${dur}s linear ${delay}s infinite;
            `;
                container.appendChild(p);
            }
        })();

        /* ---- Stagger form groups on load ---- */
        (function () {
            document.querySelectorAll('.auth-form-group').forEach((g, i) => {
                g.style.animation = `fadeUpItem .55s var(--ease) ${.6 + i * .08}s forwards`;
            });
        })();

        /* ---- Live progress tracker ---- */
        function updateProgress() {
            const inputs = document.querySelectorAll('[data-track]');
            let filled = 0;
            inputs.forEach(inp => { if (inp.value.trim()) filled++; });
            const pct = Math.round((filled / inputs.length) * 100);
            document.getElementById('progressFill').style.width = pct + '%';
            document.getElementById('progressPct').textContent = pct + '%';
        }
        document.querySelectorAll('[data-track]').forEach(inp => {
            inp.addEventListener('input', updateProgress);
        });

        /* ---- Password strength indicator ---- */
        function checkStrength(val) {
            const bars = [1, 2, 3, 4].map(n => document.getElementById('bar' + n));
            bars.forEach(b => { b.className = 'pw-bar'; });
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            for (let i = 0; i < score; i++) bars[i].classList.add('filled-' + score);
        }

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
@endpush
