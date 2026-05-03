<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    /**
     * Handle incoming WhatsApp message webhook from the blast service.
     * 
     * Format expected:
     * {
     *   "event": "message",
     *   "data": {
     *     "from": "62xxx@s.whatsapp.net",
     *     "message": "ORDER_ID | success"
     *   }
     * }
     */
    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('WhatsApp Webhook Received:', $payload);

        // Check if event is message
        if (($payload['event'] ?? '') !== 'message') {
            return response()->json(['status' => 'ignored', 'reason' => 'not a message event']);
        }

        $message = $payload['data']['message'] ?? '';
        
        // Parse "order_id | success"
        if (preg_match('/^([A-Z0-9\-]+)\s*\|\s*success$/i', $message, $matches)) {
            $orderId = trim($matches[1]);
            
            $transaction = Transaction::where('order_id', $orderId)->first();

            if ($transaction) {
                // If it's already success, don't do anything
                if ($transaction->delivery_status === 'success') {
                    return response()->json(['status' => 'ignored', 'reason' => 'already success']);
                }

                $transaction->update([
                    'payment_status' => 'paid',
                    'delivery_status' => 'success'
                ]);

                Log::info("Order {$orderId} marked as SUCCESS via WhatsApp Webhook");

                return response()->json([
                    'status' => 'success',
                    'message' => "Order {$orderId} updated"
                ]);
            }

            return response()->json(['status' => 'not_found', 'reason' => 'order not found'], 404);
        }

        return response()->json(['status' => 'ignored', 'reason' => 'message format mismatch']);
    }
}
