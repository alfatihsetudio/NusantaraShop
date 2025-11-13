{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="site-header" style="background:#fff;border-bottom:1px solid #e6e6e6;">
  <div class="container" style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;">
    <div class="left" style="display:flex;align-items:center;gap:14px;">
      <a href="{{ route('home') }}" class="brand-link" style="display:flex;align-items:center;gap:8px;text-decoration:none;color:inherit;">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="height:28px;object-fit:contain;">
        <span style="font-weight:700;">{{ config('app.name', 'NusantaraShop') }}</span>
      </a>

      {{-- primary nav links (optional) --}}
      <div class="nav-links" style="margin-left:18px;">
        <a href="{{ route('home') }}" style="margin-right:12px;">Home</a>
        <a href="{{ route('home') }}#produk" style="margin-right:12px;">Produk</a>
        <a href="{{ route('home') }}#kontak">Kontak</a>
      </div>
    </div>

    <div class="right" style="display:flex;align-items:center;gap:12px;">
      @guest
        {{-- Guest: hanya tombol Login, TIDAK ada Register --}}
        <a href="{{ route('login') }}" class="btn" style="padding:8px 12px;border-radius:8px;border:1px solid #ddd;background:#fff;">Login</a>

        {{-- keranjang untuk guest: tampil tapi disable/arahkan ke login --}}
        <a href="{{ route('login') }}" title="Masuk untuk mengakses keranjang" class="btn-cart" style="padding:8px 12px;border-radius:8px;border:1px solid #e6e6e6;background:#fafafa;color:#6b7280;text-decoration:none;">
          Keranjang
        </a>
      @else
        {{-- Authenticated --}}
        @if(auth()->user()->is_admin ?? false)
          {{-- Admin session: TIDAK tampilkan tombol keranjang, tampilkan link dashboard/admin --}}
          <a href="{{ route('dashboard') }}" class="btn" style="padding:8px 12px;border-radius:8px;background:#111827;color:#fff;text-decoration:none;">Dashboard</a>
        @else
          {{-- Normal user: tampilkan keranjang yang berfungsi --}}
          <a href="{{ route('cart.index') }}" class="btn" style="padding:8px 12px;border-radius:8px;border:1px solid #e6e6e6;background:#fff;color:inherit;text-decoration:none;">
            Keranjang
            {{-- optional: tampilkan jumlah item --}}
            @php $cart = session()->get('cart', []); $count = array_sum(array_column($cart ?: [], 'qty')) ?? 0; @endphp
            @if($count > 0) <span style="margin-left:8px;color:#ef4444;">({{ $count }})</span> @endif
          </a>
        @endif

        {{-- common user/admin actions: profil & logout --}}
        <div style="display:inline-flex;align-items:center;gap:8px;">
          <a href="{{ route('profile.edit') }}" style="text-decoration:none;color:inherit;">Profil</a>

          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="padding:6px 10px;border-radius:8px;border:1px solid #ddd;background:#fff;">Logout</button>
          </form>
        </div>
      @endguest
    </div>
  </div>
</nav>
