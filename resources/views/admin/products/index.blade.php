@extends('layouts.admin')

@section('title', 'Manajemen Produk')



@section('content')


@if(session('success'))
<div class="toast-alert toast-success" id="toastAlert">
    <div class="toast-icon"><i class="ti ti-check"></i></div>
    <span>{{ session('success') }}</span>
    <button class="toast-close" onclick="dismissToast()">
        <i class="ti ti-x"></i>
    </button>
</div>
@endif

@if(session('error'))
<div class="toast-alert toast-error" id="toastAlert">
    <div class="toast-icon"><i class="ti ti-alert-circle"></i></div>
    <span>{{ session('error') }}</span>
    <button class="toast-close" onclick="dismissToast()">
        <i class="ti ti-x"></i>
    </button>
</div>
@endif

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

          
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="color:#0a2540">Inventaris Produk</h3>
                    <p class="text-muted mb-0 small">Kelola semua data produk dengan mudah.</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn-add">
                    + Tambah Produk
                </a>
            </div>

         
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">
                    Semua
                    <span class="tab-count">{{ $products->count() }}</span>
                </button>
                @foreach($categories as $cat)
                <button class="filter-tab" data-filter="{{ $cat->id }}">
                    {{ $cat->name }}
                    <span class="tab-count">{{ $products->where('category_id', $cat->id)->count() }}</span>
                </button>
                @endforeach
            </div>

          
            @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table product-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Link</th>
                            <th>Deskripsi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @foreach($products as $index => $product)
                        <tr class="product-row"
                            data-category="{{ $product->category_id }}"
                            style="animation-delay: {{ $index * 0.04 }}s">

                            <td class="text-muted small">{{ $loop->iteration }}</td>

                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="product-img" alt="{{ $product->name }}">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="ti ti-package"></i>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <span class="fw-semibold" style="color:#0a2540">
                                    {{ $product->name }}
                                </span>
                            </td>

                            <td>
                                <span class="badge-category">
                                    {{ $product->category->name ?? '-' }}
                                </span>
                            </td>

                            <td class="fw-semibold small">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td class="link-cell">
                                @if($product->link)
                                    <a href="{{ $product->link }}" target="_blank" title="{{ $product->link }}">
                                        <i class="ti ti-external-link" style="font-size:13px"></i>
                                        {{ Str::limit($product->link, 22) }}
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            <td class="text-muted small">
                                {{ Str::limit($product->description, 38) }}
                            </td>

                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="btn btn-sm"
                                       style="background:rgba(10,37,64,0.06);color:#0a2540;border-radius:8px;font-size:0.8rem;font-weight:500">
                                        <i class="ti ti-pencil me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm"
                                                style="background:#fef2f2;color:#dc2626;border-radius:8px;font-size:0.8rem;font-weight:500">
                                            <i class="ti ti-trash me-1"></i>Hapus
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
                <div class="empty-icon"><i class="ti ti-package"></i></div>
                <h5 class="fw-semibold mb-1" style="color:#0a2540">Belum Ada Produk</h5>
                <p class="text-muted small mb-3">Mulai dengan menambahkan produk pertama.</p>
                <a href="{{ route('products.create') }}" class="btn-add">
                    + Tambah Produk
                </a>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── Animasi row on load dengan stagger ──
    document.querySelectorAll('.product-row').forEach((row, i) => {
        setTimeout(() => {
            row.classList.add('fade-in');
        }, i * 40);
    });

    // ── Filter tabs ──
    const tabs = document.querySelectorAll('.filter-tab');
    const rows = document.querySelectorAll('.product-row');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filter = tab.dataset.filter;
            let visibleIndex = 0;

            rows.forEach(row => {
                const match = filter === 'all' || row.dataset.category === filter;

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

    // ── Toast auto dismiss ──
    function dismissToast() {
        const toast = document.getElementById('toastAlert');
        if (!toast) return;
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }

    // Auto dismiss setelah 4 detik
    setTimeout(() => dismissToast(), 4000);
</script>
@endpush