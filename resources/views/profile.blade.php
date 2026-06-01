@extends('layouts.landing')

@section('content')

    @php
        $user = auth()->user();
        $navItems = [
            ['icon' => 'fa-user',        'label' => 'Profil Saya',    'key' => 'profil'],
            ['icon' => 'fa-code',        'label' => 'Proyek Saya',    'key' => 'proyek'],
            ['icon' => 'fa-bell',        'label' => 'Notifikasi',     'key' => 'notifikasi'],
            ['icon' => 'fa-cog',         'label' => 'Pengaturan',     'key' => 'pengaturan'],
        ];
    @endphp

    <div class="pd-shell">

        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="pd-sidebar">
            <div class="animate-fade-up" style="animation-delay:.1s; display:flex; flex-direction:column; gap:16px; width:100%;">

                {{-- Profile Card --}}
                <div class="pd-profile-card">
                    <div class="pd-avatar-wrap">
                        <div class="pd-avatar">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            @else
                                <span class="pd-avatar-initials">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div class="pd-avatar-ring"></div>
                        <div class="pd-avatar-ring pd-avatar-ring-2"></div>
                        <span class="pd-avatar-status"></span>
                    </div>

                    <h2 class="pd-profile-name">{{ $user->name }}</h2>
                    <p class="pd-profile-handle">{{ '@' . $user->username }}</p>

                    <div class="pd-stat-row">
                        <div class="pd-stat">
                            <span class="pd-stat-num">{{ $user->created_at->format('Y') }}</span>
                            <span class="pd-stat-lbl">Sejak</span>
                        </div>
                        <div class="pd-stat-sep"></div>
                        <div class="pd-stat">
                            <span class="pd-stat-num">TEFA</span>
                            <span class="pd-stat-lbl">Program</span>
                        </div>
                        <div class="pd-stat-sep"></div>
                        <div class="pd-stat">
                            <span class="pd-stat-num pd-stat-green">Aktif</span>
                            <span class="pd-stat-lbl">Status</span>
                        </div>
                    </div>
                </div>

                {{-- Nav Menu --}}
                <nav class="pd-nav">
                    @foreach($navItems as $item)
                        <a href="#{{ $item['key'] }}"
                           class="pd-nav-item {{ $loop->first ? 'pd-nav-active' : '' }}"
                           data-section="{{ $item['key'] }}">
                            <span class="pd-nav-icon"><i class="fas {{ $item['icon'] }}"></i></span>
                            <span class="pd-nav-label">{{ $item['label'] }}</span>
                            <i class="fas fa-chevron-right pd-nav-chevron"></i>
                        </a>
                    @endforeach

                    <div class="pd-nav-divider"></div>

                    <form method="POST" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button type="submit" class="pd-nav-item pd-nav-danger">
                            <span class="pd-nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span class="pd-nav-label">Keluar</span>
                            <i class="fas fa-chevron-right pd-nav-chevron"></i>
                        </button>
                    </form>
                </nav>

            </div>
        </aside>

        {{-- ===================== MAIN CONTENT ===================== --}}
        <main class="pd-main">

            {{-- =========== PROFIL SAYA =========== --}}
            <section class="pd-section" id="profil" data-section="profil">

                <div class="pd-section-header animate-fade-up" style="animation-delay:.2s">
                    <div>
                        <span class="section-tag" style="margin-bottom:8px">Akun</span>
                        <h2 class="pd-section-title">Profil <span class="gradient-text">Saya</span></h2>
                    </div>
                    <a href="#pengaturan" class="btn btn-primary btn-arrow btn-edit-profile-trigger">
                        Edit Profil <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Identity Banner --}}
                <div class="pd-identity-banner animate-fade-up" style="animation-delay:.3s">
                    <div class="pd-id-orb"></div>
                    <div class="pd-id-orb pd-id-orb-2"></div>
                    <div class="pd-id-inner">
                        <div class="pd-id-avatar">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            @else
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="hero-badge" style="margin-bottom:12px;width:fit-content;border-color:rgba(255,255,255,.2);background:rgba(255,255,255,.12)">
                                <span class="hero-badge-dot"></span>
                                Anggota Nepertech
                            </div>
                            <h3 style="color:white;font-size:clamp(22px,3vw,32px);margin-bottom:6px;letter-spacing:-0.03em">
                                {{ $user->name }}
                            </h3>
                            <p style="color:rgba(255,255,255,.6);margin:0;font-size:14px">
                                {{ '@' . $user->username }} &nbsp;·&nbsp; Bergabung {{ $user->created_at->translatedFormat('F Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Badges row --}}
                    <div class="pd-id-badges">
                        <span class="pd-id-badge"><i class="fas fa-school"></i> SMKN 1 Cirebon</span>
                        <span class="pd-id-badge"><i class="fas fa-blud"></i> BLUD</span>
                        <span class="pd-id-badge pd-id-badge-green"><i class="fas fa-circle"></i> Akun Aktif</span>
                    </div>
                </div>

                {{-- Info Grid --}}
                <div class="pd-content-card animate-fade-up" style="animation-delay:.4s">
                    <div class="pd-card-label">
                        <i class="fas fa-id-card"></i> Informasi Akun
                    </div>
                    <div class="pd-info-grid">
                        <div class="pd-info-item">
                            <div class="pd-info-icon-wrap"><i class="fas fa-user"></i></div>
                            <div>
                                <span class="pd-info-lbl">Nama Depan</span>
                                <span class="pd-info-val">{{ $user->first_name }}</span>
                            </div>
                        </div>
                        <div class="pd-info-item">
                            <div class="pd-info-icon-wrap"><i class="fas fa-user"></i></div>
                            <div>
                                <span class="pd-info-lbl">Nama Belakang</span>
                                <span class="pd-info-val">{{ $user->last_name ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="pd-info-item">
                            <div class="pd-info-icon-wrap"><i class="fas fa-at"></i></div>
                            <div>
                                <span class="pd-info-lbl">Username</span>
                                <span class="pd-info-val">{{ $user->username }}</span>
                            </div>
                        </div>
                        <div class="pd-info-item">
                            <div class="pd-info-icon-wrap"><i class="fas fa-envelope"></i></div>
                            <div>
                                <span class="pd-info-lbl">Email</span>
                                <span class="pd-info-val">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="pd-info-item">
                            <div class="pd-info-icon-wrap"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <span class="pd-info-lbl">Bergabung Sejak</span>
                                <span class="pd-info-val">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CTA Banner --}}
                <div class="pd-cta-banner animate-fade-up" style="animation-delay:.6s">
                    <div class="pd-cta-content">
                        <div>
                            <h3 style="color:white;margin-bottom:6px">Ada proyek yang ingin dikerjakan?</h3>
                            <p style="color:rgba(255,255,255,.7);margin:0;font-size:14px">
                                Konsultasikan kebutuhanmu bersama tim Nepertech — gratis.
                            </p>
                        </div>
                        <a href="{{ url('/kontak') }}" class="btn btn-cta btn-arrow" style="flex-shrink:0;white-space:nowrap">
                            Konsultasi Gratis <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="cta-orb cta-orb-1"></div>
                    <div class="cta-orb cta-orb-2"></div>
                </div>

            </section>

            {{-- =========== KEAMANAN =========== --}}
            <section class="pd-section pd-section-hidden" id="keamanan" data-section="keamanan">
                <div class="pd-section-header">
                    <div>
                        <span class="section-tag" style="margin-bottom:8px">Akun</span>
                        <h2 class="pd-section-title">Keamanan <span class="gradient-text">Akun</span></h2>
                    </div>
                </div>
                <div class="pd-content-card">
                    <div class="pd-card-label"><i class="fas fa-lock"></i> Password & Akses</div>
                    <div class="pd-security-row">
                        <div class="pd-security-left">
                            <div class="pd-info-icon-wrap"><i class="fas fa-key"></i></div>
                            <div>
                                <span class="pd-info-lbl">Password</span>
                                <span class="pd-info-val">••••••••••••</span>
                            </div>
                        </div>
                        <a href="{{ route('profile') }}" class="btn btn-outline btn-arrow" style="font-size:13px;padding:9px 20px">
                            Ubah <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="pd-security-row pd-security-row-border">
                        <div class="pd-security-left">
                            <div class="pd-info-icon-wrap"><i class="fas fa-envelope"></i></div>
                            <div>
                                <span class="pd-info-lbl">Email Terdaftar</span>
                                <span class="pd-info-val">{{ $user->email }}</span>
                            </div>
                        </div>
                        <span class="cert-badge"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                    </div>
                </div>
            </section>

            {{-- =========== PENGATURAN =========== --}}
            <section class="pd-section pd-section-hidden" id="pengaturan" data-section="pengaturan">
                <div class="pd-section-header">
                    <div>
                        <span class="section-tag" style="margin-bottom:8px">Sistem</span>
                        <h2 class="pd-section-title">Pengaturan <span class="gradient-text">Akun</span></h2>
                    </div>
                </div>

                {{-- Photo Form --}}
                <div class="pd-content-card" style="margin-bottom:24px">
                    <div class="pd-card-label"><i class="fas fa-camera"></i> Foto Profil</div>
                    <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                        @csrf
                        <div style="display:flex; gap:20px; align-items:center; margin-bottom:20px;">
                            <div style="width:80px; height:80px; border-radius:50%; overflow:hidden; background:var(--gray-border); flex-shrink:0;">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:24px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <input type="file" name="photo" id="photo" class="form-control" accept="image/jpeg,image/png,image/webp" required style="max-width:300px; margin-bottom:10px;">
                                <p style="font-size:13px; color:var(--text-muted); margin:0;">Maksimal ukuran 2MB (JPG, PNG, WEBP)</p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Foto</button>
                    </form>
                </div>

                {{-- Profile Info Form --}}
                <div class="pd-content-card">
                    <div class="pd-card-label"><i class="fas fa-user-edit"></i> Edit Informasi Akun</div>
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-group" style="margin-bottom:16px;">
                            <label for="name" style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">Nama Tampilan</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" required style="width:100%; padding:10px 14px; border:1px solid var(--gray-border); border-radius:8px;">
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                            <div>
                                <label for="first_name" style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">Nama Depan</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control" required style="width:100%; padding:10px 14px; border:1px solid var(--gray-border); border-radius:8px;">
                            </div>
                            <div>
                                <label for="last_name" style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">Nama Belakang</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control" style="width:100%; padding:10px 14px; border:1px solid var(--gray-border); border-radius:8px;">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                            <div>
                                <label for="username" style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="form-control" required style="width:100%; padding:10px 14px; border:1px solid var(--gray-border); border-radius:8px;">
                            </div>
                            <div>
                                <label for="email" style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required style="width:100%; padding:10px 14px; border:1px solid var(--gray-border); border-radius:8px;">
                            </div>
                        </div>

                        <div style="display:flex;gap:14px;flex-wrap:wrap;align-items:center;justify-content:space-between">
                            <button type="submit" class="btn btn-primary btn-arrow">
                                Simpan Perubahan <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            {{-- =========== DYNAMIC PROJECTS & NOTIFICATIONS SECTIONS =========== --}}
            <section class="pd-section pd-section-hidden" id="proyek" data-section="proyek">
                <div class="pd-section-header">
                    <div>
                        <span class="section-tag" style="margin-bottom:8px">Nepertech</span>
                        <h2 class="pd-section-title">Proyek <span class="gradient-text">Saya</span></h2>
                    </div>
                </div>

                @if($rentals->isEmpty() && $sales->isEmpty())
                    <div class="pd-content-card pd-empty-state animate-fade-up">
                        <div class="pd-empty-icon"><i class="fas fa-code"></i></div>
                        <h3 style="margin-bottom:8px">Belum ada proyek</h3>
                        <p style="color:var(--text-muted);margin:0">Proyek yang sedang atau telah dikerjakan akan tampil di sini.</p>
                        <a href="{{ url('/kontak') }}" class="btn btn-primary btn-arrow" style="margin-top:24px">
                            Mulai Proyek <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @else
                    <div class="pd-projects-grid">
                        @foreach($rentals as $rental)
                            <div class="pd-project-card animate-fade-up">
                                <div class="pd-project-image">
                                    @if($rental->product && $rental->product->display_image)
                                        <img src="{{ asset('storage/' . $rental->product->display_image) }}" alt="{{ $rental->product->name }}">
                                    @else
                                        <div class="pd-project-image-placeholder"><i class="fas fa-laptop-code"></i></div>
                                    @endif
                                    <span class="pd-project-type badge-sewa">Sewa</span>
                                </div>
                                <div class="pd-project-body">
                                    <h3 class="pd-project-name">{{ $rental->product->name ?? 'Produk Sewa' }}</h3>
                                    <div class="pd-project-meta">
                                        <div class="pd-project-meta-item">
                                            <span class="lbl">Durasi:</span>
                                            <span class="val fw-semibold">{{ $rental->duration_label }}</span>
                                        </div>
                                        <div class="pd-project-meta-item">
                                            <span class="lbl">Mulai Sewa:</span>
                                            <span class="val">{{ $rental->start_date->translatedFormat('d M Y') }}</span>
                                        </div>
                                        <div class="pd-project-meta-item">
                                            <span class="lbl">Total Biaya:</span>
                                            <span class="val fw-bold text-primary">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="pd-project-status-row">
                                        <span class="pd-project-status badge-{{ $rental->status }}">
                                            @if($rental->status === 'pending')
                                                <i class="fas fa-hourglass-half me-1"></i> Ditinjau
                                            @elseif($rental->status === 'approved')
                                                <i class="fas fa-check-circle me-1"></i> Aktif
                                            @elseif($rental->status === 'rejected')
                                                <i class="fas fa-times-circle me-1"></i> Ditolak
                                            @else
                                                {{ ucfirst($rental->status) }}
                                            @endif
                                        </span>
                                    </div>
                                    @if($rental->admin_notes)
                                        <div class="pd-project-notes mt-3">
                                            <strong>Catatan Admin:</strong>
                                            <p class="mb-0 text-muted italic">"{{ $rental->admin_notes }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @foreach($sales as $sale)
                            <div class="pd-project-card animate-fade-up">
                                <div class="pd-project-image">
                                    @if($sale->product && $sale->product->display_image)
                                        <img src="{{ asset('storage/' . $sale->product->display_image) }}" alt="{{ $sale->product->name }}">
                                    @else
                                        <div class="pd-project-image-placeholder"><i class="fas fa-laptop-code"></i></div>
                                    @endif
                                    <span class="pd-project-type badge-beli">Beli</span>
                                </div>
                                <div class="pd-project-body">
                                    <h3 class="pd-project-name">{{ $sale->product->name ?? 'Produk Jual Lepas' }}</h3>
                                    <div class="pd-project-meta">
                                        <div class="pd-project-meta-item">
                                            <span class="lbl">Tipe Lisensi:</span>
                                            <span class="val fw-semibold">Beli Penuh</span>
                                        </div>
                                        <div class="pd-project-meta-item">
                                            <span class="lbl">Total Harga:</span>
                                            <span class="val fw-bold text-primary">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="pd-project-status-row">
                                        <span class="pd-project-status badge-{{ $sale->status }}">
                                            @if($sale->status === 'pending')
                                                <i class="fas fa-hourglass-half me-1"></i> Ditinjau
                                            @elseif($sale->status === 'awaiting_payment')
                                                <i class="fas fa-wallet me-1"></i> Menunggu Pembayaran
                                            @elseif($sale->status === 'payment_submitted')
                                                <i class="fas fa-clock me-1"></i> Verifikasi Pembayaran
                                            @elseif($sale->status === 'completed')
                                                <i class="fas fa-check-double me-1"></i> Selesai
                                            @elseif($sale->status === 'rejected')
                                                <i class="fas fa-times-circle me-1"></i> Ditolak
                                            @else
                                                {{ ucfirst($sale->status) }}
                                            @endif
                                        </span>
                                    </div>
                                    @if($sale->status === 'awaiting_payment')
                                        <a href="{{ route('sale.payment', $sale->payment_token) }}" class="btn btn-primary btn-arrow w-100 mt-3" style="padding: 10px; font-size: 13px; justify-content: center;">
                                            Bayar / Unggah Bukti <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    @endif
                                    @if($sale->admin_notes)
                                        <div class="pd-project-notes mt-3">
                                            <strong>Catatan Admin:</strong>
                                            <p class="mb-0 text-muted italic">"{{ $sale->admin_notes }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="pd-section pd-section-hidden" id="notifikasi" data-section="notifikasi">
                <div class="pd-section-header">
                    <div>
                        <span class="section-tag" style="margin-bottom:8px">Nepertech</span>
                        <h2 class="pd-section-title">Notifikasi</h2>
                    </div>
                </div>

                @php
                    $notifications = collect();

                    foreach($rentals as $rental) {
                        if ($rental->status === 'pending') {
                            $notifications->push([
                                'type' => 'info',
                                'title' => 'Pengajuan Sewa Terkirim',
                                'message' => 'Pengajuan sewa Anda untuk produk "' . ($rental->product->name ?? 'Produk') . '" telah diterima dan sedang ditinjau oleh admin.',
                                'time' => $rental->created_at,
                                'icon' => 'fa-paper-plane',
                            ]);
                        } elseif ($rental->status === 'approved') {
                            $notifications->push([
                                'type' => 'success',
                                'title' => 'Pengajuan Sewa Disetujui',
                                'message' => 'Kabar baik! Pengajuan sewa produk "' . ($rental->product->name ?? 'Produk') . '" telah disetujui. Layanan Anda kini aktif.',
                                'time' => $rental->updated_at,
                                'icon' => 'fa-check-circle',
                            ]);
                        } elseif ($rental->status === 'rejected') {
                            $notifications->push([
                                'type' => 'danger',
                                'title' => 'Pengajuan Sewa Ditolak',
                                'message' => 'Mohon maaf, pengajuan sewa produk "' . ($rental->product->name ?? 'Produk') . '" ditolak. ' . ($rental->admin_notes ? 'Alasan: ' . $rental->admin_notes : ''),
                                'time' => $rental->updated_at,
                                'icon' => 'fa-times-circle',
                            ]);
                        }
                    }

                    foreach($sales as $sale) {
                        if ($sale->status === 'pending') {
                            $notifications->push([
                                'type' => 'info',
                                'title' => 'Pengajuan Pembelian Terkirim',
                                'message' => 'Pengajuan pembelian produk "' . ($sale->product->name ?? 'Produk') . '" telah terkirim dan sedang ditinjau oleh admin.',
                                'time' => $sale->created_at,
                                'icon' => 'fa-shopping-cart',
                            ]);
                        } elseif ($sale->status === 'awaiting_payment') {
                            $notifications->push([
                                'type' => 'warning',
                                'title' => 'Menunggu Pembayaran',
                                'message' => 'Pengajuan pembelian "' . ($sale->product->name ?? 'Produk') . '" disetujui! Silakan lakukan pembayaran dan unggah bukti transfer Anda.',
                                'time' => $sale->updated_at,
                                'icon' => 'fa-wallet',
                                'action_url' => route('sale.payment', $sale->payment_token),
                                'action_label' => 'Bayar Sekarang',
                            ]);
                        } elseif ($sale->status === 'payment_submitted') {
                            $notifications->push([
                                'type' => 'info',
                                'title' => 'Bukti Pembayaran Dikirim',
                                'message' => 'Bukti pembayaran untuk "' . ($sale->product->name ?? 'Produk') . '" telah diunggah dan sedang divalidasi oleh tim admin kami.',
                                'time' => $sale->updated_at,
                                'icon' => 'fa-hourglass-half',
                            ]);
                        } elseif ($sale->status === 'completed') {
                            $notifications->push([
                                'type' => 'success',
                                'title' => 'Pembelian Selesai',
                                'message' => 'Pembayaran untuk "' . ($sale->product->name ?? 'Produk') . '" telah berhasil divalidasi! Tim kami akan segera menghubungi Anda.',
                                'time' => $sale->updated_at,
                                'icon' => 'fa-check-double',
                            ]);
                        } elseif ($sale->status === 'rejected') {
                            $notifications->push([
                                'type' => 'danger',
                                'title' => 'Pembelian Ditolak',
                                'message' => 'Mohon maaf, pengajuan pembelian produk "' . ($sale->product->name ?? 'Produk') . '" ditolak. ' . ($sale->admin_notes ? 'Alasan: ' . $sale->admin_notes : ''),
                                'time' => $sale->updated_at,
                                'icon' => 'fa-times-circle',
                            ]);
                        }
                    }

                    $notifications = $notifications->sortByDesc('time');
                @endphp

                @if($notifications->isEmpty())
                    <div class="pd-content-card pd-empty-state animate-fade-up">
                        <div class="pd-empty-icon"><i class="fas fa-bell"></i></div>
                        <h3 style="margin-bottom:8px">Semua sudah terbaca</h3>
                        <p style="color:var(--text-muted);margin:0">Belum ada notifikasi baru untuk saat ini.</p>
                    </div>
                @else
                    <div class="pd-notifications-list">
                        @foreach($notifications as $notif)
                            <div class="pd-notification-item animate-fade-up pd-notif-{{ $notif['type'] }}">
                                <div class="pd-notif-icon-wrap">
                                    <i class="fas {{ $notif['icon'] }}"></i>
                                </div>
                                <div class="pd-notif-body">
                                    <div class="pd-notif-header">
                                        <h4 class="pd-notif-title">{{ $notif['title'] }}</h4>
                                        <span class="pd-notif-time">{{ $notif['time']->diffForHumans() }}</span>
                                    </div>
                                    <p class="pd-notif-message">{{ $notif['message'] }}</p>
                                    @if(isset($notif['action_url']))
                                        <a href="{{ $notif['action_url'] }}" class="btn btn-primary btn-arrow btn-sm mt-2" style="font-size: 12px; padding: 6px 12px;">
                                            {{ $notif['action_label'] }} <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const navItems = document.querySelectorAll('.pd-nav-item[data-section]');
        const sections = document.querySelectorAll('.pd-section');

        function activate(key) {
            navItems.forEach(n => n.classList.toggle('pd-nav-active', n.dataset.section === key));
            sections.forEach(s => {
                const show = s.dataset.section === key;
                s.classList.toggle('pd-section-hidden', !show);
                if (show) {
                    s.querySelectorAll('.reveal').forEach(el => {
                        el.classList.remove('visible');
                        requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('visible')));
                    });
                }
            });
        }

        navItems.forEach(n => {
            n.addEventListener('click', e => {
                e.preventDefault();
                activate(n.dataset.section);
                history.pushState(null, '', '#' + n.dataset.section);
            });
        });

        // Trigger for Edit Profile button to redirect to Pengaturan tab smoothly
        const editProfileBtn = document.querySelector('.btn-edit-profile-trigger');
        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', e => {
                e.preventDefault();
                activate('pengaturan');
                history.pushState(null, '', '#pengaturan');
                // Scroll to top of settings for better UX
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        const hash = location.hash.replace('#', '');
        if (hash) activate(hash);
    });
    </script>

@endsection