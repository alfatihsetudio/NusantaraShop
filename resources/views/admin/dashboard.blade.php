{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white rounded shadow">
      <div class="text-sm text-gray-500">Produk</div>
      <div class="text-3xl font-semibold">{{ $productCount ?? 0 }}</div>
    </div>

    <div class="p-4 bg-white rounded shadow">
      <div class="text-sm text-gray-500">Pesanan</div>
      <div class="text-3xl font-semibold">{{ $orderCount ?? 0 }}</div>
    </div>

    <div class="p-4 bg-white rounded shadow">
      <div class="text-sm text-gray-500">Pengguna</div>
      <div class="text-3xl font-semibold">{{ $userCount ?? 0 }}</div>
    </div>
  </div>

  <div class="mt-6">
    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Kelola Produk</a>
  </div>
</div>
@endsection
