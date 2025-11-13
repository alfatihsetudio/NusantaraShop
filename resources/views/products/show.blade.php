{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
  {{-- Breadcrumb --}}
  <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
    <ol class="flex gap-2 items-center">
      <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
      <li>/</li>
      @if(optional($product->category)->name)
        <li><a href="#" class="hover:underline">{{ optional($product->category)->name }}</a></li>
        <li>/</li>
      @endif
      <li class="text-gray-700 font-medium">{{ Str::limit($product->name, 40) }}</li>
    </ol>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- LEFT: Images --}}
    <div class="lg:col-span-2">
      <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        {{-- Main image --}}
        @php
          // Support single image or array of images if available
          $images = [];
          if(isset($product->images) && is_array($product->images) && count($product->images)) {
            $images = $product->images;
          } elseif(!empty($product->image)) {
            $images = [$product->image];
          }
        @endphp

        <div class="w-full bg-gray-50 flex items-center justify-center" style="min-height:420px;">
          @if(count($images))
            <img id="main-product-image"
                 src="{{ asset('storage/'.$images[0]) }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="max-h-[420px] object-contain w-full">
          @else
            <img id="main-product-image"
                 src="https://via.placeholder.com/900x600?text=No+Image"
                 alt="No image"
                 class="max-h-[420px] object-contain w-full">
          @endif
        </div>

        {{-- Thumbnails --}}
        @if(count($images) > 1)
          <div class="p-4 border-t bg-white">
            <div class="flex gap-3 overflow-x-auto">
              @foreach($images as $img)
                <button type="button" class="thumbnail flex-shrink-0 border rounded-md p-1 hover:ring-2" data-src="{{ asset('storage/'.$img) }}">
                  <img src="{{ asset('storage/'.$img) }}" alt="thumb" class="h-20 w-28 object-cover rounded">
                </button>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      {{-- Description / details card --}}
      <div class="mt-6 bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-lg font-semibold mb-3">Detail Produk</h2>
        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>

        @if(!empty($product->specs) && is_array($product->specs))
          <div class="mt-4">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Spesifikasi</h3>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-700">
              @foreach($product->specs as $label => $value)
                <li class="flex justify-between border rounded px-3 py-2">
                  <span class="text-gray-600">{{ $label }}</span>
                  <span class="font-medium">{{ $value }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>

    {{-- RIGHT: Purchase card --}}
    <aside class="lg:col-span-1">
      <div class="sticky top-20 space-y-4">
        <div class="bg-white p-6 rounded-lg shadow">
          {{-- Title & rating --}}
          <h1 class="text-2xl font-bold leading-tight">{{ $product->name }}</h1>

          <div class="mt-2 flex items-center justify-between">
            <div class="flex items-center gap-3">
              {{-- rating (placeholder) --}}
              <div class="flex items-center gap-1 text-yellow-500">
                @php
                  $rating = $product->rating ?? 4.5;
                  $full = floor($rating);
                  $half = ($rating - $full) >= 0.5;
                @endphp
                @for($i=0;$i<$full;$i++)
                  <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.158c .969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3 .921-.755 1.688-1.54 1.118L10 13.347l-3.37 2.448c-.784.57-1.84-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.643 9.384c-.783-.57-.38-1.81.588-1.81h4.158a1 1 0 00.95-.69L9.05 2.927z"/></svg>
                @endfor
                @if($half)
                  <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.158c .969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3 .921-.755 1.688-1.54 1.118L10 13.347V2.927z"/></svg>
                @endif
              </div>

              <span class="text-sm text-gray-500">· {{ number_format($product->views ?? 0) }} dilihat</span>
            </div>

            <div class="text-right">
              <div class="text-xs text-gray-500">Kategori</div>
              <div class="text-sm font-medium">{{ optional($product->category)->name ?? '-' }}</div>
            </div>
          </div>

          {{-- Price --}}
          <div class="mt-4">
            <div class="text-sm text-gray-500">Harga</div>
            <div class="text-3xl font-extrabold text-rose-600 mt-1">Rp {{ number_format($product->price,0,',','.') }}</div>
            @if(isset($product->original_price) && $product->original_price > $product->price)
              <div class="text-sm text-gray-400 line-through mt-1">Rp {{ number_format($product->original_price,0,',','.') }}</div>
            @endif
          </div>

          {{-- Stock / badge --}}
          <div class="mt-4">
            @php $stock = $product->stock ?? null; @endphp
            @if(is_numeric($stock))
              @if($stock > 10)
                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">Stok tersedia: {{ $stock }}</span>
              @elseif($stock > 0)
                <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-sm">Hampir habis: {{ $stock }}</span>
              @else
                <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">Habis</span>
              @endif
            @endif
          </div>

          {{-- Add to cart form --}}
          <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="flex items-center gap-3">
              <div class="flex items-center border rounded">
                <button type="button" class="px-3 py-2 text-lg leading-none" id="qty-decrease" aria-label="Kurangi">−</button>
                <input id="qty-input" type="number" name="qty" value="1" min="1" class="w-16 text-center px-2 py-2 outline-none" />
                <button type="button" class="px-3 py-2 text-lg leading-none" id="qty-increase" aria-label="Tambah">+</button>
              </div>

              <button id="add-to-cart-btn" class="flex-1 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition" type="submit">
                Tambah ke Keranjang
              </button>
            </div>

            {{-- Wishlist / share --}}
            <div class="mt-4 flex items-center gap-2">
              <a href="#" class="text-sm px-3 py-2 border rounded hover:bg-gray-50">♥ Simpan</a>
              <div class="ml-auto flex items-center gap-2 text-gray-500">
                <a class="text-sm hover:text-blue-600" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" rel="noopener">Facebook</a>
                <span class="text-xs">•</span>
                <a class="text-sm hover:text-blue-500" href="https://twitter.com/intent/tweet?text={{ urlencode($product->name) }}&url={{ urlencode(Request::fullUrl()) }}" target="_blank" rel="noopener">Twitter</a>
              </div>
            </div>
          </form>
        </div>

        {{-- Quick links --}}
        
      </div>
    </aside>
  </div>
</div>

{{-- Small inline scripts for thumbnails & qty handling --}}
@push('scripts')
<script>
  // Thumbnail click -> change main image
  document.querySelectorAll('.thumbnail').forEach(btn => {
    btn.addEventListener('click', () => {
      const src = btn.getAttribute('data-src');
      const main = document.getElementById('main-product-image');
      if (main && src) main.src = src;
    });
  });

  // Quantity controls with simple stock-aware logic
  (function(){
    const decrease = document.getElementById('qty-decrease');
    const increase = document.getElementById('qty-increase');
    const input = document.getElementById('qty-input');
    const addBtn = document.getElementById('add-to-cart-btn');
    const stock = {{ is_numeric($product->stock) ? (int)$product->stock : 'null' }};

    function clampQty() {
      let v = parseInt(input.value) || 1;
      if (v < 1) v = 1;
      if (stock !== null) {
        if (v > stock) v = stock;
      }
      input.value = v;
      // disable add button if stock === 0
      if (stock === 0) {
        addBtn.disabled = true;
        addBtn.classList.add('opacity-60', 'cursor-not-allowed');
      } else {
        addBtn.disabled = false;
        addBtn.classList.remove('opacity-60', 'cursor-not-allowed');
      }
    }

    decrease?.addEventListener('click', () => {
      input.value = Math.max(1, (parseInt(input.value) || 1) - 1);
      clampQty();
    });

    increase?.addEventListener('click', () => {
      let next = (parseInt(input.value) || 1) + 1;
      if (stock !== null && next > stock) next = stock;
      input.value = next;
      clampQty();
    });

    input?.addEventListener('change', clampQty);
    // init
    clampQty();
  })();
</script>
@endpush

@endsection
