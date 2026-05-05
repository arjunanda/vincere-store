<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VipaymentService
{
    protected $apiId;
    protected $apiKey;
    protected $baseUrl;
    protected $sign;

    public function __construct()
    {
        // Mengambil konfigurasi dari file .env
        $this->apiId = env('VIPAYMENT_API_ID', '');
        $this->apiKey = env('VIPAYMENT_API_KEY', '');
        
        // Base URL default untuk VIPayment Game Feature, bisa diubah via .env jika ada update
        $this->baseUrl = env('VIPAYMENT_BASE_URL', 'https://vip-reseller.co.id/api/game-feature');
        
        // VIPayment menggunakan md5(api_id + api_key) untuk parameter sign
        $this->sign = md5($this->apiId . $this->apiKey);
    }

    /**
     * Mengambil daftar layanan (produk) dari VIPayment
     */
    public function getServices()
    {
        try {
            $response = Http::asForm()->post($this->baseUrl, [
                'key' => $this->apiKey,
                'sign' => $this->sign,
                'type' => 'services'
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('VIPayment Get Services Error: ' . $e->getMessage());
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Melakukan pesanan / topup ke VIPayment
     * 
     * @param string $serviceCode Kode layanan/produk dari VIPayment
     * @param string $target Target tujuan (misal User ID)
     * @param string|null $zone Zone ID (opsional untuk game tertentu seperti MLBB)
     */
    public function createOrder($serviceCode, $target, $zone = null)
    {
        try {
            // Gabungkan target dan zone (umumnya VIPayment menggunakan format UserIDZoneID digabung jika ada)
            $targetData = $zone ? $target . $zone : $target;

            $response = Http::asForm()->post($this->baseUrl, [
                'key' => $this->apiKey,
                'sign' => $this->sign,
                'type' => 'order',
                'service' => $serviceCode,
                'data_no' => $targetData
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('VIPayment Create Order Error: ' . $e->getMessage());
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Cek status transaksi di VIPayment berdasarkan trxid
     * 
     * @param string $trxId ID transaksi dari VIPayment yang didapat saat createOrder
     */
    public function checkStatus($trxId)
    {
        try {
            $response = Http::asForm()->post($this->baseUrl, [
                'key' => $this->apiKey,
                'sign' => $this->sign,
                'type' => 'status',
                'trxid' => $trxId
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('VIPayment Check Status Error: ' . $e->getMessage());
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }
}
