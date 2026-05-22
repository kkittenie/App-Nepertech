@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')

<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#0a2540; font-size:1.5rem;">
                Tambah Kategori
            </h2>
            <p class="text-muted mb-0 small">
                Buat kategori baru untuk mengelompokkan produk
            </p>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn-cancel">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card form-card">

        <form action="{{ route('kategori.store') }}"
              method="POST"
              id="katForm"
              novalidate>
            @csrf

            <div class="form-section">
                <p class="section-label">Detail Kategori</p>

                <label class="form-label">
                    Nama Kategori <span style="color:#ef4444">*</span>
                </label>

                <input type="text"
                       name="name"
                       id="nameInput"
                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       placeholder="Contoh: Website Development"
                       value="{{ old('name') }}"
                       maxlength="60"
                       autocomplete="off"
                       required>

                <div class="char-counter" id="charCounter">0 / 60</div>

                @error('name')
                    <div class="invalid-feedback"><i class="ti ti-alert-circle"></i>{{ $message }}</div>
                @enderror

                <div class="hint-chips" id="hintChips">
                    <span class="hint-chip" data-val="Website Development">Website Development</span>
                    <span class="hint-chip" data-val="Desain Grafis">Desain Grafis</span>
                    <span class="hint-chip" data-val="IoT">IoT</span>
                    <span class="hint-chip" data-val="Copywriting">Copywriting</span>
                    <span class="hint-chip" data-val="Video Editing">Video Editing</span>
                </div>
            </div>

            {{-- ===== ICON PICKER ===== --}}
            <div class="form-section">
                <p class="section-label">Icon Kategori</p>

                <input type="hidden" name="icon" id="iconInput" value="{{ old('icon', 'ti ti-tag') }}">

                <label class="form-label">Pilih Icon</label>
                <div class="icon-picker-trigger" id="iconPickerTrigger">
                    <span class="icon-picker-preview">
                        <i id="iconPreview" class="{{ old('icon', 'ti ti-tag') }}"></i>
                    </span>
                    <span id="iconPickerLabel">{{ old('icon', 'ti ti-tag') }}</span>
                    <i class="ti ti-chevron-down ms-auto"></i>
                </div>

                <div class="icon-picker-panel" id="iconPickerPanel">
                    <div class="icon-picker-search-wrap">
                        <i class="ti ti-search"></i>
                        <input type="text" class="icon-picker-search" id="iconSearch" placeholder="Cari icon...">
                    </div>
                    <div class="icon-picker-grid" id="iconGrid"></div>
                </div>
            </div>

            <div class="form-section" style="background:#fafbfc;">
                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="btn-spinner" id="btnSpinner"></div>
                        <i class="ti ti-plus" id="btnIcon"></i>
                        <span id="btnText">Simpan Kategori</span>
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

@push('styles')
<style>
/* ── Icon Picker ── */
.icon-picker-trigger {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    background: #fff;
    font-size: 14px;
    color: #0a2540;
    font-weight: 500;
    transition: border-color .2s, box-shadow .2s;
    user-select: none;
}
.icon-picker-trigger:hover,
.icon-picker-trigger.open {
    border-color: #2c6b9e;
    box-shadow: 0 0 0 3px rgba(44,107,158,.12);
}
.icon-picker-preview {
    width: 36px; height: 36px;
    background: rgba(10,37,64,.06);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    color: #0a2540;
    flex-shrink: 0;
}
.icon-picker-panel {
    display: none;
    margin-top: 8px;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 8px 32px rgba(10,37,64,.1);
    overflow: hidden;
}
.icon-picker-panel.open { display: block; }
.icon-picker-search-wrap {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 16px;
    border-bottom: 1px solid #f0f4f8;
}
.icon-picker-search-wrap i { color: #94a3b8; font-size: 16px; }
.icon-picker-search {
    border: none; outline: none;
    font-size: 14px; width: 100%;
    color: #0a2540;
    background: transparent;
}
.icon-picker-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(52px, 1fr));
    gap: 4px;
    padding: 12px;
    max-height: 280px;
    overflow-y: auto;
}
.icon-item {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 3px;
    padding: 8px 4px;
    border-radius: 8px;
    cursor: pointer;
    transition: background .15s, transform .15s;
    font-size: 20px;
    color: #0a2540;
    border: 2px solid transparent;
}
.icon-item:hover { background: rgba(44,107,158,.08); transform: scale(1.1); }
.icon-item.selected {
    background: rgba(44,107,158,.12);
    border-color: #2c6b9e;
    color: #2c6b9e;
}
.icon-item span {
    font-size: 9px;
    color: #94a3b8;
    text-align: center;
    line-height: 1.2;
    word-break: break-all;
    display: none;
}
</style>
@endpush

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

    // ── Hint chips ──
    document.querySelectorAll('.hint-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            nameInput.value = chip.dataset.val;
            nameInput.focus();
            updateCounter();
            nameInput.classList.remove('is-invalid');
        });
    });

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

    // ── Icon Picker ──
    const ICONS = [
        { cls: 'ti ti-tag',            label: 'Tag' },
        { cls: 'ti ti-code',           label: 'Code' },
        { cls: 'ti ti-world',          label: 'Web' },
        { cls: 'ti ti-device-desktop', label: 'Desktop' },
        { cls: 'ti ti-device-mobile',  label: 'Mobile' },
        { cls: 'ti ti-palette',        label: 'Desain' },
        { cls: 'ti ti-photo',          label: 'Foto' },
        { cls: 'ti ti-video',          label: 'Video' },
        { cls: 'ti ti-pencil',         label: 'Tulis' },
        { cls: 'ti ti-bulb',           label: 'Ide' },
        { cls: 'ti ti-cpu',            label: 'CPU' },
        { cls: 'ti ti-circuit-board',  label: 'IoT' },
        { cls: 'ti ti-wifi',           label: 'WiFi' },
        { cls: 'ti ti-cloud',          label: 'Cloud' },
        { cls: 'ti ti-server',         label: 'Server' },
        { cls: 'ti ti-database',       label: 'DB' },
        { cls: 'ti ti-api',            label: 'API' },
        { cls: 'ti ti-robot',          label: 'AI' },
        { cls: 'ti ti-chart-bar',      label: 'Chart' },
        { cls: 'ti ti-trending-up',    label: 'Trend' },
        { cls: 'ti ti-megaphone',      label: 'Promosi' },
        { cls: 'ti ti-brand-instagram',label: 'IG' },
        { cls: 'ti ti-brand-facebook', label: 'FB' },
        { cls: 'ti ti-brand-youtube',  label: 'YT' },
        { cls: 'ti ti-movie',          label: 'Film' },
        { cls: 'ti ti-music',          label: 'Musik' },
        { cls: 'ti ti-microphone',     label: 'Mic' },
        { cls: 'ti ti-camera',         label: 'Kamera' },
        { cls: 'ti ti-printer',        label: 'Cetak' },
        { cls: 'ti ti-file-text',      label: 'Dokumen' },
        { cls: 'ti ti-clipboard',      label: 'Clipboard' },
        { cls: 'ti ti-mail',           label: 'Email' },
        { cls: 'ti ti-message',        label: 'Chat' },
        { cls: 'ti ti-phone',          label: 'Telepon' },
        { cls: 'ti ti-settings',       label: 'Setting' },
        { cls: 'ti ti-tool',           label: 'Tools' },
        { cls: 'ti ti-bolt',           label: 'Kilat' },
        { cls: 'ti ti-star',           label: 'Bintang' },
        { cls: 'ti ti-heart',          label: 'Hati' },
        { cls: 'ti ti-shield',         label: 'Aman' },
        { cls: 'ti ti-lock',           label: 'Kunci' },
        { cls: 'ti ti-key',            label: 'Key' },
        { cls: 'ti ti-user',           label: 'User' },
        { cls: 'ti ti-users',          label: 'Tim' },
        { cls: 'ti ti-building',       label: 'Gedung' },
        { cls: 'ti ti-home',           label: 'Rumah' },
        { cls: 'ti ti-map-pin',        label: 'Lokasi' },
        { cls: 'ti ti-truck',          label: 'Kirim' },
        { cls: 'ti ti-shopping-cart',  label: 'Belanja' },
        { cls: 'ti ti-package',        label: 'Paket' },
        { cls: 'ti ti-award',          label: 'Award' },
        { cls: 'ti ti-certificate',    label: 'Sertif' },
        { cls: 'ti ti-book',           label: 'Buku' },
        { cls: 'ti ti-school',         label: 'Edu' },
        { cls: 'ti ti-plant',          label: 'Hijau' },
        { cls: 'ti ti-recycle',        label: 'Daur' },
    ];

    const iconInput   = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');
    const iconLabel   = document.getElementById('iconPickerLabel');
    const trigger     = document.getElementById('iconPickerTrigger');
    const panel       = document.getElementById('iconPickerPanel');
    const grid        = document.getElementById('iconGrid');
    const search      = document.getElementById('iconSearch');

    let selectedIcon  = iconInput.value || 'ti ti-tag';

    function renderGrid(filter = '') {
        grid.innerHTML = '';
        const q = filter.toLowerCase();
        ICONS.filter(ic => !q || ic.label.toLowerCase().includes(q) || ic.cls.includes(q))
             .forEach(ic => {
                const el = document.createElement('div');
                el.className = 'icon-item' + (ic.cls === selectedIcon ? ' selected' : '');
                el.title = ic.label;
                el.innerHTML = `<i class="${ic.cls}"></i>`;
                el.addEventListener('click', () => {
                    selectedIcon = ic.cls;
                    iconInput.value = ic.cls;
                    iconPreview.className = ic.cls;
                    iconLabel.textContent = ic.cls;
                    grid.querySelectorAll('.icon-item').forEach(e => e.classList.remove('selected'));
                    el.classList.add('selected');
                });
                grid.appendChild(el);
             });
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = panel.classList.toggle('open');
        trigger.classList.toggle('open', isOpen);
        if (isOpen) { search.value = ''; renderGrid(); search.focus(); }
    });

    search.addEventListener('input', () => renderGrid(search.value));

    document.addEventListener('click', (e) => {
        if (!panel.contains(e.target) && e.target !== trigger) {
            panel.classList.remove('open');
            trigger.classList.remove('open');
        }
    });

    renderGrid();
</script>
@endpush