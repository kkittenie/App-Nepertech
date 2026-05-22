<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send WhatsApp Message via Fonnte or log it as a fallback.
     *
     * @param string $phone
     * @param string $message
     * @return array
     */
    public static function sendMessage(string $phone, string $message): array
    {
        $token = config('services.fonnte.token');

        // Normalize Indonesian phone number (e.g., 0812... -> 62812...)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '08')) {
            $phone = '628' . substr($phone, 2);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '628' . substr($phone, 1);
        }

        if (empty($token) || $token === 'your_fonnte_token_here') {
            Log::info("WhatsApp Simulated Notification (No FONNTE_TOKEN in config/services.php):\nTo: {$phone}\nMessage:\n{$message}");
            return [
                'status' => true,
                'simulated' => true,
                'message' => 'Simulasi sukses! Pesan dicatat di log karena FONNTE_TOKEN belum diatur.',
                'log_content' => $message
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62'
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp sent successfully via Fonnte to {$phone}. Response: " . $response->body());
                return [
                    'status' => true,
                    'simulated' => false,
                    'message' => 'Pesan WhatsApp berhasil dikirim via Fonnte.',
                    'response' => $response->json()
                ];
            }

            Log::error("Fonnte API error sending WhatsApp to {$phone}. Status: " . $response->status() . " Body: " . $response->body());
            return [
                'status' => false,
                'simulated' => false,
                'message' => 'Gagal mengirim pesan WhatsApp. Fonnte API error: ' . $response->body(),
                'response' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error("Exception occurred while sending WhatsApp to {$phone}: " . $e->getMessage());
            return [
                'status' => false,
                'simulated' => false,
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }
}
