{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', config('app.name', 'NusantaraShop'))

@section('content')
<div class="home-container">
  <header class="header">
    <h1 class="title">Selamat Datang di <span class="brand">{{ config('app.name', 'NusantaraShop') }}</span></h1>
    <p class="subtitle">
      Belanja produk terbaik dari seluruh Nusantara dengan mudah dan cepat.
    </p>

    <div class="button-group">
      {{-- Tombol khusus untuk user --}}
      <a href="{{ route('login') }}" class="btn btn-primary">Login User</a>
      <a href="{{ route('register') }}" class="btn btn-outline">Register</a>
    </div>

    <p class="note">
      Admin memiliki halaman login sendiri di 
      <code>/admin_login</code>
    </p>
  </header>

  <section class="content">
    <div class="left-panel">
      <h2 class="section-title">Tentang Laravel (Dari file welcome.blade.php)</h2>
      <p class="section-text">
        Laravel memiliki ekosistem yang sangat kaya dan kuat. Kami sarankan untuk memulai dari dokumentasi resminya dan memanfaatkan tutorial video di Laracasts.
      </p>

      <ul class="list">
        <li>
          📘 <a href="https://laravel.com/docs" target="_blank">Baca Dokumentasi Laravel</a>
        </li>
        <li>
          🎬 <a href="https://laracasts.com" target="_blank">Tonton Tutorial Laracasts</a>
        </li>
        <li>
          ☁️ <a href="https://cloud.laravel.com" target="_blank">Deploy ke Laravel Cloud</a>
        </li>
      </ul>
    </div>

    <div class="right-panel">
      {{-- SVG Laravel Logo bawaan --}}
      <svg viewBox="0 0 438 104" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo">
        <path d="M17.2036 -3H0V102.197H49.5189V86.7187H17.2036V-3Z" fill="#F53003" />
        <path d="M110.256 41.6337C108.061 38.1275 104.945 35.3731 100.905 33.3681C96.8667 31.3647 92.8016 30.3618 88.7131 30.3618C83.4247 30.3618 78.5885 31.3389 74.201 33.2923C69.8111 35.2456 66.0474 37.928 62.9059 41.3333C59.7643 44.7401 57.3198 48.6726 55.5754 53.1293C53.8287 57.589 52.9572 62.274 52.9572 67.1813C52.9572 72.1925 53.8287 76.8995 55.5754 81.3069C57.3191 85.7173 59.7636 89.6241 62.9059 93.0293C66.0474 96.4361 69.8119 99.1155 74.201 101.069C78.5885 103.022 83.4247 103.999 88.7131 103.999C92.8016 103.999 96.8667 102.997 100.905 100.994C104.945 98.9911 108.061 96.2359 110.256 92.7282V102.195H126.563V32.1642H110.256V41.6337Z" fill="#F53003" />
        <path d="M438 -3H421.694V102.197H438V-3Z" fill="#F53003" />
      </svg>
    </div>
  </section>
</div>

@push('styles')
<style>
.home-container {
  min-height: 90vh;
  background: #fdfdfc;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  font-family: 'Instrument Sans', sans-serif;
  color: #1b1b18;
  padding: 40px 20px;
}

.header {
  text-align: center;
  margin-bottom: 40px;
}
.title {
  font-size: 2rem;
  font-weight: 600;
  margin-bottom: 10px;
}
.brand {
  color: #f53003;
}
.subtitle {
  color: #706f6c;
  font-size: 1rem;
  margin-bottom: 20px;
}
.button-group {
  display: flex;
  justify-content: center;
  gap: 16px;
  margin-bottom: 12px;
}
.btn {
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
}
.btn-primary {
  background: #f53003;
  color: #fff;
  border: 1px solid #f53003;
}
.btn-outline {
  background: #fff;
  color: #1b1b18;
  border: 1px solid #d1d5db;
}
.btn-primary:hover {
  filter: brightness(0.9);
}
.btn-outline:hover {
  background: #f9fafb;
}
.note {
  color: #9ca3af;
  font-size: 0.9rem;
}

.content {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: stretch;
  gap: 20px;
  max-width: 960px;
  width: 100%;
}

.left-panel,
.right-panel {
  background: #fff;
  border-radius: 12px;
  padding: 24px;
  flex: 1;
  box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.section-title {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 12px;
}
.section-text {
  font-size: 0.95rem;
  color: #555;
  margin-bottom: 16px;
}
.list {
  list-style: none;
  padding: 0;
}
.list li {
  margin-bottom: 10px;
  font-size: 0.95rem;
}
.list a {
  color: #f53003;
  font-weight: 500;
  text-decoration: none;
}
.list a:hover {
  text-decoration: underline;
}

.logo {
  max-width: 320px;
  width: 100%;
  margin: 0 auto;
  display: block;
}

@media (max-width: 768px) {
  .content {
    flex-direction: column;
  }
}
</style>
@endpush
@endsection
