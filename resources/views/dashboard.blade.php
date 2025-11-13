{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@php
// Safety extra: jika seseorang berhasil melewati middleware tapi bukan admin,
// hentikan rendering dan kembalikan 403. Middleware tetap prioritas.
if (!(auth()->check() && (auth()->user()->is_admin ?? false))) {
    abort(403);
}
@endphp

@section('content')
<div class="dashboard-wrap">
  <header class="dash-header">
    <div>
      <h1 class="dash-title">Admin Dashboard</h1>
      <p class="dash-sub">Ringkasan singkat toko — hanya untuk akun administrator.</p>
    </div>

    <div class="dash-actions">
      <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Kelola Produk</a>
      <a href="{{ route('admin.products.create') }}" class="btn btn-outline">Tambah Produk</a>
    </div>
  </header>

  <section class="metrics">
    <article class="card">
      <div class="card-label">Total Produk</div>
      <div class="card-value">{{ $productCount ?? 0 }}</div>
    </article>

    <article class="card">
      <div class="card-label">Total Pesanan</div>
      <div class="card-value">{{ $orderCount ?? 0 }}</div>
    </article>

    <article class="card">
      <div class="card-label">Pengguna Terdaftar</div>
      <div class="card-value">{{ $userCount ?? 0 }}</div>
    </article>
  </section>

  <section class="quick">
    <h2 class="section-heading">Tindakan Cepat</h2>
    <div class="quick-grid">
      <a href="{{ route('admin.products.index') }}" class="quick-card">
        <div class="qc-title">Kelola Produk</div>
        <div class="qc-sub">Lihat, sunting, atau hapus produk</div>
      </a>

      <a href="{{ route('admin.products.create') }}" class="quick-card">
        <div class="qc-title">Tambah Produk</div>
        <div class="qc-sub">Tambah produk baru ke katalog</div>
      </a>

      <a href="{{ route('cart.index') }}" class="quick-card muted">
        <div class="qc-title">Lihat Keranjang</div>
        <div class="qc-sub">Akses keranjang pengguna (opsional)</div>
      </a>

      <a href="{{ route('home') }}" class="quick-card muted">
        <div class="qc-title">Lihat Toko</div>
        <div class="qc-sub">Buka tampilan publik toko</div>
      </a>
    </div>
  </section>

  <section class="panel">
    <h2 class="section-heading">Ringkasan Terbaru</h2>

    {{-- Jika controller mengirim recent arrays, tampilkan; jika tidak, tampilkan placeholder --}}
    @if(isset($recentProducts) && count($recentProducts))
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Stok</th>
              <th>Harga</th>
              <th>Di tambah</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recentProducts as $p)
              <tr>
                <td><a href="{{ route('admin.products.edit', $p->id) }}">{{ $p->name }}</a></td>
                <td>{{ $p->stock ?? '-' }}</td>
                <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                <td>{{ $p->created_at ? $p->created_at->format('Y-m-d') : '-' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="muted-note">Belum ada data produk terbaru untuk ditampilkan. Gunakan tombol "Tambah Produk" untuk mulai menambahkan katalog.</p>
    @endif
  </section>

  <footer class="dash-footer">
    <small>Catatan: Halaman ini hanya menampilkan ringkasan — gunakan menu <strong>Kelola Produk</strong> untuk operasi CRUD lengkap.</small>
  </footer>
</div>
@endsection

@push('styles')
<style>
/* Reset kecil agar tampil konsisten */
.dashboard-wrap { max-width:1100px; margin:0 auto; padding:28px 18px; font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color:#111827; }
.dash-header { display:flex; align-items:center; justify-content:space-between; gap:18px; margin-bottom:22px; }
.dash-title { font-size:1.6rem; margin:0 0 4px 0; font-weight:700; letter-spacing:-0.02em; }
.dash-sub { margin:0; color:#6b7280; font-size:0.95rem; }

/* Buttons */
.dash-actions { display:flex; gap:10px; align-items:center; }
.btn { display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; text-decoration:none; font-weight:600; border:1px solid transparent; }
.btn-primary { background:#111827; color:#fff; border-color:#111827; }
.btn-outline { background:#fff; color:#111827; border-color:#e5e7eb; box-shadow:0 1px 0 rgba(0,0,0,0.02); }

/* Metrics */
.metrics { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
.card { background:#fff; padding:18px; border-radius:12px; box-shadow:0 6px 18px rgba(17,24,39,0.04); display:flex; flex-direction:column; }
.card-label { color:#6b7280; font-size:0.9rem; }
.card-value { margin-top:8px; font-size:1.75rem; font-weight:700; color:#111827; }

/* Quick actions */
.section-heading { font-size:1.05rem; margin:0 0 12px 0; font-weight:700; color:#111827; }
.quick { margin-bottom:18px; }
.quick-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; }
.quick-card { display:block; background:#fff; padding:14px; border-radius:10px; text-decoration:none; color:inherit; box-shadow:0 6px 18px rgba(17,24,39,0.03); border:1px solid #f3f4f6; transition:transform .12s ease,box-shadow .12s ease; }
.quick-card:hover { transform:translateY(-4px); box-shadow:0 12px 28px rgba(17,24,39,0.06); }
.quick-card .qc-title { font-weight:700; margin-bottom:6px; }
.quick-card .qc-sub { color:#6b7280; font-size:0.9rem; }
.quick-card.muted { opacity:0.85; }

/* Table */
.panel { margin-bottom:20px; }
.table-wrap { overflow:auto; border-radius:8px; box-shadow:0 6px 18px rgba(17,24,39,0.03); }
.table { width:100%; border-collapse:collapse; background:#fff; }
.table thead th { text-align:left; padding:12px 16px; background:#fbfbfb; color:#374151; font-weight:600; font-size:0.95rem; border-bottom:1px solid #f3f4f6; }
.table tbody td { padding:12px 16px; border-bottom:1px solid #f8f8f8; color:#111827; font-size:0.95rem; }
.table tbody tr:hover { background:#fcfcfd; }

/* Footer note */
.dash-footer { margin-top:18px; padding-top:12px; border-top:1px solid #f3f4f6; color:#6b7280; font-size:0.9rem; }

/* Responsive */
@media (max-width: 900px) {
  .metrics { grid-template-columns:repeat(2,1fr); }
  .quick-grid { grid-template-columns:repeat(2,1fr); }
}
@media (max-width: 560px) {
  .dash-header { flex-direction:column; align-items:flex-start; gap:12px; }
  .metrics { grid-template-columns:1fr; }
  .quick-grid { grid-template-columns:1fr; }
}
</style>
@endpush

@push('scripts')
<script>
  // Tidak ada JS kompleks di dashboard — script ini untuk hooks kecil jika perlu
  document.addEventListener('DOMContentLoaded', function () {
    // placeholder untuk behavior interaktif jika dibutuhkan di masa depan
  });
</script>
@endpush
