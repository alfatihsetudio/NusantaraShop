<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>{{ config('app.name', 'NusantaraShop') }}</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Vite assets --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

  {{-- navigation (include jika ada) --}}
  @includeIf('layouts.navigation')

  {{-- flash messages --}}
  <div class="container mx-auto px-4 mt-6">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-800 rounded">
        {{ session('error') }}
      </div>
    @endif
  </div>

  <main class="container mx-auto px-4 py-6">
    @yield('content')
  </main>

  <footer class="mt-12 py-6 bg-white border-t">
    <div class="container mx-auto px-4 text-center text-sm text-gray-500">
      &copy; {{ date('Y') }} {{ config('app.name', 'NusantaraShop') }}. All rights reserved.
    </div>
  </footer>

  <script>
    window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
  </script>

  @stack('scripts')
</body>
</html>
