<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard hanya boleh diakses oleh admin yang sudah login.
     */
    public function __construct()
    {
        // pastikan middleware is_admin terdaftar di Kernel.php
        $this->middleware(['auth', 'is_admin']);
    }

    /**
     * Tampilkan halaman dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Ambil count dengan try/catch supaya tidak crash bila model/table belum siap
        try {
            $productCount = Product::query()->count();
        } catch (\Throwable $e) {
            $productCount = 0;
        }

        try {
            $orderCount = Order::query()->count();
        } catch (\Throwable $e) {
            $orderCount = 0;
        }

        try {
            $userCount = User::query()->count();
        } catch (\Throwable $e) {
            $userCount = 0;
        }

        // jumlah item di session cart (jika ada)
        $activeCarts = is_array(session('cart', [])) ? count(session('cart', [])) : 0;

        return view('dashboard', [
            'productCount' => $productCount,
            'orderCount'   => $orderCount,
            'userCount'    => $userCount,
            'activeCarts'  => $activeCarts,
            'user'         => Auth::user(),
        ]);
    }
}
