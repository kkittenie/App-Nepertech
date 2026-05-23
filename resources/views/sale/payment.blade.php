@extends('layouts.landing')

@section('title', 'Pembayaran ' . $sale->product->name . ' — Nepertech')

@push('styles')
<style>
    body {
        background-color: #f1f5f9;
        font-family: 'Inter', sans-serif;
    }
    #navbar {
        background: rgba(255, 255, 255, 0.97) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .payment-container {
        max-width: 820px;
        margin: 120px auto 60px;
        padding: 0 20px;
    }

    /* ── Cards ── */
    .payment-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .payment-header {
        background: linear-gradient(135deg, #0a2540 0%, #1e4d7b 100%);
        padding: 32px 36px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .payment-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .payment-header::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -30px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .payment-header h2 {
        font-weight: 800;
        margin-bottom: 6px;
        font-size: 22px;
        position: relative;
        z-index: 1;
    }
    .payment-header p {
        opacity: 0.7;
        font-size: 13.5px;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    .payment-body {
        padding: 36px 40px;
    }

    /* ── Price Box ── */
    .price-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 14px;
        padding: 22px;
        text-align: center;
        margin-bottom: 28px;
        border: 1.5px dashed #cbd5e1;
    }
    .price-box p {
        margin: 0 0 4px 0;
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .price-box h3 {
        margin: 0;
        color: #0f172a;
        font-size: 34px;
        font-weight: 800;
    }

    /* ── Warning Alert (Instruction) ── */
    .screenshot-warning {
        background: linear-gradient(135deg, #fffbeb 0%, #fef9c3 100%);
        border: 1.5px solid #fde68a;
        border-left: 5px solid #f59e0b;
        padding: 18px 20px;
        border-radius: 12px;
        margin-bottom: 28px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .screenshot-warning .warn-icon {
        font-size: 26px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .screenshot-warning h5 {
        color: #92400e;
        font-size: 14.5px;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .screenshot-warning p {
        color: #78350f;
        font-size: 13.5px;
        margin: 0;
        line-height: 1.65;
    }

    /* ── QRIS Box ── */
    .qris-section {
        text-align: center;
        margin-bottom: 36px;
    }
    .qris-section h5 {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 16px;
        font-size: 16px;
    }
    .qris-wrapper {
        display: inline-block;
        background: white;
        padding: 20px;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 12px 30px rgba(0,0,0,0.07);
    }
    .qris-wrapper img {
        max-width: 260px;
        border-radius: 10px;
        display: block;
    }
    .qris-label {
        margin-top: 12px;
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }

    /* ── Divider ── */
    .section-divider {
        border: none;
        border-top: 1.5px solid #e2e8f0;
        margin: 36px 0;
    }

    /* ── Upload Box ── */
    .upload-box {
        border: 2.5px dashed #cbd5e1;
        border-radius: 14px;
        padding: 32px;
        text-align: center;
        background: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .upload-box:hover {
        border-color: #3b82f6;
        background: #eff6ff;
        transform: translateY(-2px);
    }
    .upload-box i {
        font-size: 42px;
        color: #94a3b8;
        margin-bottom: 14px;
        display: block;
    }
    .upload-box h5 {
        color: #475569;
        font-size: 15px;
        margin-bottom: 5px;
        font-weight: 600;
    }
    .upload-box p {
        color: #94a3b8;
        font-size: 13px;
        margin: 0;
    }

    /* ── Status Badges ── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .status-awaiting  { background: #fef3c7; color: #b45309; }
    .status-submitted { background: #e0e7ff; color: #4338ca; }
    .status-completed { background: #dcfce7; color: #16a34a; }

    /* ── Submit Button ── */
    .btn-submit {
        background: linear-gradient(135deg, #0a2540 0%, #1e4d7b 100%);
        color: white;
        border: none;
        padding: 15px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        width: 100%;
        transition: all 0.3s ease;
        margin-top: 16px;
    }
    .btn-submit:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(10,37,64,0.25);
    }

    /* ── File Preview ── */
    .file-preview {
        display: none;
        margin-top: 20px;
        text-align: center;
    }
    .file-preview img {
        max-width: 100%;
        max-height: 260px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border: 1.5px solid #e2e8f0;
    }

    /* ── Steps Info ── */
    .steps-info {
        display: flex;
        gap: 10px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .step-item {
        flex: 1;
        min-width: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 6px;
        padding: 14px 10px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }
    .step-item .step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #0a2540;
        color: white;
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .step-item.active-step {
        border-color: #3b82f6;
        background: #eff6ff;
        color: #1d4ed8;
    }
    .step-item.active-step .step-num {
        background: #2563eb;
    }
    .step-item.done-step {
        border-color: #86efac;
        background: #f0fdf4;
        color: #15803d;
    }
    .step-item.done-step .step-num {
        background: #16a34a;
    }

    /* ── Screenshot Modal ── */
    .screenshot-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(10, 37, 64, 0.75);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .screenshot-modal-box {
        background: white;
        border-radius: 20px;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 25px 60px rgba(0,0,0,0.25);
        overflow: hidden;
        animation: modalPop 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes modalPop {
        from { transform: scale(0.85); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
    .screenshot-modal-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        padding: 24px 28px;
        color: white;
        text-align: center;
    }
    .screenshot-modal-header .warn-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin-bottom: 12px;
        border: 2px solid rgba(255,255,255,0.4);
    }
    .screenshot-modal-header h4 {
        font-weight: 800;
        font-size: 18px;
        margin: 0;
    }
    .screenshot-modal-body {
        padding: 28px;
    }
    .screenshot-modal-body ul {
        padding: 0;
        list-style: none;
        margin: 0;
    }
    .screenshot-modal-body ul li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 14px;
        color: #374151;
        line-height: 1.6;
    }
    .screenshot-modal-body ul li .li-icon {
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #fef3c7;
        color: #d97706;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 2px;
        font-weight: 700;
    }
    .screenshot-modal-footer {
        padding: 0 28px 28px;
    }
    .btn-mengerti {
        width: 100%;
        background: linear-gradient(135deg, #0a2540 0%, #1e4d7b 100%);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-mengerti:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')

{{-- ── SCREENSHOT WARNING MODAL (auto-show on awaiting_payment) ── --}}
@if($sale->status === 'awaiting_payment')
<div class="screenshot-modal-overlay" id="screenshotWarningModal">
    <div class="screenshot-modal-box">
        <div class="screenshot-modal-header">
            <div class="warn-circle">⚠️</div>
            <h4>Perhatian Penting!</h4>
            <p style="opacity:0.85; font-size:13.5px; margin-top:6px; margin-bottom:0;">Baca sebelum melakukan pembayaran</p>
        </div>
        <div class="screenshot-modal-body">
            <ul>
                <li>
                    <div class="li-icon">📸</div>
                    <span><strong>Screenshot/foto bukti pembayaran QRIS</strong> segera setelah berhasil bayar — jangan tutup halaman dulu!</span>
                </li>
                <li>
                    <div class="li-icon">📤</div>
                    <span>Upload screenshot tersebut pada <strong>form yang ada di halaman ini</strong> (scroll ke bawah setelah scan QRIS).</span>
                </li>
                <li>
                    <div class="li-icon">⏳</div>
                    <span>Setelah upload, tunggu <strong>konfirmasi dari admin</strong> via WhatsApp untuk mendapatkan detail akses web.</span>
                </li>
                <li>
                    <div class="li-icon">✅</div>
                    <span>Admin akan mengirimkan link, username & password langsung <strong>via WhatsApp</strong> setelah pembayaran diverifikasi.</span>
                </li>
            </ul>
        </div>
        <div class="screenshot-modal-footer">
            <button class="btn-mengerti" onclick="dismissScreenshotWarning()">
                Saya Mengerti, Lanjutkan Bayar &rarr;
            </button>
        </div>
    </div>
</div>
@endif

<div class="payment-container">
    <div class="payment-card">
        <div class="payment-header">
            <h2>Halaman Pembayaran</h2>
            <p>ID Transaksi: #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }} &nbsp;·&nbsp; {{ $sale->product->name }}</p>
        </div>

        <div class="payment-body">

            @if(session('success'))
            <div class="alert d-flex align-items-center mb-4" style="border-radius: 12px; background:#dcfce7; border: 1.5px solid #bbf7d0; color:#166534;">
                <i class="fas fa-check-circle fs-5 me-3"></i>
                <div>
                    <strong>Berhasil!</strong><br>
                    {{ session('success') }}
                </div>
            </div>
            @endif

            {{-- Status Badge --}}
            <div class="text-center">
                @if($sale->status === 'awaiting_payment')
                    <span class="status-badge status-awaiting"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>
                @elseif($sale->status === 'payment_submitted')
                    <span class="status-badge status-submitted"><i class="fas fa-spinner fa-spin"></i> Bukti Sedang Diverifikasi</span>
                @elseif($sale->status === 'completed')
                    <span class="status-badge status-completed"><i class="fas fa-check-circle"></i> Pembayaran Dikonfirmasi</span>
                @endif
            </div>

            {{-- Progress Steps --}}
            <div class="steps-info">
                <div class="step-item done-step">
                    <div class="step-num">✓</div>
                    <span>Request Disetujui</span>
                </div>
                <div class="step-item {{ $sale->status === 'awaiting_payment' ? 'active-step' : 'done-step' }}">
                    <div class="step-num">{{ $sale->status === 'awaiting_payment' ? '2' : '✓' }}</div>
                    <span>Scan & Bayar QRIS</span>
                </div>
                <div class="step-item {{ $sale->status === 'payment_submitted' ? 'active-step' : ($sale->status === 'completed' ? 'done-step' : '') }}">
                    <div class="step-num">{{ $sale->status === 'completed' ? '✓' : '3' }}</div>
                    <span>Upload Bukti</span>
                </div>
                <div class="step-item {{ $sale->status === 'completed' ? 'done-step' : '' }}">
                    <div class="step-num">{{ $sale->status === 'completed' ? '✓' : '4' }}</div>
                    <span>Terima Akses</span>
                </div>
            </div>

            {{-- Buyer Info --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="text-muted small mb-1" style="font-weight:600; text-transform:uppercase; letter-spacing:.04em;">Produk</p>
                    <h5 class="fw-bold" style="color:#0f172a;">{{ $sale->product->name }}</h5>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <p class="text-muted small mb-1" style="font-weight:600; text-transform:uppercase; letter-spacing:.04em;">Atas Nama</p>
                    <h5 class="fw-bold" style="color:#0f172a;">{{ $sale->name }}</h5>
                </div>
            </div>

            {{-- Price Box --}}
            <div class="price-box">
                <p>Total yang Harus Dibayar</p>
                <h3>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</h3>
            </div>

            {{-- ── AWAITING PAYMENT STATE ── --}}
            @if($sale->status === 'awaiting_payment')

                {{-- Reminder Warning --}}
                <div class="screenshot-warning">
                    <div class="warn-icon">📸</div>
                    <div>
                        <h5>Harap Screenshot Bukti Pembayaran!</h5>
                        <p>Setelah scan & bayar QRIS di bawah, <strong>segera screenshot/foto bukti pembayaran</strong> sebelum menutup halaman ini. Upload bukti di form bawah agar admin dapat memverifikasi dan mengirim akses produk ke WhatsApp Anda.</p>
                    </div>
                </div>

                {{-- QRIS Section --}}
                <div class="qris-section">
                    <h5><i class="fas fa-qrcode me-2" style="color:#0a2540;"></i>Scan QRIS untuk Membayar</h5>
                    <div class="qris-wrapper">
                        <img src="{{ asset('images/qris-dummy.png') }}"
                             alt="QRIS Nepertech"
                             onerror="this.src='https://placehold.co/280x320/f8fafc/94a3b8?text=QRIS+NEPERTECH%0A%0AUpload+ke%3A%0Apublic%2Fimages%2Fqris-dummy.png'">
                    </div>
                    <p class="qris-label">a/n BLUD SMKN 1 Cirebon</p>
                </div>

                <hr class="section-divider">

                {{-- Upload Form --}}
                <h5 class="fw-bold mb-3 text-center" style="color:#0f172a;">Upload Bukti Pembayaran</h5>
                <form action="{{ route('sale.payment.submit', $sale->payment_token) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf

                    <div class="upload-box mb-3" onclick="document.getElementById('receiptFile').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h5>Klik untuk pilih screenshot</h5>
                        <p>Format JPG, PNG · Maks 5MB</p>
                        <input type="file" name="receipt" id="receiptFile" class="d-none" accept="image/jpeg,image/png,image/jpg" required onchange="previewImage(this)">
                    </div>

                    @error('receipt')
                        <div class="text-danger small text-center mb-3">{{ $message }}</div>
                    @enderror

                    <div class="file-preview" id="imagePreviewContainer">
                        <p class="text-muted small fw-semibold mb-2">Preview Bukti:</p>
                        <img id="imagePreview" src="#" alt="Preview">
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        Kirim Bukti Pembayaran <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </form>

            {{-- ── PAYMENT SUBMITTED STATE ── --}}
            @elseif($sale->status === 'payment_submitted')
                <div class="text-center py-4">
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $sale->payment_receipt) }}"
                             alt="Bukti Pembayaran"
                             style="max-width: 280px; border-radius: 14px; border: 1.5px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                    </div>
                    <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: #e0e7ff; color: #4338ca; font-size: 28px;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Bukti Diterima, Sedang Diverifikasi</h5>
                    <p class="text-muted" style="max-width: 380px; margin: 0 auto; line-height: 1.7;">
                        Tim kami sedang memverifikasi pembayaran Anda. Notifikasi konfirmasi beserta detail akses akan dikirim via <strong>WhatsApp</strong> segera setelah verifikasi selesai.
                    </p>
                </div>

            {{-- ── COMPLETED STATE ── --}}
            @elseif($sale->status === 'completed')
                <div class="text-center py-4">
                    <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: #dcfce7; color: #16a34a; font-size: 36px;">
                        <i class="fas fa-check"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Pembayaran Telah Dikonfirmasi!</h5>
                    <p class="text-muted" style="max-width: 400px; margin: 8px auto 0; line-height: 1.7;">
                        Terima kasih atas pembelian Anda! Tim kami sudah / akan segera menghubungi Anda via <strong>WhatsApp</strong> untuk menyerahkan detail akses produk web.
                    </p>
                    <div class="mt-4 p-3 rounded-3 d-inline-block" style="background: #f0fdf4; border: 1.5px solid #86efac;">
                        <i class="fab fa-whatsapp text-success me-2"></i>
                        <span class="small fw-semibold" style="color:#15803d;">Cek WhatsApp Anda untuk detail akses</span>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── Screenshot Warning Modal ──
    function dismissScreenshotWarning() {
        const modal = document.getElementById('screenshotWarningModal');
        if (modal) {
            modal.style.animation = 'fadeOut 0.25s ease forwards';
            setTimeout(() => modal.remove(), 250);
        }
    }

    // ── Payment Form Image Preview ──
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');
        const submitBtn = document.getElementById('submitBtn');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                submitBtn.innerHTML = 'Konfirmasi & Kirim Bukti <i class="fas fa-check-circle ms-2"></i>';
                submitBtn.style.background = 'linear-gradient(135deg, #16a34a 0%, #15803d 100%)';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<style>
@keyframes fadeOut {
    to { opacity: 0; transform: scale(0.95); }
}
</style>
@endpush
