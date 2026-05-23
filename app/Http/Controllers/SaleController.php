<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    /**
     * Store a new purchase request from the client.
     */ 
    public function store(Request $request)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'client_notes'    => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->harga_jual || $product->harga_jual <= 0) {
            return redirect()->back()
                ->with('error', 'Produk ini tidak tersedia untuk pembelian jual lepas.');
        }

        // Store purchase request
        $sale = Sale::create([
            'user_id'          => auth()->id(),
            'product_id'       => $product->id,
            'name'             => $request->name,
            'email'            => $request->email,
            'whatsapp_number'  => $request->whatsapp_number,
            'total_price'      => $product->harga_jual,
            'payment_token'    => Str::random(32),
            'status'           => 'pending',
            'client_notes'     => $request->client_notes,
        ]);

        // Format price
        $formattedPrice = 'Rp ' . number_format($sale->total_price, 0, ',', '.');

        // ── WhatsApp notification to Client ──
        $clientMessage = "*PENGAJUAN PEMBELIAN NEPERTECH* 🛒\n\n";
        $clientMessage .= "Halo *{$sale->name}*,\n\n";
        $clientMessage .= "Terima kasih! Pengajuan pembelian Anda untuk produk *{$sale->product->name}* telah kami terima.\n\n";
        $clientMessage .= "*Detail Pengajuan:*\n";
        $clientMessage .= "• Produk: *{$sale->product->name}*\n";
        $clientMessage .= "• Tipe: *Jual Lepas (Beli Penuh)*\n";
        $clientMessage .= "• Total Harga: *{$formattedPrice}*\n\n";

        if ($sale->client_notes) {
            $clientMessage .= "*Catatan Anda:*\n";
            $clientMessage .= "\"{$sale->client_notes}\"\n\n";
        }

        $clientMessage .= "Saat ini pengajuan Anda sedang ditinjau oleh Admin kami. Kami akan mengirimkan notifikasi WhatsApp selanjutnya setelah pengajuan disetujui.\n\n";
        $clientMessage .= "Terima kasih telah memilih Nepertech!\n";
        $clientMessage .= "---\n";
        $clientMessage .= "*BLUD SMKN 1 Cirebon*";

        WhatsAppService::sendMessage($sale->whatsapp_number, $clientMessage);

        // ── WhatsApp notification to Admin ──
        $adminPhone = config('services.fonnte.admin_phone');
        if (!empty($adminPhone)) {
            $adminMessage = "*PENGAJUAN PEMBELIAN BARU - NEPERTECH* 🔔\n\n";
            $adminMessage .= "Halo Admin,\n\n";
            $adminMessage .= "Ada pengajuan pembelian (jual lepas) baru yang memerlukan tinjauan Anda.\n\n";
            $adminMessage .= "*Detail Pengajuan:*\n";
            $adminMessage .= "• Pembeli: *{$sale->name}* ({$sale->whatsapp_number})\n";
            $adminMessage .= "• Produk: *{$sale->product->name}*\n";
            $adminMessage .= "• Total Harga: *{$formattedPrice}*\n\n";
            $adminMessage .= "Silakan masuk ke Dashboard Admin Nepertech untuk menyetujui atau menolak pengajuan ini.\n";
            $adminMessage .= "Link Dashboard: " . route('admin.sales.index') . "\n\n";
            $adminMessage .= "---\n";
            $adminMessage .= "*Sistem Otomatis Nepertech*";

            WhatsAppService::sendMessage($adminPhone, $adminMessage);
        }

        return redirect()->back()
            ->with('success', 'Pengajuan pembelian Anda berhasil dikirim! Kami telah mengirimkan detail pengajuan ke WhatsApp Anda.');
    }

    /**
     * Admin view to manage sale/purchase requests.
     */
    public function index(Request $request)
    {
        $pendingSales   = Sale::with('product', 'user')->where('status', 'pending')->latest()->get();
        $awaitingSales  = Sale::with('product', 'user')->where('status', 'awaiting_payment')->latest()->get();
        $submittedSales = Sale::with('product', 'user')->where('status', 'payment_submitted')->latest()->get();
        $completedSales = Sale::with('product', 'user')->where('status', 'completed')->latest()->get();
        $rejectedSales  = Sale::with('product', 'user')->where('status', 'rejected')->latest()->get();

        return view('admin.sale.index', compact(
            'pendingSales',
            'awaitingSales',
            'submittedSales',
            'completedSales',
            'rejectedSales'
        ));
    }

    /**
     * Admin action to approve a purchase request and trigger WhatsApp notification.
     */
    public function approve(Request $request, Sale $sale)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $sale->update([
            'status'      => 'awaiting_payment',
            'admin_notes' => $request->admin_notes,
        ]);

        $formattedPrice = 'Rp ' . number_format($sale->total_price, 0, ',', '.');
        $paymentLink = route('sale.payment', $sale->payment_token);

        $waMessage = "*PEMBERITAHUAN PEMBELIAN NEPERTECH* 🎉\n\n";
        $waMessage .= "Halo *{$sale->name}*,\n\n";
        $waMessage .= "Kabar baik! Pengajuan pembelian Anda untuk produk *{$sale->product->name}* telah *DISETUJUI* oleh Admin Nepertech.\n\n";
        $waMessage .= "*Detail Pembelian:*\n";
        $waMessage .= "• Produk: *{$sale->product->name}*\n";
        $waMessage .= "• Tipe: *Jual Lepas (Beli Penuh)*\n";
        $waMessage .= "• Total Harga: *{$formattedPrice}*\n\n";

        if ($request->admin_notes) {
            $waMessage .= "*Catatan Admin:*\n";
            $waMessage .= "\"{$request->admin_notes}\"\n\n";
        }

        $waMessage .= "⚠️ *LANGKAH SELANJUTNYA - PEMBAYARAN*\n";
        $waMessage .= "Silakan klik link berikut untuk melihat instruksi pembayaran dan mengunggah bukti transfer Anda:\n";
        $waMessage .= "👉 {$paymentLink}\n\n";
        
        $waMessage .= "Terima kasih telah mempercayai Nepertech!\n";
        $waMessage .= "---\n";
        $waMessage .= "*BLUD SMKN 1 Cirebon*";

        $waResult = WhatsAppService::sendMessage($sale->whatsapp_number, $waMessage);

        $successMsg = 'Pengajuan pembelian berhasil disetujui.';
        if (isset($waResult['simulated']) && $waResult['simulated']) {
            return redirect()->route('admin.sales.index')
                ->with('success', $successMsg)
                ->with('whatsapp_simulated', [
                    'phone'   => $sale->whatsapp_number,
                    'message' => $waMessage,
                ]);
        }

        return redirect()->route('admin.sales.index')
            ->with('success', $successMsg . ' Pesan WhatsApp notifikasi telah dikirim.');
    }

    /**
     * Admin action to reject a purchase request.
     */
    public function reject(Request $request, Sale $sale)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $sale->update([
            'status'      => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        $formattedPrice = 'Rp ' . number_format($sale->total_price, 0, ',', '.');

        $clientMessage = "*STATUS PENGAJUAN PEMBELIAN NEPERTECH* ❌\n\n";
        $clientMessage .= "Halo *{$sale->name}*,\n\n";
        $clientMessage .= "Mohon maaf, pengajuan pembelian Anda untuk produk *{$sale->product->name}* saat ini *BELUM DAPAT DISETUJUI* oleh Admin Nepertech.\n\n";
        $clientMessage .= "*Detail Pengajuan:*\n";
        $clientMessage .= "• Produk: *{$sale->product->name}*\n";
        $clientMessage .= "• Tipe: *Jual Lepas (Beli Penuh)*\n";
        $clientMessage .= "• Total Harga: *{$formattedPrice}*\n\n";

        if ($request->admin_notes) {
            $clientMessage .= "*Catatan / Alasan Admin:*\n";
            $clientMessage .= "\"{$request->admin_notes}\"\n\n";
        }

        $clientMessage .= "Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi admin kami melalui WhatsApp ini.\n\n";
        $clientMessage .= "Terima kasih atas pengertian Anda.\n";
        $clientMessage .= "---\n";
        $clientMessage .= "*BLUD SMKN 1 Cirebon*";

        $waResult = WhatsAppService::sendMessage($sale->whatsapp_number, $clientMessage);

        $successMsg = 'Pengajuan pembelian telah ditolak.';
        if (isset($waResult['simulated']) && $waResult['simulated']) {
            return redirect()->route('admin.sales.index')
                ->with('success', $successMsg)
                ->with('whatsapp_simulated', [
                    'phone'   => $sale->whatsapp_number,
                    'message' => $clientMessage,
                ]);
        }

        return redirect()->route('admin.sales.index')
            ->with('success', $successMsg . ' Pesan WhatsApp notifikasi penolakan telah dikirim.');
    }

    /**
     * Show payment page to client.
     */
    public function paymentPage($token)
    {
        $sale = Sale::with('product')->where('payment_token', $token)->firstOrFail();
        return view('sale.payment', compact('sale'));
    }

    /**
     * Client submits payment receipt.
     */
    public function submitPayment(Request $request, $token)
    {
        $sale = Sale::where('payment_token', $token)->firstOrFail();

        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('payments/sales', 'public');
            $sale->update([
                'payment_receipt' => $path,
                'status'          => 'payment_submitted',
            ]);

            // ── WhatsApp notification to Admin ──
            $adminPhone = config('services.fonnte.admin_phone');
            if (!empty($adminPhone)) {
                $formattedPrice  = 'Rp ' . number_format($sale->total_price, 0, ',', '.');
                $adminMessage  = "*BUKTI PEMBAYARAN MASUK - NEPERTECH* 📸\n\n";
                $adminMessage .= "Halo Admin,\n\n";
                $adminMessage .= "User *{$sale->name}* telah mengirimkan bukti pembayaran untuk transaksi berikut:\n\n";
                $adminMessage .= "*Detail Transaksi:*\n";
                $adminMessage .= "• Pembeli: *{$sale->name}* ({$sale->whatsapp_number})\n";
                $adminMessage .= "• Produk: *{$sale->product->name}*\n";
                $adminMessage .= "• Total: *{$formattedPrice}*\n\n";
                $adminMessage .= "Silakan cek dashboard untuk memverifikasi dan mengkonfirmasi pembayaran.\n";
                $adminMessage .= "Link Dashboard: " . route('admin.sales.index') . "\n\n";
                $adminMessage .= "---\n";
                $adminMessage .= "*Sistem Otomatis Nepertech*";

                WhatsAppService::sendMessage($adminPhone, $adminMessage);
            }
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim! Silakan tunggu konfirmasi dari admin kami.');
    }

    /**
     * Admin approves payment and triggers final delivery.
     */
    public function approvePayment(Request $request, Sale $sale)
    {
        $sale->update([
            'status' => 'completed',
        ]);

        $formattedPrice = 'Rp ' . number_format($sale->total_price, 0, ',', '.');

        $waMessage = "*PEMBAYARAN BERHASIL DIVALIDASI* ✅\n\n";
        $waMessage .= "Halo *{$sale->name}*,\n\n";
        $waMessage .= "Kami telah menerima dan memverifikasi pembayaran Anda sebesar *{$formattedPrice}* untuk produk *{$sale->product->name}*.\n\n";
        $waMessage .= "Tim Nepertech akan segera menghubungi Anda secara personal melalui nomor WhatsApp ini untuk proses penyerahan akses web, username, dan password.\n\n";
        $waMessage .= "Terima kasih banyak atas pembelian Anda!\n";
        $waMessage .= "---\n";
        $waMessage .= "*BLUD SMKN 1 Cirebon*";

        $waResult = WhatsAppService::sendMessage($sale->whatsapp_number, $waMessage);

        $successMsg = 'Pembayaran berhasil diverifikasi.';
        if (isset($waResult['simulated']) && $waResult['simulated']) {
            return redirect()->route('admin.sales.index')
                ->with('success', $successMsg)
                ->with('whatsapp_simulated', [
                    'phone'   => $sale->whatsapp_number,
                    'message' => $waMessage,
                ]);
        }

        return redirect()->route('admin.sales.index')
            ->with('success', $successMsg . ' Pesan konfirmasi berhasil dikirim.');
    }
}
