{{-- resources/views/admin/products/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

  <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium text-gray-700">Nama</label>
      <input name="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Kategori</label>
      <select name="category_id" class="mt-1 block w-full border rounded px-3 py-2">
        <option value="">-- Pilih kategori --</option>
        @foreach(\App\Models\Category::all() as $cat)
          <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Harga (angka)</label>
      <input name="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full border rounded px-3 py-2" type="number" min="0">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Stok</label>
      <input name="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full border rounded px-3 py-2" type="number" min="0">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Gambar saat ini</label>
      @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-20 object-cover rounded mb-2">
      @else
        <div class="w-32 h-20 bg-gray-100 flex items-center justify-center text-xs text-gray-400 rounded mb-2">no img</div>
      @endif
      <input name="image" type="file" class="mt-1 block w-full">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
      <textarea name="description" class="mt-1 block w-full border rounded px-3 py-2" rows="4">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="flex items-center gap-2">
      <button class="px-4 py-2 bg-green-600 text-white rounded" type="submit">Update</button>
      <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded">Batal</a>
    </div>
  </form>
</div>
@endsection
