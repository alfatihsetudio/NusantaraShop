<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // kalau masih pakai middleware is_admin, bisa diaktifkan:
        // $this->middleware(['auth', 'is_admin']);
        // atau cukup auth:
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // ambil ringkasan sederhana, tahan error jika model tidak ada
        try {
            $productCount = Product::count();
        } catch (\Throwable $e) {
            $productCount = 0;
        }

        try {
            $orderCount = Order::count();
        } catch (\Throwable $e) {
            $orderCount = 0;
        }

        try {
            $userCount = User::count();
        } catch (\Throwable $e) {
            $userCount = 0;
        }

        // jika tidak ada view admin.dashboard, kita fallback ke view dashboard (publik)
        if (view()->exists('admin.dashboard')) {
            return view('admin.dashboard', compact('productCount', 'orderCount', 'userCount'));
        }

        // fallback sederhana — tampilkan teks (aman)
        return response()->view('dashboard', [
            'productCount' => $productCount,
            'orderCount' => $orderCount,
            'userCount' => $userCount,
        ]);
    }
}
