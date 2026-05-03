<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $baseUrl;

    public function __construct()
    {
        // Default to the provided IP if not set in .env
        $this->baseUrl = rtrim(env('WA_GATEWAY_URL', 'http://217.15.167.231:1880'), '/');
    }

    /**
     * Kirim pesan teks ke nomor WhatsApp tertentu
     */
    public function sendMessage(string $phone, string $message)
    {
        try {
            $response = Http::post("{$this->baseUrl}/send", [
                'phone' => $this->formatPhone($phone),
                'message' => $message,
            ]);

            $result = $response->json();

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'WA_SEND_MESSAGE',
                'description' => "Send WA to {$phone}. Status: " . ($result['status'] ?? 'unknown') . ". Response: " . json_encode($result),
                'ip_address' => request()->ip()
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error("WhatsApp sendMessage Error: " . $e->getMessage());

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'WA_SEND_MESSAGE_ERROR',
                'description' => "Failed to send WA to {$phone}: " . $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Kirim pesan gambar dengan caption
     */
    public function sendImage(string $phone, string $imageUrl, string $caption = '')
    {
        try {
            $response = Http::post("{$this->baseUrl}/send-image", [
                'phone' => $this->formatPhone($phone),
                'image_url' => $imageUrl,
                'caption' => $caption,
            ]);

            $result = $response->json();

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'WA_SEND_IMAGE',
                'description' => "Send WA Image to {$phone}. Status: " . ($result['status'] ?? 'unknown') . ". Response: " . json_encode($result),
                'ip_address' => request()->ip()
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error("WhatsApp sendImage Error: " . $e->getMessage());

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'WA_SEND_IMAGE_ERROR',
                'description' => "Failed to send WA Image to {$phone}: " . $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Set URL Webhook untuk menerima pesan masuk
     */
    public function setWebhook(string $url)
    {
        try {
            $response = Http::post("{$this->baseUrl}/webhook", [
                'url' => $url,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error("WhatsApp setWebhook Error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Format nomor telepon agar diawali dengan 62
     */
    protected function formatPhone(string $phone): string
    {
        // Hapus karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 0, ganti dengan 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Jika diawali +, hapus (sudah dilakukan oleh preg_replace)

        return $phone;
    }
}
