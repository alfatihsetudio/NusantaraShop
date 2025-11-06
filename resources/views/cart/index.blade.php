@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Keranjang</h1>
  @if(session('cart') && count(session('cart')) > 0)
    <table class="w-full bg-white rounded shadow">
      <thead>
        <tr class="text-left">
          <th class="p-3">Produk</th>
          <th class="p-3">Qty</th>
          <th class="p-3">Harga</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @foreach(session('cart') as $item)
          @php $total += $item['price'] * $item['qty']; @endphp
          <tr>
            <td class="p-3">{{ $item['name'] }}</td>
            <td class="p-3">{{ $item['qty'] }}</td>
            <td class="p-3">Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}</td>
            <td class="p-3">
              <form action="{{ route('cart.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $item['id'] }}">
                <button class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
        <tr>
          <td colspan="2" class="p-3 font-semibold">Total</td>
          <td class="p-3 font-semibold">Rp {{ number_format($total,0,',','.') }}</td>
          <td></td>
        </tr>
      </tbody>
    </table>
  @else
    <p>Keranjang kosong.</p>
  @endif
</div>
@endsection
