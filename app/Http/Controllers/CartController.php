<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Pasang middleware auth agar hanya user terautentikasi yang mengakses controller ini.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan isi keranjang.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->ensureNotAdmin();

        $cart = session()->get('cart', []);

        // Hitung total harga dan jumlah item
        $total = 0;
        $itemCount = 0;
        foreach ($cart as $item) {
            $qty = isset($item['qty']) ? (int) $item['qty'] : 0;
            $price = isset($item['price']) ? (float) $item['price'] : 0;
            $total += $qty * $price;
            $itemCount += $qty;
        }

        return view('cart.index', compact('cart', 'total', 'itemCount'));
    }

    /**
     * Tambah produk ke keranjang (session).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $this->ensureNotAdmin();

        // Validasi input
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1'
        ]);

        $qty = isset($data['qty']) ? (int) $data['qty'] : 1;

        $product = Product::findOrFail($data['product_id']);

        // Optional: jika model Product punya kolom 'stock', bisa cek ketersediaan
        if (isset($product->stock) && $product->stock !== null && $product->stock < $qty) {
            return redirect()->back()->with('error', 'Stok produk tidak cukup untuk jumlah yang diminta.');
        }

        $cart = session()->get('cart', []);

        // Gunakan string key agar konsisten
        $id = (string) $product->id;

        if (isset($cart[$id])) {
            // Jika sudah ada, tambahkan quantity
            $cart[$id]['qty'] = (int) $cart[$id]['qty'] + $qty;
        } else {
            // Tambah item baru
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $product->price,
                'image' => $product->image ?? null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Hapus item dari keranjang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $this->ensureNotAdmin();

        $data = $request->validate([
            'id' => 'required',
        ]);

        $id = (string) $data['id'];

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);

            // Jika cart kosong, hapus session cart sepenuhnya
            if (empty($cart)) {
                session()->forget('cart');
            } else {
                session()->put('cart', $cart);
            }

            return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
    }

    /**
     * Pastikan user bukan admin. Jika admin, batalkan akses.
     *
     * @return void
     */
    protected function ensureNotAdmin()
    {
        $user = Auth::user();

        // Asumsi: model User punya method isAdmin() atau atribut is_admin
        $isAdmin = false;
        if ($user) {
            if (method_exists($user, 'isAdmin')) {
                $isAdmin = (bool) $user->isAdmin();
            } elseif (isset($user->is_admin)) {
                $isAdmin = (bool) $user->is_admin;
            } elseif (isset($user->role) && $user->role === 'admin') {
                $isAdmin = true;
            }
        }

        if ($isAdmin) {
            // Kamu bisa mengganti abort(403) dengan redirect ke dashboard jika diinginkan
            abort(403, 'Akses ditolak.');
        }
    }
}
