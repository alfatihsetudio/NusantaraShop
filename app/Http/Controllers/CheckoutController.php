<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function checkout(Request $r)
    {
        $cart = session('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error','Keranjang kosong');
        }

        // total gross
        $gross = 0;
        $items = [];
        foreach($cart as $c) {
            $gross += $c['price'] * $c['qty'];
            $items[] = [
                'id' => $c['id'],
                'price' => (int)$c['price'],
                'quantity' => (int)$c['qty'],
                'name' => $c['name'],
            ];
        }

        // buat order sementara di DB
        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $r->input('name', 'Guest'),
            'customer_phone' => $r->input('phone', ''),
            'customer_address' => $r->input('address', ''),
            'total' => $gross,
            'status' => 'pending',
            'payment_type' => null,
            'payment_token' => null,
        ]);

        foreach($cart as $c) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $c['id'],
                'qty' => $c['qty'],
                'price' => $c['price'],
            ]);
        }

        // Midtrans config
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $transaction_details = [
            'order_id' => 'ORDER-'.$order->id.'-'.time(),
            'gross_amount' => (int)$gross
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone' => $order->customer_phone,
                'address' => $order->customer_address,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // simpan token ke order
        $order->update(['payment_token' => $snapToken]);

        return view('checkout.payment', compact('snapToken','order'));
    }
}
