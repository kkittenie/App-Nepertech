@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

<div class="container-fluid py-4">

    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="edit-badge">
                <i class="ti ti-pencil" style="font-size:13px"></i>
                Mode Edit
            </div>
            <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                {{ $product->name }}
            </h2>
            <p class="text-muted mb-0 small">
                Ubah informasi produk sesuai kebutuhan
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-cancel">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="d-flex align-items-start gap-3 mb-4 p-3"
         style="background:#fef2f2; border:1.5px solid #fecaca; border-radius:14px; animation: fadeUp 0.3s ease">
        <div style="width:34px;height:34px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;color:#dc2626;flex-shrink:0;font-size:16px;">
            <i class="ti ti-alert-circle"></i>
        </div>
        <div>
            <p class="fw-semibold mb-1" style="color:#dc2626;font-size:13px;">Ada kesalahan pada form</p>
            <ul class="mb-0 ps-3" style="font-size:13px;color:#7f1d1d;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="card form-card">

        <form action="{{ route('products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data"
              id="productForm"
              novalidate>

            @csrf
            @method('PUT')

            <div class="form-section">
                <p class="section-label">Identitas Produk</p>
                <div class="row g-3">

                    <div class="col-md-7">
                        <label class="form-label">Nama Produk <span style="color:#ef4444">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               placeholder="Contoh: Jasa Desain Logo Premium"
                               value="{{ old('name', $product->name) }}"
                               maxlength="120"
                               required>
                        @error('name')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">Kategori <span style="color:#ef4444">*</span></label>
                        <select name="category_id"
                                class="form-control form-select {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                                required>
                            <option value="">— Pilih kategori —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                   class="form-control {{ $errors->has('harga_jual') ? 'is-invalid' : '' }}"
                                   placeholder="0"
                                   value="{{ old('harga_jual', $product->harga_jual) }}"
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
                                   class="form-control {{ $errors->has('harga_sewa_bulanan') ? 'is-invalid' : '' }}"
                                   placeholder="0"
                                   value="{{ old('harga_sewa_bulanan', $product->harga_sewa_bulanan) }}"
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
                                   class="form-control {{ $errors->has('harga_sewa_tahunan') ? 'is-invalid' : '' }}"
                                   placeholder="0"
                                   value="{{ old('harga_sewa_tahunan', $product->harga_sewa_tahunan) }}"
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
                               class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"
                               placeholder="https://tokopedia.com/..."
                               value="{{ old('link', $product->link) }}"
                               autocomplete="off">
                        @error('link')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="form-section">
                <p class="section-label">Display Picture (Cover)</p>

                <div class="current-image-card">
                    @if($product->display_image)
                        <img src="{{ asset('storage/' . $product->display_image) }}"
                             alt="{{ $product->name }}"
                             id="currentDisplayImg">
                    @else
                        <div class="img-placeholder">
                            <i class="ti ti-photo-off"></i>
                        </div>
                    @endif
                    <div class="current-image-info">
                        <p>{{ $product->display_image ? basename($product->display_image) : 'Belum ada gambar' }}</p>
                        <span>{{ $product->display_image ? 'Upload gambar baru untuk mengganti' : 'Upload gambar cover di bawah' }}</span>
                    </div>
                </div>

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
                        PNG, JPG, WEBP hingga 2MB — kosongkan jika tidak ingin mengganti
                    </p>
                    <div class="new-preview" id="displayNewPreview">
                        <img id="displayPreviewImg" src="#" alt="Preview baru">
                        <p class="text-muted mt-2 mb-0" style="font-size:12px;" id="displayPreviewName"></p>
                    </div>
                </div>

                @error('display_image')
                    <div class="invalid-feedback d-flex mt-2"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <p class="section-label">Foto Galeri Produk</p>

                @if($product->images->count() > 0)
                <p class="text-muted small mb-3">Gambar galeri saat ini — centang untuk menghapus:</p>
                <div class="existing-gallery-grid">
                    @foreach($product->images as $img)
                    <div class="existing-gallery-item">
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="Gallery {{ $loop->iteration }}">
                        <label class="gallery-delete-check">
                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                            <span><i class="ti ti-trash"></i> Hapus</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted small mb-3">Belum ada foto galeri.</p>
                @endif

                <div class="upload-zone mt-3" id="galleryUploadZone">
                    <input type="file"
                           name="gallery_images[]"
                           id="galleryImageInput"
                           accept="image/*"
                           multiple>
                    <div class="upload-icon">
                        <i class="ti ti-photos"></i>
                    </div>
                    <p class="fw-semibold mb-1" style="color:#0a2540; font-size:14px;">
                        Tambah foto galeri baru
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
                          class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                          placeholder="Jelaskan produk, fitur utama, dan keunggulannya..."
                          maxlength="1000"
                          required>{{ old('description', $product->description) }}</textarea>
                <div class="char-counter" id="charCounter">0 / 1000</div>
                @error('description')
                    <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section" style="background:#fafbfc;">
                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="btn-spinner" id="btnSpinner"></div>
                        <i class="ti ti-device-floppy" id="btnIcon"></i>
                        <span id="btnText">Simpan Perubahan</span>
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
    const displayNewPrev = document.getElementById('displayNewPreview');
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
            displayName.textContent = '✓ ' + file.name;
            displayNewPrev.style.display = 'block';
            const currentImg = document.getElementById('currentDisplayImg');
            if (currentImg) {
                currentImg.style.transition = 'opacity 0.3s ease';
                currentImg.style.opacity = '0.4';
            }
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
    const form       = document.getElementById('productForm');
    const submitBtn  = document.getElementById('submitBtn');
    const btnSpinner = document.getElementById('btnSpinner');
    const btnIcon    = document.getElementById('btnIcon');
    const btnText    = document.getElementById('btnText');

    form.addEventListener('submit', () => {
        if (!form.checkValidity()) return;
        submitBtn.disabled       = true;
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