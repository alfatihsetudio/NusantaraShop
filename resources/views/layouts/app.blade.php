<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale() ?? 'en') }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
    {{ config('app.name', 'NusantaraShop') }}
    @hasSection('title') - @yield('title') @endif
  </title>

  <meta name="description" content="@yield('meta_description', 'Toko online NusantaraShop')" />

  @php $vite_manifest = public_path('build/manifest.json'); @endphp

  @if (file_exists($vite_manifest))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    <link rel="stylesheet" href="{{ asset('css/simple.css') }}">
  @endif

  @stack('styles')

  <style>
    /* --- Base layout / modern minimal styles --- */
    :root{
      --bg: #f7f7f9;
      --card:#ffffff;
      --muted:#6b7280;
      --primary:#1f2937;
      --accent:#f53003;
      --border:#e6e6e6;
      --radius:10px;
      --container-max:1100px;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background:var(--bg);
      color:var(--primary);
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      line-height:1.45;
    }

    /* container helper */
    .container{
      max-width:var(--container-max);
      margin:0 auto;
      padding:0 16px;
    }

    /* Header */
    .topbar{
      background:var(--card);
      border-bottom:1px solid var(--border);
      position:sticky;
      top:0;
      z-index:50;
      backdrop-filter:saturate(120%) blur(4px);
    }
    .topbar-inner{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      padding:14px 0;
    }
    .brand{
      display:flex;
      gap:10px;
      align-items:center;
      text-decoration:none;
      color:var(--primary);
    }
    .brand img{height:28px;width:auto;display:block}
    .brand .name{font-weight:700;font-size:1.05rem}

    /* nav center */
    .nav {
      display:flex;
      gap:18px;
      align-items:center;
      justify-content:center;
      flex:1;
    }
    .nav a{
      color:var(--primary);
      text-decoration:none;
      font-weight:600;
      padding:8px 10px;
      border-radius:8px;
    }
    .nav a:hover{background:#f3f4f6}

    /* actions right */
    .actions{display:flex;gap:10px;align-items:center}
    .btn{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 12px;
      border-radius:8px;
      font-weight:600;
      text-decoration:none;
      border:1px solid transparent;
      cursor:pointer;
    }
    .btn-primary{background:var(--accent);color:#fff;border-color:var(--accent)}
    .btn-outline{background:transparent;color:var(--primary);border:1px solid var(--border)}
    .icon-btn{background:#fff;border:1px solid var(--border);padding:8px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center}

    .cart-badge{display:inline-flex;align-items:center;gap:8px}
    .cart-count{display:inline-block;background:#ef4444;color:white;border-radius:999px;padding:2px 7px;font-size:12px;margin-left:6px}

    /* user dropdown (simple) */
    .user-menu{position:relative}
    .user-menu .menu{
      position:absolute;
      right:0;
      top:calc(100% + 10px);
      background:var(--card);
      border:1px solid var(--border);
      box-shadow:0 8px 24px rgba(17,24,39,0.06);
      border-radius:8px;
      min-width:180px;
      display:none;
      overflow:hidden;
    }
    .user-menu.open .menu{display:block}
    .menu a{display:block;padding:10px 12px;color:var(--primary);text-decoration:none}
    .menu a:hover{background:#f8fafc}

    /* main and footer */
    main{padding:28px 0}
    footer{background:var(--card);border-top:1px solid var(--border);padding:18px 0;color:var(--muted)}

    /* small responsive */
    .mobile-toggle{display:none}
    @media (max-width:900px){
      .nav{display:none}
      .mobile-toggle{display:inline-flex}
      .topbar-inner{gap:8px}
    }

    /* flash messages */
    .flash{margin-top:12px;border-radius:8px;padding:10px 12px}
    .flash-success{background:#ecfdf5;border:1px solid #bbf7d0;color:#065f46}
    .flash-error{background:#fff1f2;border:1px solid #fecaca;color:#991b1b}
    .flash-warn{background:#fffbeb;border:1px solid #fef3c7;color:#92400e}
  </style>
</head>
<body>

  {{-- topbar --}}
  <header class="topbar">
    <div class="container">
      <div class="topbar-inner">
        {{-- LEFT: brand --}}
        <a href="{{ route('home') }}" class="brand" aria-label="{{ config('app.name') }}">
          <img src="{{ asset('images/logo.png') }}" alt="" onerror="this.style.display='none'">
          <span class="name">{{ config('app.name', 'NusantaraShop') }}</span>
        </a>

        {{-- CENTER: navigation --}}
        <nav class="nav" role="navigation" aria-label="Main navigation">
          <a href="{{ route('home') }}">Home</a>
          <a href="{{ route('home') }}#produk">Produk</a>
          <a href="{{ route('home') }}#tentang">Tentang</a>
          <a href="{{ route('home') }}#kontak">Kontak</a>
        </nav>

        {{-- RIGHT: actions --}}
        <div class="actions" role="region" aria-label="User actions">

          {{-- mobile menu toggle --}}
          <button class="mobile-toggle icon-btn" aria-expanded="false" aria-controls="mobileMenu" id="mobileToggle" title="Menu">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
              <path d="M4 6h16M4 12h16M4 18h16" stroke="#111827" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </button>

          {{-- CART logic simplified:
               - Guest: cart icon links to login (so tamu tahu harus login)
               - Authenticated user: link aktif ke cart.index
          --}}
          @auth
            <a href="{{ route('cart.index') }}" class="icon-btn" title="Keranjang">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M3 3h2l.4 2M7 13h10l3-8H6.4" stroke="#111827" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="10" cy="20" r="1" fill="#111827"/>
                <circle cx="18" cy="20" r="1" fill="#111827"/>
              </svg>
              <span class="cart-count" id="cartCount">{{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>
          @else
            <a href="{{ route('login') }}" class="icon-btn" title="Keranjang (login dulu)">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M3 3h2l.4 2M7 13h10l3-8H6.4" stroke="#9ca3af" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="10" cy="20" r="1" fill="#9ca3af"/>
                <circle cx="18" cy="20" r="1" fill="#9ca3af"/>
              </svg>
              <span style="font-size:12px;color:var(--muted);margin-left:8px">Masuk untuk beli</span>
            </a>
          @endauth

          {{-- Auth / Guest actions: show Login + Register only for guests --}}
          @guest
            <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endif
          @else
            <div class="user-menu" id="userMenu">
              <button id="userToggle" class="btn btn-outline" aria-expanded="false" aria-controls="userOptions">
                {{ Str::limit(auth()->user()->name, 18) }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="margin-left:6px">
                  <path d="M6 9l6 6 6-6" stroke="#111827" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>

              <div class="menu" id="userOptions" role="menu" aria-hidden="true">
                <a href="{{ route('profile.edit') }}">Profil</a>
                <a href="{{ route('cart.index') }}">Keranjang</a>
                <a href="{{ route('home') }}">Lihat Toko</a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" style="width:100%;text-align:left;padding:10px 12px;border:none;background:transparent;color:inherit;cursor:pointer;">Keluar</button>
                </form>
              </div>
            </div>
          @endguest

        </div>
      </div>

      {{-- mobile menu (hidden desktop) --}}
      <div id="mobileMenu" style="display:none;margin-top:8px;">
        <nav style="display:flex;flex-direction:column;gap:6px;padding-bottom:8px;">
          <a href="{{ route('home') }}" style="padding:10px;border-radius:8px;background:#fff">Home</a>
          <a href="{{ route('home') }}#produk" style="padding:10px;border-radius:8px;background:#fff">Produk</a>
          <a href="{{ route('home') }}#tentang" style="padding:10px;border-radius:8px;background:#fff">Tentang</a>
          <a href="{{ route('home') }}#kontak" style="padding:10px;border-radius:8px;background:#fff">Kontak</a>

          @guest
            <a href="{{ route('login') }}" style="padding:10px;border-radius:8px;background:#fff">Login</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" style="padding:10px;border-radius:8px;background:var(--accent);color:#fff">Register</a>
            @endif
          @else
            <a href="{{ route('profile.edit') }}" style="padding:10px;border-radius:8px;background:#fff">Profil</a>
            <a href="{{ route('cart.index') }}" style="padding:10px;border-radius:8px;background:#fff">Keranjang</a>
            <form method="POST" action="{{ route('logout') }}" style="padding:10px 0;">
              @csrf
              <button type="submit" style="width:100%;padding:10px;border-radius:8px;background:#fff;border:1px solid var(--border)">Keluar</button>
            </form>
          @endguest
        </nav>
      </div>
    </div>
  </header>

  {{-- Flash messages --}}
  <div class="container">
    @if (session('success'))
      <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="flash flash-error">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="flash flash-warn">
        <strong>Terdapat kesalahan:</strong>
        <ul style="margin-top:6px;margin-left:18px;">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Main content --}}
  <main id="main-content" class="container">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer>
    <div class="container" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
      <div style="display:flex;gap:12px;align-items:center;">
        <small style="color:var(--muted)">&copy; {{ date('Y') }} {{ config('app.name', 'NusantaraShop') }}</small>
      </div>

      <div style="display:flex;gap:10px;align-items:center;">
        <a href="{{ route('home') }}" style="color:var(--muted);text-decoration:underline">Home</a>
        <a href="{{ route('home') }}#produk" style="color:var(--muted);text-decoration:underline">Produk</a>
        <a href="{{ route('home') }}#kontak" style="color:var(--muted);text-decoration:underline">Kontak</a>
      </div>
    </div>
  </footer>

  {{-- expose CSRF token --}}
  <script>
    window.Laravel = window.Laravel || {};
    window.Laravel.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
  </script>

  {{-- small JS for toggles --}}
  <script>
    (function(){
      // mobile toggle
      const mobileToggle = document.getElementById('mobileToggle');
      const mobileMenu = document.getElementById('mobileMenu');
      if(mobileToggle && mobileMenu){
        mobileToggle.addEventListener('click', function(){
          const expanded = this.getAttribute('aria-expanded') === 'true';
          this.setAttribute('aria-expanded', String(!expanded));
          mobileMenu.style.display = mobileMenu.style.display === 'none' || mobileMenu.style.display === '' ? 'block' : 'none';
        });
      }

      // user menu toggle
      const userToggle = document.getElementById('userToggle');
      const userMenuWrap = document.getElementById('userMenu');
      if(userToggle && userMenuWrap){
        userToggle.addEventListener('click', function(e){
          e.preventDefault();
          userMenuWrap.classList.toggle('open');
        });
        // close on outside click
        document.addEventListener('click', function(e){
          if(!userMenuWrap.contains(e.target)) userMenuWrap.classList.remove('open');
        });
      }
    })();
  </script>

  @if (!file_exists($vite_manifest) && file_exists(public_path('js/app.js')))
    <script src="{{ asset('js/app.js') }}"></script>
  @endif

  @stack('scripts')
</body>
</html>
