@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

<div class="container-fluid py-4">

   
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                Tambah Produk
            </h2>
            <p class="text-muted mb-0 small">
                Isi detail produk atau layanan digital kamu
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-cancel">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>

   
    <div class="card form-card">

        <form action="{{ route('products.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="productForm"
              novalidate>
            @csrf

         
            <div class="form-section">
                <p class="section-label">Identitas Produk</p>
                <div class="row g-3">

                    <div class="col-md-7">
                        <label class="form-label">Nama Produk <span style="color:#ef4444">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Masukkan Nama Produk.."
                               value="{{ old('name') }}"
                               maxlength="120"
                               required>
                        @error('name')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">Kategori <span style="color:#ef4444">*</span></label>
                        <select name="category_id" class="form-control form-select" required>
                            <option value="">— Pilih kategori —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

          
            <div class="form-section">
                <p class="section-label">Harga &amp; Tautan</p>
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Harga Jual (Lepas) <span style="color:#ef4444">*</span></label>
                        <div class="price-input-wrapper">
                            <span class="price-prefix">Rp</span>
                            <input type="number"
                                   name="harga_jual"
                                   class="form-control"
                                   placeholder="0"
                                   value="{{ old('harga_jual') }}"
                                   min="0"
                                   required>
                        </div>
                        @error('harga_jual')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Harga Sewa / Bulan</label>
                        <div class="price-input-wrapper">
                            <span class="price-prefix">Rp</span>
                            <input type="number"
                                   name="harga_sewa_bulanan"
                                   class="form-control"
                                   placeholder="0"
                                   value="{{ old('harga_sewa_bulanan') }}"
                                   min="0">
                        </div>
                        @error('harga_sewa_bulanan')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Harga Sewa / Tahun</label>
                        <div class="price-input-wrapper">
                            <span class="price-prefix">Rp</span>
                            <input type="number"
                                   name="harga_sewa_tahunan"
                                   class="form-control"
                                   placeholder="0"
                                   value="{{ old('harga_sewa_tahunan') }}"
                                   min="0">
                        </div>
                        @error('harga_sewa_tahunan')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Link Produk</label>
                        <input type="url"
                               name="link"
                               class="form-control"
                               placeholder="https://tokopedia.com/..."
                               value="{{ old('link') }}"
                               autocomplete="off">
                        @error('link')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

          
            <div class="form-section">
                <p class="section-label">Display Picture (Cover)</p>
                <p class="text-muted small mb-3">Gambar utama yang akan ditampilkan di halaman project.</p>

                <div class="upload-zone" id="displayUploadZone">
                    <input type="file"
                           name="display_image"
                           id="displayImageInput"
                           accept="image/*">
                    <div class="upload-icon">
                        <i class="ti ti-photo-up"></i>
                    </div>
                    <p class="fw-semibold mb-1" style="color:#0a2540; font-size:14px;">
                        Klik atau seret gambar ke sini
                    </p>
                    <p class="text-muted mb-0" style="font-size:12px;">
                        PNG, JPG, WEBP hingga 2MB — <strong>Wajib</strong>
                    </p>
                    <div class="upload-preview" id="displayPreview">
                        <img id="displayPreviewImg" src="#" alt="Preview">
                        <p class="text-muted mt-2 mb-0" style="font-size:12px;" id="displayPreviewName"></p>
                    </div>
                </div>

                @error('display_image')
                    <div class="invalid-feedback d-flex"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

           
            <div class="form-section">
                <p class="section-label">Foto Galeri Produk</p>
                <p class="text-muted small mb-3">Upload foto tambahan untuk galeri (opsional, bisa lebih dari 1).</p>

                <div class="upload-zone" id="galleryUploadZone">
                    <input type="file"
                           name="gallery_images[]"
                           id="galleryImageInput"
                           accept="image/*"
                           multiple>
                    <div class="upload-icon">
                        <i class="ti ti-photos"></i>
                    </div>
                    <p class="fw-semibold mb-1" style="color:#0a2540; font-size:14px;">
                        Klik atau seret beberapa gambar ke sini
                    </p>
                    <p class="text-muted mb-0" style="font-size:12px;">
                        PNG, JPG, WEBP hingga 2MB per file — Pilih beberapa sekaligus
                    </p>
                </div>

                <div class="gallery-preview-grid" id="galleryPreviewGrid"></div>

                @error('gallery_images')
                    <div class="invalid-feedback d-flex"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
                @error('gallery_images.*')
                    <div class="invalid-feedback d-flex"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

         
            <div class="form-section">
                <p class="section-label">Deskripsi</p>
                <label class="form-label">Detail Produk <span style="color:#ef4444">*</span></label>
                <textarea name="description"
                          id="descTextarea"
                          class="form-control"
                          placeholder="Jelaskan produk, fitur utama, dan keunggulannya..."
                          maxlength="1000"
                          required>{{ old('description') }}</textarea>
                <div class="char-counter" id="charCounter">0 / 1000</div>
                @error('description')
                    <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

           
            <div class="form-section" style="background:#fafbfc;">
                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="btn-spinner" id="btnSpinner"></div>
                        <i class="ti ti-plus" id="btnIcon"></i>
                        <span id="btnText">Simpan Produk</span>
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-cancel">
                        Batal
                    </a>
                </div>
            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
    // ── Display Image Preview ──
    const displayInput = document.getElementById('displayImageInput');
    const displayZone  = document.getElementById('displayUploadZone');
    const displayPrev  = document.getElementById('displayPreview');
    const displayImg   = document.getElementById('displayPreviewImg');
    const displayName  = document.getElementById('displayPreviewName');

    displayInput.addEventListener('change', handleDisplayFile);

    displayZone.addEventListener('dragover', e => {
        e.preventDefault();
        displayZone.classList.add('drag-over');
    });
    displayZone.addEventListener('dragleave', () => displayZone.classList.remove('drag-over'));
    displayZone.addEventListener('drop', e => {
        e.preventDefault();
        displayZone.classList.remove('drag-over');
        if (e.dataTransfer.files[0]) {
            displayInput.files = e.dataTransfer.files;
            handleDisplayFile();
        }
    });

    function handleDisplayFile() {
        const file = displayInput.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            displayImg.src = e.target.result;
            displayName.textContent = file.name;
            displayPrev.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // ── Gallery Images Preview ──
    const galleryInput = document.getElementById('galleryImageInput');
    const galleryZone  = document.getElementById('galleryUploadZone');
    const galleryGrid  = document.getElementById('galleryPreviewGrid');

    galleryInput.addEventListener('change', handleGalleryFiles);

    galleryZone.addEventListener('dragover', e => {
        e.preventDefault();
        galleryZone.classList.add('drag-over');
    });
    galleryZone.addEventListener('dragleave', () => galleryZone.classList.remove('drag-over'));
    galleryZone.addEventListener('drop', e => {
        e.preventDefault();
        galleryZone.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            galleryInput.files = e.dataTransfer.files;
            handleGalleryFiles();
        }
    });

    function handleGalleryFiles() {
        galleryGrid.innerHTML = '';
        const files = galleryInput.files;
        if (!files.length) return;

        Array.from(files).forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const thumb = document.createElement('div');
                thumb.className = 'gallery-thumb';
                thumb.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${i+1}">
                    <span class="gallery-thumb-name">${file.name}</span>
                `;
                galleryGrid.appendChild(thumb);
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Char Counter ──
    const descTextarea = document.getElementById('descTextarea');
    const charCounter  = document.getElementById('charCounter');
    const maxLen = 1000;

    function updateCounter() {
        const len = descTextarea.value.length;
        charCounter.textContent = `${len} / ${maxLen}`;
        charCounter.classList.remove('warn', 'limit');
        if (len > maxLen * 0.9) charCounter.classList.add('warn');
        if (len >= maxLen)      charCounter.classList.add('limit');
    }

    descTextarea.addEventListener('input', updateCounter);
    updateCounter();

    // ── Submit Loading State ──
    const form      = document.getElementById('productForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnSpinner = document.getElementById('btnSpinner');
    const btnIcon   = document.getElementById('btnIcon');
    const btnText   = document.getElementById('btnText');

    form.addEventListener('submit', () => {
        if (!form.checkValidity()) return;
        submitBtn.disabled = true;
        btnSpinner.style.display = 'block';
        btnIcon.style.display    = 'none';
        btnText.textContent      = 'Menyimpan...';
    });

    // ── Live Validation ──
    document.querySelectorAll('.form-control, .form-select').forEach(el => {
        el.addEventListener('blur', () => {
            if (el.required && !el.value.trim()) {
                el.classList.add('is-invalid');
            } else {
                el.classList.remove('is-invalid');
            }
        });
        el.addEventListener('input', () => {
            if (el.value.trim()) el.classList.remove('is-invalid');
        });
    });
</script>
@endpush