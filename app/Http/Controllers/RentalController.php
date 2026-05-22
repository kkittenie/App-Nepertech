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
            'duration_value'  => 'required|integer|min:1|max:120',
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

        return redirect()->back()
            ->with('success', 'Pengajuan sewa Anda berhasil dikirim! Admin kami akan meninjau pengajuan dan menghubungi Anda segera via WhatsApp.');
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

        return redirect()->route('admin.rentals.index')
            ->with('success', 'Pengajuan sewa telah ditolak.');
    }
}
