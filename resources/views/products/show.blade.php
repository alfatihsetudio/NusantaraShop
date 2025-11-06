@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
      <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/600x400' }}" alt="{{ $product->name }}" class="w-full rounded">
    </div>
    <div>
      <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
      <p class="text-xl text-red-600 mt-2">Rp {{ number_format($product->price,0,',','.') }}</p>
      <p class="mt-4 text-gray-700">{{ $product->description }}</p>

      <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="flex items-center gap-2">
          <input type="number" name="qty" value="1" min="1" class="w-20 border p-2 rounded">
          <button class="bg-green-600 text-white px-4 py-2 rounded">Tambah ke Keranjang</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
