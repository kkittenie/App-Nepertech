@extends('layouts.admin')

@section('title', 'Kategori')

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
        <div class="col-lg-8 col-xl-7">

          
            <div class="page-header d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                        Kategori Produk
                    </h2>
                    <p class="text-muted mb-0 small">
                        Kelola semua kategori produk digitalmu
                    </p>
                </div>
                <a href="{{ route('kategori.create') }}" class="btn-add">
                    <i class="ti ti-plus" style="font-size:15px"></i>
                    Tambah Kategori
                </a>
            </div>

           
            <div class="card main-card">

                @if($kategori->count() > 0)

                    {{-- Stats strip --}}
                    <div class="stats-strip">
                        <i class="ti ti-tag" style="font-size:14px; color:#0a2540"></i>
                        <span>Total <strong>{{ $kategori->count() }}</strong> kategori terdaftar</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table kategori-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:48px">#</th>
                                    <th>Nama Kategori</th>
                                    <th>Dibuat</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="katTableBody">
                                @foreach($kategori as $index => $item)
                                <tr class="kat-row" style="animation-delay: {{ $index * 0.04 }}s">

                                    <td class="text-muted small">{{ $loop->iteration }}</td>

                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="cat-icon">
                                                <i class="{{ $item->icon ?? 'ti ti-tag' }}"></i>
                                            </div>
                                            <span class="fw-semibold" style="color:#0a2540; font-size:14px;">
                                                {{ $item->name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="date-badge">
                                            <i class="ti ti-calendar" style="font-size:13px"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('kategori.edit', $item) }}" class="btn-edit">
                                                <i class="ti ti-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('kategori.destroy', $item) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus kategori \'{{ addslashes($item->name) }}\'?')">
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
                        <div class="empty-icon"><i class="ti ti-tag"></i></div>
                        <h5 class="fw-semibold mb-1" style="color:#0a2540">Belum Ada Kategori</h5>
                        <p class="text-muted small mb-3">Buat kategori pertama untuk mengelompokkan produkmu.</p>
                        <a href="{{ route('kategori.create') }}" class="btn-add">
                            <i class="ti ti-plus"></i>
                            Tambah Kategori
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