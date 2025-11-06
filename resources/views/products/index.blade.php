@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Produk</h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($products as $p)
    <div class="bg-white rounded shadow p-4">
      <a href="{{ route('product.show', $p->slug) }}">
        <div class="h-40 bg-gray-100 flex items-center justify-center mb-3">
          <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/200' }}" class="max-h-36" alt="{{ $p->name }}">
        </div>
        <h2 class="font-medium">{{ $p->name }}</h2>
        <p class="text-sm text-gray-600">Rp {{ number_format($p->price,0,',','.') }}</p>
      </a>
      <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
        @csrf
        <input type="hidden" name="product_id" value="{{ $p->id }}">
        <button class="w-full bg-blue-600 text-white py-2 rounded">Tambah ke Keranjang</button>
      </form>
    </div>
    @endforeach
  </div>
  <div class="mt-6">
    {{ $products->links() }}
  </div>
</div>
@endsection
