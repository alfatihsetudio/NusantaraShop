<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class MidtransController extends Controller
{
    public function webhook(Request $r)
    {
        $payload = json_decode($r->getContent(), true);

        // contoh simple: update order by order_id parsing
        $orderIdRaw = $payload['order_id'] ?? ($payload['transaction_id'] ?? null);
        $transactionStatus = $payload['transaction_status'] ?? ($payload['status_code'] ?? null);

        // Jika kamu menyimpan order id di transaction_details.order_id, parse order id
        if(isset($payload['order_id'])) {
            $orderRaw = $payload['order_id']; // format bisa disesuaikan
            // contoh kita pakai format ORDER-{order.id}-{timestamp}
            if(str_starts_with($orderRaw, 'ORDER-')) {
                $parts = explode('-', $orderRaw);
                $orderId = $parts[1] ?? null;
            } else {
                $orderId = null;
            }
        } else {
            $orderId = null;
        }

        if($orderId) {
            $order = Order::find($orderId);
            if($order) {
                // contoh mapping sederhana
                if(isset($payload['transaction_status']) && $payload['transaction_status'] === 'capture') {
                    $order->update(['status'=>'paid']);
                } elseif(isset($payload['transaction_status']) && $payload['transaction_status'] === 'settlement') {
                    $order->update(['status'=>'paid']);
                } elseif(isset($payload['transaction_status']) && $payload['transaction_status'] === 'deny') {
                    $order->update(['status'=>'failed']);
                } elseif(isset($payload['transaction_status']) && $payload['transaction_status'] === 'cancel') {
                    $order->update(['status'=>'cancelled']);
                } elseif(isset($payload['transaction_status']) && $payload['transaction_status'] === 'expire') {
                    $order->update(['status'=>'expired']);
                } elseif(isset($payload['transaction_status']) && $payload['transaction_status'] === 'pending') {
                    $order->update(['status'=>'pending']);
                }
            }
        }

        return response()->json(['ok' => true]);
    }
}
