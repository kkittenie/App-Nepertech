@extends('layouts.admin')
@section('title', 'Struktur Organisasi')

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
                        Struktur Organisasi
                    </h2>
                    <p class="text-muted mb-0 small">
                        Kelola anggota struktur organisasi yang ditampilkan di halaman profil
                    </p>
                </div>
                <a href="{{ route('structures.create') }}" class="btn-add">
                    <i class="ti ti-plus" style="font-size:15px"></i>
                    Tambah Anggota
                </a>
            </div>

            <div class="card main-card">

                @if($structures->count() > 0)

                    {{-- Stats strip --}}
                    <div class="stats-strip">
                        <i class="ti ti-hierarchy-2" style="font-size:14px; color:#0a2540"></i>
                        <span>Total <strong>{{ $structures->count() }}</strong> anggota struktur organisasi</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table kategori-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:48px">#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Urutan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="structureTableBody">
                                @foreach($structures as $index => $structure)
                                <tr class="kat-row" style="animation-delay: {{ $index * 0.04 }}s">

                                    <td class="text-muted small">{{ $loop->iteration }}</td>

                                    <td>
                                        @if($structure->image)
                                            <img src="{{ asset('storage/' . $structure->image) }}" alt="{{ $structure->name }}" class="product-img" style="object-fit: cover; border-radius:50%; width:40px; height:40px;">
                                        @else
                                            <div class="product-img-placeholder" style="border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                                                <i class="ti ti-user"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="fw-semibold" style="color:#0a2540; font-size:14px;">
                                            {{ $structure->name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-muted small">{{ $structure->position }}</span>
                                    </td>

                                    <td>
                                        <div class="date-badge">
                                            <i class="ti ti-sort-ascending" style="font-size:13px"></i>
                                            {{ $structure->order }}
                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('structures.edit', $structure) }}" class="btn-edit">
                                                <i class="ti ti-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('structures.destroy', $structure) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus anggota \'{{ addslashes($structure->name) }}\'?')">
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
                        <div class="empty-icon"><i class="ti ti-hierarchy-2"></i></div>
                        <h5 class="fw-semibold mb-1" style="color:#0a2540">Belum Ada Anggota</h5>
                        <p class="text-muted small mb-3">Tambahkan anggota struktur organisasi untuk ditampilkan di halaman profil.</p>
                        <a href="{{ route('structures.create') }}" class="btn-add">
                            <i class="ti ti-plus"></i>
                            Tambah Anggota
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
