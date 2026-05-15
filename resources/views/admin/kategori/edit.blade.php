@extends('layouts.admin')

@section('title', 'Ubah Kategori')

@section('content')

<div class="container-fluid py-4">

    
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="edit-badge">
                <i class="ti ti-pencil" style="font-size:13px"></i>
                Mode Edit
            </div>
            <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                {{ $kategori->name }}
            </h2>
            <p class="text-muted mb-0 small">
                Ubah nama kategori sesuai kebutuhan
            </p>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn-cancel">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>

    
    <div class="card form-card">

        <form action="{{ route('kategori.update', $kategori->id) }}"
              method="POST"
              id="katForm"
              novalidate>
            @csrf
            @method('PUT')

            
            <div class="form-section">
                <p class="section-label">Detail Kategori</p>

                
                <div class="current-val-card">
                    <div class="current-val-icon">
                        <i class="ti ti-tag"></i>
                    </div>
                    <div>
                        <p>{{ $kategori->name }}</p>
                        <span>Nama saat ini — edit field di bawah untuk mengubah</span>
                    </div>
                </div>

                <label class="form-label">
                    Nama Baru <span style="color:#ef4444">*</span>
                </label>

                <input type="text"
                       name="name"
                       id="nameInput"
                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       placeholder="Masukkan nama kategori..."
                       value="{{ old('name', $kategori->name) }}"
                       maxlength="60"
                       autocomplete="off"
                       required>

                <div class="char-counter" id="charCounter">0 / 60</div>

                @error('name')
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
                    <a href="{{ route('kategori.index') }}" class="btn-cancel">
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
    // ── Char counter ──
    const nameInput   = document.getElementById('nameInput');
    const charCounter = document.getElementById('charCounter');
    const maxLen = 60;

    function updateCounter() {
        const len = nameInput.value.length;
        charCounter.textContent = `${len} / ${maxLen}`;
        charCounter.classList.remove('warn', 'limit');
        if (len > maxLen * 0.8) charCounter.classList.add('warn');
        if (len >= maxLen)      charCounter.classList.add('limit');
    }

    nameInput.addEventListener('input', updateCounter);
    updateCounter();

    // ── Submit loading state ──
    const form       = document.getElementById('katForm');
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
    nameInput.addEventListener('blur', () => {
        if (!nameInput.value.trim()) nameInput.classList.add('is-invalid');
        else nameInput.classList.remove('is-invalid');
    });

    nameInput.addEventListener('input', () => {
        if (nameInput.value.trim()) nameInput.classList.remove('is-invalid');
    });
</script>
@endpush