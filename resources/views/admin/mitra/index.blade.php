@extends('layouts.admin')
@section('title', 'Mitra Industri')

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
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">

            <div class="page-header d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                        Mitra Industri
                    </h2>
                    <p class="text-muted mb-0 small">
                        Kelola daftar mitra industri yang bekerja sama dengan Nepertech
                    </p>
                </div>
                <a href="{{ route('mitras.create') }}" class="btn-add">
                    <i class="ti ti-plus" style="font-size:15px"></i>
                    Tambah Mitra
                </a>
            </div>

            <div class="card main-card">

                @if($mitras->count() > 0)

                    {{-- Stats strip --}}
                    <div class="stats-strip">
                        <i class="ti ti-building-community" style="font-size:14px; color:#0a2540"></i>
                        <span>Total <strong>{{ $mitras->count() }}</strong> mitra industri terdaftar</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table kategori-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:48px">#</th>
                                    <th>Logo</th>
                                    <th>Nama Mitra</th>
                                    <th>Dibuat</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="mitraTableBody">
                                @foreach($mitras as $index => $mitra)
                                <tr class="kat-row" style="animation-delay: {{ $index * 0.04 }}s">

                                    <td class="text-muted small">{{ $loop->iteration }}</td>

                                    <td>
                                        @if($mitra->logo)
                                            <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}" class="product-img" style="object-fit: contain; background: #fafbfc;">
                                        @else
                                            <div class="product-img-placeholder">
                                                <i class="ti ti-building"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="fw-semibold" style="color:#0a2540; font-size:14px;">
                                            {{ $mitra->name }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="date-badge">
                                            <i class="ti ti-calendar" style="font-size:13px"></i>
                                            {{ $mitra->created_at->format('d M Y') }}
                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('mitras.edit', $mitra) }}" class="btn-edit">
                                                <i class="ti ti-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('mitras.destroy', $mitra) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus mitra \'{{ addslashes($mitra->name) }}\'?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-hapus">
                                                    <i class="ti ti-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else

                    <div class="empty-state">
                        <div class="empty-icon"><i class="ti ti-building-community"></i></div>
                        <h5 class="fw-semibold mb-1" style="color:#0a2540">Belum Ada Mitra</h5>
                        <p class="text-muted small mb-3">Tambahkan mitra industri pertama untuk ditampilkan di halaman landing.</p>
                        <a href="{{ route('mitras.create') }}" class="btn-add">
                            <i class="ti ti-plus"></i>
                            Tambah Mitra
                        </a>
                    </div>

                @endif

            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── Stagger row animation ──
    document.querySelectorAll('.kat-row').forEach((row, i) => {
        setTimeout(() => row.classList.add('fade-in'), i * 45);
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
