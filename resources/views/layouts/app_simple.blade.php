<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>@yield('title', config('app.name'))</title>

  <link rel="stylesheet" href="{{ asset('css/simple.css') }}">
  @stack('head')
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">
        <a href="{{ url('/') }}" class="brand-link">{{ config('app.name','Laravel') }}</a>
        <span class="brand-sub">Toko</span>
      </div>
      <nav class="header-right">
        <a href="{{ route('cart.index') }}">Keranjang <span class="badge">0</span></a>
      </nav>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="site-footer">
    <div class="container">
      &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
    </div>
  </footer>

  @stack('scripts')
</body>
</html>
