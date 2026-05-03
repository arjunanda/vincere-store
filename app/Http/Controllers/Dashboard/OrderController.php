<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use DashboardHelpers;

    public function index()
    {
        $orders = Transaction::latest()->paginate(10);
        return view('dashboard.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'status' => 'required|in:success,failed',
        ]);

        $payment_status = $data['status'] == 'success' ? 'paid' : 'failed';
        $transaction->update([
            'payment_status'  => $payment_status,
            'delivery_status' => $data['status'],
        ]);

        // Dispatch Real-time Event via Reverb
        event(new \App\Events\OrderStatusUpdated($transaction));

        $this->logActivity('UPDATE_ORDER', "Mengubah status pesanan {$transaction->order_id} menjadi {$data['status']}");

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui!',
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
