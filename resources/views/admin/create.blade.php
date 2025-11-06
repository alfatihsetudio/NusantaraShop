@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
  <h1 class="text-2xl mb-4">Tambah Produk</h1>

  @if($errors->any())
    <div class="mb-4 p-3 bg-red-100 rounded">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
    @csrf
    <div class="mb-3">
      <label class="block text-sm">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-3">
      <label class="block text-sm">Kategori</label>
      <select name="category_id" class="w-full border p-2 rounded">
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="block text-sm">Harga</label>
      <input type="number" name="price" value="{{ old('price') }}" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-3">
      <label class="block text-sm">Stok</label>
      <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full border p-2 rounded">
    </div>

    <div class="mb-3">
      <label class="block text-sm">Deskripsi</label>
      <textarea name="description" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
      <label class="block text-sm">Gambar</label>
      <input type="file" name="image" accept="image/*">
    </div>

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
  </form>
</div>
@endsection
