{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Daftar Produk (Admin)</h1>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Produk</a>
  </div>

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Gambar</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Kategori</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Harga</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Stok</th>
          <th class="px-4 py-2 text-right text-sm font-medium text-gray-600">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        @forelse($products as $i => $product)
        <tr>
          <td class="px-4 py-3 text-sm text-gray-700">{{ $products->firstItem() + $i }}</td>
          <td class="px-4 py-3">
            @if($product->image)
              <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-12 object-cover rounded">
            @else
              <div class="w-16 h-12 bg-gray-100 flex items-center justify-center text-xs text-gray-400 rounded">no img</div>
            @endif
          </td>
          <td class="px-4 py-3 text-sm text-gray-700">{{ $product->name }}</td>
          <td class="px-4 py-3 text-sm text-gray-700">{{ optional($product->category)->name ?? '-' }}</td>
          <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</td>
          <td class="px-4 py-3 text-sm text-gray-700">{{ $product->stock ?? '-' }}</td>
          <td class="px-4 py-3 text-sm text-right">
            <a href="{{ route('admin.products.edit', $product) }}" class="inline-block px-3 py-1 mr-2 border rounded text-sm">Edit</a>

            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="inline-block px-3 py-1 bg-red-500 text-white rounded text-sm">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td class="px-4 py-6 text-center text-gray-500" colspan="7">Belum ada produk.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $products->links() }}
  </div>
</div>
@endsection
