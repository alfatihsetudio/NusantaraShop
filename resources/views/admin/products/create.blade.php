{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Tambah Produk</h1>

  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
    @csrf

    <div>
      <label class="block text-sm font-medium text-gray-700">Nama</label>
      <input name="name" value="{{ old('name') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
      @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Kategori</label>
      <select name="category_id" class="mt-1 block w-full border rounded px-3 py-2">
        <option value="">-- Pilih kategori --</option>
        @foreach(\App\Models\Category::all() as $cat)
          <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Harga (angka)</label>
      <input name="price" value="{{ old('price') }}" class="mt-1 block w-full border rounded px-3 py-2" type="number" min="0">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Stok</label>
      <input name="stock" value="{{ old('stock', 0) }}" class="mt-1 block w-full border rounded px-3 py-2" type="number" min="0">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Gambar</label>
      <input name="image" type="file" class="mt-1 block w-full">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
      <textarea name="description" class="mt-1 block w-full border rounded px-3 py-2" rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="flex items-center gap-2">
      <button class="px-4 py-2 bg-green-600 text-white rounded" type="submit">Simpan</button>
      <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded">Batal</a>
    </div>
  </form>
</div>
@endsection
