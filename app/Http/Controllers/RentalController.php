<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Product;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Store a new rental request from the client.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'duration_type'   => 'required|in:bulanan,tahunan',
            'duration_value'  => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->duration_type === 'bulanan') {
                        if (!in_array((int)$value, [1, 3, 6])) {
                            $fail('Durasi sewa bulanan yang diperbolehkan hanya 1, 3, atau 6 bulan.');
                        }
                    } elseif ($request->duration_type === 'tahunan') {
                        if ((int)$value !== 1) {
                            $fail('Durasi sewa tahunan yang diperbolehkan hanya 1 tahun.');
                        }
                    }
                }
            ],
            'start_date'      => 'required|date|after_or_equal:today',
            'client_notes'    => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Calculate total price based on duration and pricing columns
        $pricePerUnit = $request->duration_type === 'tahunan' 
            ? $product->harga_sewa_tahunan 
            : $product->harga_sewa_bulanan;

        if (!$pricePerUnit || $pricePerUnit <= 0) {
            return redirect()->back()
                ->with('error', 'Produk ini tidak mendukung opsi penyewaan yang dipilih.');
        }

        $totalPrice = $pricePerUnit * $request->duration_value;

        // Store request
        $rental = Rental::create([
            'user_id'          => auth()->id(),
            'product_id'       => $product->id,
            'name'             => $request->name,
            'email'            => $request->email,
            'whatsapp_number'  => $request->whatsapp_number,
            'duration_type'    => $request->duration_type,
            'duration_value'   => $request->duration_value,
            'total_price'      => $totalPrice,
            'start_date'       => $request->start_date,
            'status'           => 'pending',
            'admin_notes'      => $request->client_notes, // Store client message in notes temporarily or as a request note
        ]);

        // Formulate and send dynamic WhatsApp notification to the Client
        $durationLabel  = $rental->duration_label;
        $formattedPrice = 'Rp ' . number_format($rental->total_price, 0, ',', '.');
        $formattedDate  = $rental->start_date->format('d M Y');

        $clientMessage = "*PENGAJUAN SEWA NEPERTECH* 📝\n\n";
        $clientMessage .= "Halo *{$rental->name}*,\n\n";
        $clientMessage .= "Terima kasih! Pengajuan penyewaan Anda untuk produk *{$rental->product->name}* telah kami terima.\n\n";
        $clientMessage .= "*Detail Pengajuan:*\n";
        $clientMessage .= "• Produk: *{$rental->product->name}*\n";
        $clientMessage .= "• Durasi: *{$durationLabel}*\n";
        $clientMessage .= "• Mulai Sewa: *{$formattedDate}*\n";
        $clientMessage .= "• Total Biaya: *{$formattedPrice}*\n\n";
        $clientMessage .= "Saat ini pengajuan Anda sedang ditinjau oleh Admin kami. Kami akan mengirimkan notifikasi WhatsApp selanjutnya setelah pengajuan disetujui.\n\n";
        $clientMessage .= "Terima kasih telah memilih Nepertech!\n";
        $clientMessage .= "---\n";
        $clientMessage .= "*BLUD SMKN 1 Cirebon*";

        // Dispatch WhatsApp notification to client
        WhatsAppService::sendMessage($rental->whatsapp_number, $clientMessage);

        // Formulate and send dynamic WhatsApp notification to the Admin (if configured)
        $adminPhone = config('services.fonnte.admin_phone');
        if (!empty($adminPhone)) {
            $adminMessage = "*PENGAJUAN SEWA BARU - NEPERTECH* 🔔\n\n";
            $adminMessage .= "Halo Admin,\n\n";
            $adminMessage .= "Ada pengajuan sewa baru yang memerlukan tinjauan Anda.\n\n";
            $adminMessage .= "*Detail Pengajuan:*\n";
            $adminMessage .= "• Pemohon: *{$rental->name}* ({$rental->whatsapp_number})\n";
            $adminMessage .= "• Produk: *{$rental->product->name}*\n";
            $adminMessage .= "• Durasi: *{$durationLabel}*\n";
            $adminMessage .= "• Total Biaya: *{$formattedPrice}*\n\n";
            $adminMessage .= "Silakan masuk ke Dashboard Admin Nepertech untuk menyetujui atau menolak pengajuan ini.\n";
            $adminMessage .= "Link Dashboard: " . route('admin.rentals.index') . "\n\n";
            $adminMessage .= "---\n";
            $adminMessage .= "*Sistem Otomatis Nepertech*";

            // Dispatch WhatsApp notification to admin
            WhatsAppService::sendMessage($adminPhone, $adminMessage);
        }

        return redirect()->back()
            ->with('success', 'Pengajuan sewa Anda berhasil dikirim! Kami telah mengirimkan detail pengajuan ke WhatsApp Anda.');
    }

    /**
     * Admin view to manage rental requests.
     */
    public function index(Request $request)
    {
        $pendingRentals  = Rental::with('product', 'user')->where('status', 'pending')->latest()->get();
        $approvedRentals = Rental::with('product', 'user')->where('status', 'approved')->latest()->get();
        $rejectedRentals = Rental::with('product', 'user')->where('status', 'rejected')->latest()->get();

        return view('admin.rental.index', compact('pendingRentals', 'approvedRentals', 'rejectedRentals'));
    }

    /**
     * Admin action to approve a rental request and trigger WhatsApp notification.
     */
    public function approve(Request $request, Rental $rental)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $rental->update([
            'status'      => 'approved',
            'admin_notes' => $request->admin_notes,
        ]);

        // Formulate professional WhatsApp message in Indonesian
        $formattedPrice = 'Rp ' . number_format($rental->total_price, 0, ',', '.');
        $formattedDate  = $rental->start_date->format('d M Y');
        $durationLabel  = $rental->duration_label;

        $waMessage = "*PEMBERITAHUAN PENYEWAAN NEPERTECH* 🚀\n\n";
        $waMessage .= "Halo *{$rental->name}*,\n\n";
        $waMessage .= "Kabar baik! Pengajuan penyewaan Anda untuk produk *{$rental->product->name}* telah *DISETUJUI* oleh Admin Nepertech.\n\n";
        $waMessage .= "*Detail Penyewaan:*\n";
        $waMessage .= "• Produk: *{$rental->product->name}*\n";
        $waMessage .= "• Durasi: *{$durationLabel}*\n";
        $waMessage .= "• Mulai Sewa: *{$formattedDate}*\n";
        $waMessage .= "• Total Biaya: *{$formattedPrice}*\n\n";

        if ($request->admin_notes) {
            $waMessage .= "*Catatan Admin:*\n";
            $waMessage .= "\"{$request->admin_notes}\"\n\n";
        }

        $waMessage .= "Admin kami akan menghubungi Anda segera melalui WhatsApp ini untuk proses administrasi lebih lanjut, penyerahan akses/lisensi produk, serta petunjuk pembayaran.\n\n";
        $waMessage .= "Terima kasih telah mempercayai Nepertech!\n";
        $waMessage .= "---\n";
        $waMessage .= "*BLUD SMKN 1 Cirebon*";

        // Dispatch WhatsApp notification
        $waResult = WhatsAppService::sendMessage($rental->whatsapp_number, $waMessage);

        $successMsg = 'Pengajuan sewa berhasil disetujui.';
        if (isset($waResult['simulated']) && $waResult['simulated']) {
            return redirect()->route('admin.rentals.index')
                ->with('success', $successMsg)
                ->with('whatsapp_simulated', [
                    'phone'   => $rental->whatsapp_number,
                    'message' => $waMessage,
                ]);
        }

        return redirect()->route('admin.rentals.index')
            ->with('success', $successMsg . ' Pesan WhatsApp notifikasi telah dikirim.');
    }

    /**
     * Admin action to reject a rental request.
     */
    public function reject(Request $request, Rental $rental)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $rental->update([
            'status'      => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        // Formulate and send dynamic WhatsApp notification to the Client for rejection
        $durationLabel  = $rental->duration_label;
        $formattedPrice = 'Rp ' . number_format($rental->total_price, 0, ',', '.');

        $clientMessage = "*STATUS PENGAJUAN SEWA NEPERTECH* ❌\n\n";
        $clientMessage .= "Halo *{$rental->name}*,\n\n";
        $clientMessage .= "Mohon maaf, pengajuan penyewaan Anda untuk produk *{$rental->product->name}* saat ini *BELUM DAPAT DISETUJUI* oleh Admin Nepertech.\n\n";
        $clientMessage .= "*Detail Pengajuan:*\n";
        $clientMessage .= "• Produk: *{$rental->product->name}*\n";
        $clientMessage .= "• Durasi: *{$durationLabel}*\n";
        $clientMessage .= "• Total Biaya: *{$formattedPrice}*\n\n";

        if ($request->admin_notes) {
            $clientMessage .= "*Catatan / Alasan Admin:*\n";
            $clientMessage .= "\"{$request->admin_notes}\"\n\n";
        }

        $clientMessage .= "Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi admin kami melalui WhatsApp ini.\n\n";
        $clientMessage .= "Terima kasih atas pengertian Anda.\n";
        $clientMessage .= "---\n";
        $clientMessage .= "*BLUD SMKN 1 Cirebon*";

        // Dispatch WhatsApp notification
        $waResult = WhatsAppService::sendMessage($rental->whatsapp_number, $clientMessage);

        $successMsg = 'Pengajuan sewa telah ditolak.';
        if (isset($waResult['simulated']) && $waResult['simulated']) {
            return redirect()->route('admin.rentals.index')
                ->with('success', $successMsg)
                ->with('whatsapp_simulated', [
                    'phone'   => $rental->whatsapp_number,
                    'message' => $clientMessage,
                ]);
        }

        return redirect()->route('admin.rentals.index')
            ->with('success', $successMsg . ' Pesan WhatsApp notifikasi penolakan telah dikirim.');
    }

    /**
     * Send a WhatsApp renewal reminder to the tenant (called from dashboard alert).
     */
    public function remind(Rental $rental)
    {
        $formattedPrice = 'Rp ' . number_format($rental->total_price, 0, ',', '.');
        $endDate        = $rental->end_date->format('d M Y');
        $daysRemaining  = $rental->days_remaining;
        $durationLabel  = $rental->duration_label;

        if ($daysRemaining < 0) {
            $timeInfo = "masa sewa Anda sudah *BERAKHIR* sejak *{$endDate}* (" . abs($daysRemaining) . " hari yang lalu)";
        } elseif ($daysRemaining === 0) {
            $timeInfo = "masa sewa Anda *BERAKHIR HARI INI* ({$endDate})";
        } else {
            $timeInfo = "masa sewa Anda akan berakhir dalam *{$daysRemaining} hari lagi* (tanggal *{$endDate}*)";
        }

        $waMessage  = "*PENGINGAT MASA SEWA - NEPERTECH* ⏰\n\n";
        $waMessage .= "Halo *{$rental->name}*,\n\n";
        $waMessage .= "Kami ingin menginformasikan bahwa {$timeInfo}.\n\n";
        $waMessage .= "*Detail Langganan:*\n";
        $waMessage .= "• Produk: *{$rental->product->name}*\n";
        $waMessage .= "• Durasi: *{$durationLabel}*\n";
        $waMessage .= "• Biaya Sewa: *{$formattedPrice}*\n";
        $waMessage .= "• Tanggal Berakhir: *{$endDate}*\n\n";
        $waMessage .= "Jika Anda ingin *memperpanjang masa sewa*, silakan hubungi kami segera agar layanan Anda tidak terganggu.\n\n";
        $waMessage .= "Terima kasih telah menggunakan layanan Nepertech!\n";
        $waMessage .= "---\n";
        $waMessage .= "*BLUD SMKN 1 Cirebon*";

        $waResult = WhatsAppService::sendMessage($rental->whatsapp_number, $waMessage);

        $successMsg = "Pengingat berhasil dikirim ke WhatsApp {$rental->name}.";

        if (isset($waResult['simulated']) && $waResult['simulated']) {
            return redirect()->route('dashboard')
                ->with('success', $successMsg)
                ->with('whatsapp_simulated', [
                    'phone'   => $rental->whatsapp_number,
                    'message' => $waMessage,
                ]);
        }

        return redirect()->route('dashboard')
            ->with('success', $successMsg . ' Pesan terkirim via WhatsApp.');
    }
}
