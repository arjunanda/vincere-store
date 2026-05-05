<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\VipaymentService;
use Illuminate\Http\Request;

class VipaymentController extends Controller
{
    protected $vipaymentService;

    public function __construct(VipaymentService $vipaymentService)
    {
        $this->vipaymentService = $vipaymentService;
    }

    /**
     * Endpoint API internal untuk mendapatkan list layanan dari VIPayment.
     * Biasanya di-hit menggunakan AJAX dari Dashboard untuk proses sinkronisasi produk.
     */
    public function services()
    {
        $response = $this->vipaymentService->getServices();
        
        return response()->json($response);
    }

    /**
     * Endpoint API internal untuk mengecek status transaksi di VIPayment.
     * Dapat digunakan saat admin ingin mengecek status manual dari Dashboard Order.
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'trxid' => 'required|string'
        ]);

        $response = $this->vipaymentService->checkStatus($request->trxid);
        
        return response()->json($response);
    }
}
