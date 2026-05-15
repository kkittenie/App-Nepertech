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

                    <div class="col-md-5">
                        <label class="form-label">Harga <span style="color:#ef4444">*</span></label>
                        <div class="price-input-wrapper">
                            <span class="price-prefix">Rp</span>
                            <input type="number"
                                   name="price"
                                   class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                   placeholder="0"
                                   value="{{ old('price', $product->price) }}"
                                   min="0"
                                   required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-7">
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
                <p class="section-label">Gambar Produk</p>

            
                <div class="current-image-card">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             id="currentImg">
                    @else
                        <div class="img-placeholder">
                            <i class="ti ti-photo-off"></i>
                        </div>
                    @endif
                    <div class="current-image-info">
                        <p>{{ $product->image ? basename($product->image) : 'Belum ada gambar' }}</p>
                        <span>{{ $product->image ? 'Upload gambar baru untuk mengganti' : 'Upload gambar produk di bawah' }}</span>
                    </div>
                </div>

             
                <div class="upload-zone" id="uploadZone">
                    <input type="file"
                           name="image"
                           id="imageInput"
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
                    <div class="new-preview" id="newPreview">
                        <img id="previewImg" src="#" alt="Preview baru">
                        <p class="text-muted mt-2 mb-0" style="font-size:12px;" id="previewName"></p>
                    </div>
                </div>

                @error('image')
                    <div class="invalid-feedback d-flex mt-2"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
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
    // ── Image Upload Preview ──
    const imageInput = document.getElementById('imageInput');
    const uploadZone = document.getElementById('uploadZone');
    const newPreview = document.getElementById('newPreview');
    const previewImg = document.getElementById('previewImg');
    const previewName = document.getElementById('previewName');

    imageInput.addEventListener('change', handleFile);

    uploadZone.addEventListener('dragover', e => {
        e.preventDefault();
        uploadZone.classList.add('drag-over');
    });

    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('drag-over');
    });

    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('drag-over');
        if (e.dataTransfer.files[0]) {
            imageInput.files = e.dataTransfer.files;
            handleFile();
        }
    });

    function handleFile() {
        const file = imageInput.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewName.textContent = '✓ ' + file.name;
            newPreview.style.display = 'block';

            // Update current image card preview too
            const currentImg = document.getElementById('currentImg');
            if (currentImg) {
                currentImg.style.transition = 'opacity 0.3s ease';
                currentImg.style.opacity = '0.4';
            }
        };
        reader.readAsDataURL(file);
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