@extends('layouts.admin')

@section('title', 'Edit Mitra')

@section('content')

<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                Edit Mitra
            </h2>
            <p class="text-muted mb-0 small">
                Ubah data mitra industri
            </p>
        </div>
        <a href="{{ route('mitras.index') }}" class="btn-cancel">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card form-card">

        <form action="{{ route('mitras.update', $mitra->id) }}"
              method="POST"
              enctype="multipart/form-data"
              id="mitraForm"
              novalidate>
            @csrf
            @method('PUT')

            <div class="form-section">
                <p class="section-label">Detail Mitra</p>

                <div class="edit-badge">
                    <i class="ti ti-pencil" style="font-size:12px"></i> Mengedit: {{ $mitra->name }}
                </div>

                <label class="form-label">
                    Nama Mitra <span style="color:#ef4444">*</span>
                </label>

                <input type="text"
                       name="name"
                       id="nameInput"
                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       placeholder="Contoh: PT. Griya Sarana Informatika"
                       value="{{ old('name', $mitra->name) }}"
                       maxlength="255"
                       autocomplete="off"
                       required>

                @error('name')
                    <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <p class="section-label">Logo Mitra</p>

                @if($mitra->logo)
                    <div class="current-image-card">
                        <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}" style="object-fit: contain;">
                        <div class="current-image-info">
                            <p>Logo Saat Ini</p>
                            <span>Upload logo baru untuk mengganti</span>
                        </div>
                    </div>
                @endif

                <label class="form-label">Upload Logo Baru (Opsional)</label>

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
                        JPG, PNG, WEBP — Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah.
                    </p>
                </div>

                <div class="new-preview" id="newPreview">
                    <img src="" alt="Preview Baru" id="previewImg">
                </div>

                @error('logo')
                    <div class="invalid-feedback" style="display:flex"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section" style="background:#fafbfc;">
                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="btn-spinner" id="btnSpinner"></div>
                        <i class="ti ti-check" id="btnIcon"></i>
                        <span id="btnText">Simpan Perubahan</span>
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
    const newPreview = document.getElementById('newPreview');
    const previewImg = document.getElementById('previewImg');

    logoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                newPreview.style.display = 'block';
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
