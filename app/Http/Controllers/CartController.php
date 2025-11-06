<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $r)
    {
        $product = Product::findOrFail($r->product_id);
        $cart = session()->get('cart', []);
        $id = $product->id;
        if(isset($cart[$id])){
            $cart[$id]['qty'] += $r->qty ?? 1;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "qty" => $r->qty ?? 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success','Produk ditambahkan ke keranjang.');
    }

    public function remove(Request $r)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$r->id])){
            unset($cart[$r->id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }
}
