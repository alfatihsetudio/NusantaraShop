@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Produk (Admin)</h1>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Produk</a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-200 rounded">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded shadow">
    <table class="min-w-full">
      <thead>
        <tr>
          <th class="p-3 border">ID</th>
          <th class="p-3 border">Nama</th>
          <th class="p-3 border">Harga</th>
          <th class="p-3 border">Stok</th>
          <th class="p-3 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $p)
          <tr>
            <td class="p-3 border">{{ $p->id }}</td>
            <td class="p-3 border">{{ $p->name }}</td>
            <td class="p-3 border">Rp {{ number_format($p->price,0,',','.') }}</td>
            <td class="p-3 border">{{ $p->stock }}</td>
            <td class="p-3 border">
              <a href="{{ route('admin.products.edit', $p) }}" class="px-2 py-1 bg-yellow-400 text-white rounded">Edit</a>
              <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk?')">
                @csrf
                @method('DELETE')
                <button class="px-2 py-1 bg-red-500 text-white rounded">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="p-4">
      {{ $products->links() }}
    </div>
  </div>
</div>
@endsection
