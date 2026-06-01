@extends('layouts.admin')

@section('title', 'Tambah Mitra')

@section('content')

<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                Tambah Mitra
            </h2>
            <p class="text-muted mb-0 small">
                Tambahkan mitra industri baru beserta logonya
            </p>
        </div>
        <a href="{{ route('mitras.index') }}" class="btn-cancel">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card form-card">

        <form action="{{ route('mitras.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="mitraForm"
              novalidate>
            @csrf

            <div class="form-section">
                <p class="section-label">Detail Mitra</p>

                <label class="form-label">
                    Nama Mitra <span style="color:#ef4444">*</span>
                </label>

                <input type="text"
                       name="name"
                       id="nameInput"
                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       placeholder="Contoh: PT. Griya Sarana Informatika"
                       value="{{ old('name') }}"
                       maxlength="255"
                       autocomplete="off"
                       required>

                @error('name')
                    <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <p class="section-label">Logo Mitra</p>

                <label class="form-label">Upload Logo (Opsional)</label>

                <div class="upload-zone" id="uploadZone">
                    <input type="file"
                           name="logo"
                           id="logoInput"
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    <div class="upload-icon"><i class="ti ti-photo-up"></i></div>
                    <p style="font-size:13px; font-weight:600; color:#0a2540; margin:0 0 4px">
                        Klik atau seret gambar ke sini
                    </p>
                    <p style="font-size:12px; color:#94a3b8; margin:0;">
                        JPG, PNG, WEBP — Maksimal 2MB
                    </p>
                </div>

                <div class="upload-preview" id="uploadPreview">
                    <img src="" alt="Preview" id="previewImg">
                </div>

                @error('logo')
                    <div class="invalid-feedback" style="display:flex"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section" style="background:#fafbfc;">
                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="btn-spinner" id="btnSpinner"></div>
                        <i class="ti ti-plus" id="btnIcon"></i>
                        <span id="btnText">Simpan Mitra</span>
                    </button>
                    <a href="{{ route('mitras.index') }}" class="btn-cancel">
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
    // ── Upload preview ──
    const logoInput = document.getElementById('logoInput');
    const uploadZone = document.getElementById('uploadZone');
    const uploadPreview = document.getElementById('uploadPreview');
    const previewImg = document.getElementById('previewImg');

    logoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                uploadPreview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Drag & drop
    uploadZone.addEventListener('dragover', (e) => { e.preventDefault(); uploadZone.classList.add('drag-over'); });
    uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('drag-over'));
    uploadZone.addEventListener('drop', (e) => { e.preventDefault(); uploadZone.classList.remove('drag-over'); });

    // ── Submit loading state ──
    const form       = document.getElementById('mitraForm');
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

    // ── Live validation ──
    const nameInput = document.getElementById('nameInput');
    nameInput.addEventListener('blur', () => {
        if (!nameInput.value.trim()) nameInput.classList.add('is-invalid');
        else nameInput.classList.remove('is-invalid');
    });
    nameInput.addEventListener('input', () => {
        if (nameInput.value.trim()) nameInput.classList.remove('is-invalid');
    });
</script>
@endpush
