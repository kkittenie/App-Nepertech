@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')

@if(session('success'))
<div class="toast-alert toast-success" id="toastAlert">
    <div class="toast-icon"><i class="ti ti-check"></i></div>
    <span>{{ session('success') }}</span>
    <button class="toast-close" onclick="dismissToast()"><i class="ti ti-x"></i></button>
</div>
@endif

@if(session('error'))
<div class="toast-alert toast-error" id="toastAlert">
    <div class="toast-icon"><i class="ti ti-alert-circle"></i></div>
    <span>{{ session('error') }}</span>
    <button class="toast-close" onclick="dismissToast()"><i class="ti ti-x"></i></button>
</div>
@endif

<div class="container-fluid py-4">

   
    <div class="page-header d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                Manajemen User
            </h2>
            <p class="text-muted mb-0 small">Kelola semua user yang terdaftar</p>
        </div>
    </div>

    <div class="card main-card">

        @if($users->count() > 0)

           
            <div class="stats-strip">
                <i class="ti ti-users" style="font-size:14px; color:#0a2540"></i>
                <span>Total <strong>{{ $users->count() }}</strong> user terdaftar —
                    <strong>{{ $users->where('role', 'admin')->count() }}</strong> admin,
                    <strong>{{ $users->where('role', '!=', 'admin')->count() }}</strong> user
                </span>
            </div>

            <div class="card-body p-4">

                
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">
                        Semua
                        <span class="tab-count">{{ $users->count() }}</span>
                    </button>
                    <button class="filter-tab" data-filter="admin">
                        Admin
                        <span class="tab-count">{{ $users->where('role', 'admin')->count() }}</span>
                    </button>
                    <button class="filter-tab" data-filter="user">
                        User
                        <span class="tab-count">{{ $users->where('role', '!=', 'admin')->count() }}</span>
                    </button>
                </div>

                
                <div class="table-responsive">
                    <table class="table user-table mb-0">
                        <thead>
                            <tr>
                                <th style="width:48px">#</th>
                                <th>User</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Minat</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            @foreach($users as $index => $user)
                            <tr class="user-row"
                                data-role="{{ $user->role ?? 'user' }}"
                                style="animation-delay: {{ $index * 0.04 }}s">

                                <td class="text-muted small">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="color:#0a2540; font-size:14px;">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </div>
                                            <div class="text-muted" style="font-size:12px;">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-muted small">{{ $user->username ?? '—' }}</td>

                                <td class="small" style="color:#0a2540">{{ $user->email }}</td>

                                <td class="text-muted small">{{ $user->minat ?? '—' }}</td>

                                <td>
                                    <span class="badge-role {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                        {{ ucfirst($user->role ?? 'user') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="date-badge">
                                        <i class="ti ti-calendar" style="font-size:13px"></i>
                                        {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                <td class="text-end">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-hapus">
                                                <i class="ti ti-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="you-chip">
                                            <i class="ti ti-user" style="font-size:13px"></i>
                                            Kamu
                                        </span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        @else

            <div class="empty-state">
                <div class="empty-icon"><i class="ti ti-users"></i></div>
                <h5 class="fw-semibold mb-1" style="color:#0a2540">Belum Ada User</h5>
                <p class="text-muted small mb-0">User yang mendaftar akan muncul di sini.</p>
            </div>

        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── Stagger row animation ──
    document.querySelectorAll('.user-row').forEach((row, i) => {
        setTimeout(() => row.classList.add('fade-in'), i * 45);
    });

    // ── Filter tabs ──
    const tabs = document.querySelectorAll('.filter-tab');
    const rows = document.querySelectorAll('.user-row');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filter = tab.dataset.filter;
            let visibleIndex = 0;

            rows.forEach(row => {
                const role  = row.dataset.role;
                const match = filter === 'all'
                    || (filter === 'admin' && role === 'admin')
                    || (filter === 'user'  && role !== 'admin');

                if (match) {
                    row.classList.remove('hidden', 'fade-in');
                    void row.offsetWidth;
                    setTimeout(() => row.classList.add('fade-in'), visibleIndex * 40);
                    visibleIndex++;
                } else {
                    row.classList.add('hidden');
                    row.classList.remove('fade-in');
                }
            });
        });
    });

    // ── Toast ──
    function dismissToast() {
        const toast = document.getElementById('toastAlert');
        if (!toast) return;
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }

    setTimeout(() => dismissToast(), 4000);
</script>
@endpush