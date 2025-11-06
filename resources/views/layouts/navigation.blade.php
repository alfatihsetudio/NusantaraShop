<nav class="bg-white shadow">
  <div class="container mx-auto px-4 py-3 flex items-center justify-between">
    <div class="flex items-center gap-4">
      <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">{{ config('app.name', 'NusantaraShop') }}</a>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('cart.index') }}" class="px-3 py-2 rounded hover:bg-gray-100 flex items-center gap-2">
        Keranjang
        <span class="ml-1 inline-block bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
          {{ is_array(session('cart')) ? count(session('cart')) : 0 }}
        </span>
      </a>

      @if (Route::has('login'))
        @auth
          <div class="flex items-center gap-2">
            {{-- Aman: gunakan optional() atau null-safe operator untuk menghindari error --}}
            <span class="text-sm text-gray-700 hidden sm:inline">
              {{ optional(auth()->user())->name ?? optional(auth()->user())->email ?? 'User' }}
            </span>

            <form method="POST" action="{{ route('logout') }}" class="inline">
              @csrf
              <button type="submit" class="px-3 py-2 rounded bg-red-500 text-white text-sm">Logout</button>
            </form>
          </div>
        @else
          <div class="flex items-center gap-2">
            @if (Route::has('login'))
              <a href="{{ route('login') }}" class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Login</a>
            @endif

            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="px-3 py-2 rounded border border-gray-200 text-sm hover:bg-gray-100">Register</a>
            @endif
          </div>
        @endauth
      @endif
    </div>
  </div>
</nav>
