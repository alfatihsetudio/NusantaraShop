{{-- resources/views/admin/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<style>
/* Self-contained styling supaya tampil konsisten tanpa Tailwind */
.admin-wrap { min-height:78vh; display:flex; align-items:center; justify-content:center; background:#f3f4f6; padding:36px 18px; box-sizing:border-box; }
.admin-card { width:100%; max-width:980px; background:#fff; border-radius:12px; box-shadow:0 10px 30px rgba(2,6,23,0.06); display:flex; overflow:hidden; }
.admin-left { display:none; background:linear-gradient(180deg,#0f172a,#111827); color:#fff; width:45%; padding:36px; box-sizing:border-box; align-items:center; justify-content:center; flex-direction:column; }
@media(min-width:860px){ .admin-left { display:flex; } .admin-right { width:55%; } }
.admin-right { width:100%; padding:32px; box-sizing:border-box; }

.h-title { text-align:center; margin-bottom:8px; font-size:20px; font-weight:700; color:#0f172a; }
.h-sub { text-align:center; margin-bottom:18px; color:#475569; font-size:13px; }

.field { margin-bottom:12px; }
.field label { display:block; font-size:13px; color:#374151; margin-bottom:6px; }
.input { width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; box-sizing:border-box; font-size:14px; }
.input:focus { outline: none; box-shadow:0 0 0 6px rgba(79,70,229,0.06); border-color:#6366f1; }

.row { display:flex; gap:12px; align-items:center; }
.btn-primary { flex:1; background:#4f46e5; color:#fff; padding:10px 14px; border-radius:8px; border:none; cursor:pointer; font-weight:600; }
.btn-ghost { background:#fff; border:1px solid #e6e6e6; color:#374151; padding:10px 12px; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
.note { font-size:12px; color:#6b7280; text-align:center; margin-top:12px; }
.error { background:#fff1f2; border:1px solid #fee2e2; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:12px; font-size:13px; }

.small-link { color:#4f46e5; text-decoration:none; }
.toggle-eye { background:transparent;border:none;cursor:pointer;padding:6px; }
.form-actions { margin-top:6px; display:flex; gap:12px; align-items:center; }
</style>

<div class="admin-wrap">
  <div class="admin-card" role="main" aria-labelledby="adminLoginTitle">

    {{-- Left panel (branding) --}}
    <div class="admin-left" aria-hidden="true">
      <div style="width:120px;height:120px;border-radius:16px;background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center">
        <!-- small svg -->
        <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="6" y="10" width="52" height="40" rx="6" stroke="rgba(255,255,255,0.18)" stroke-width="2"/>
          <path d="M16 34h32" stroke="rgba(255,255,255,0.18)" stroke-width="2" stroke-linecap="round"/>
          <circle cx="20" cy="22" r="3" fill="rgba(255,255,255,0.9)"/>
          <circle cx="28" cy="22" r="3" fill="rgba(255,255,255,0.9)"/>
          <circle cx="36" cy="22" r="3" fill="rgba(255,255,255,0.9)"/>
        </svg>
      </div>

      <div style="text-align:center;margin-top:14px;">
        <h3 style="margin:0;font-weight:700;font-size:18px;">Admin Panel</h3>
        <p style="margin:10px 0 0;color:rgba(255,255,255,0.85);font-size:13px;max-width:220px">Kelola produk, pesanan, dan pengguna dari sini. Hanya administrator yang boleh mengakses.</p>
      </div>
    </div>

    {{-- Right panel: form --}}
    <div class="admin-right">
      <div style="max-width:480px;margin:0 auto;">
        <div id="adminLoginTitle" class="h-title">Admin Login</div>
        <div class="h-sub">Masuk menggunakan akun administrator</div>

        {{-- errors --}}
        @if ($errors->any())
          <div class="error" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin:6px 0 0 18px;">
              @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (session('error'))
          <div class="error" role="alert">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off" novalidate>
          @csrf

          <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="input" placeholder="name@domain.com" />
          </div>

          <div class="field" style="position:relative;">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required class="input" placeholder="Masukkan password" />
            <button type="button" id="togglePassword" class="toggle-eye" aria-label="Tampilkan password" style="position:absolute;right:8px;top:34px;">
              <!-- simple eye -->
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke="#6b7280" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="#6b7280" stroke-width="1.2" /></svg>
            </button>
          </div>

          <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;margin-bottom:10px;">
            <label style="display:flex;align-items:center;gap:8px;color:#374151;font-size:13px;">
              <input type="checkbox" name="remember" style="width:16px;height:16px;border-radius:4px;">
              <span>Ingat saya</span>
            </label>

            <a href="{{ route('home') }}" class="small-link" style="font-size:13px;">← Kembali ke toko</a>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-primary">Login</button>
            <a href="{{ route('home') }}" class="btn-ghost">Batal</a>
          </div>

          <div class="note">Catatan: Link login biasa di header hanya untuk pengguna (user). Admin harus masuk lewat <code style="background:#f3f4f6;padding:2px 6px;border-radius:4px">/admin_login</code>.</div>
        </form>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script>
  // toggle password
  document.addEventListener('DOMContentLoaded', function () {
    var pw = document.getElementById('password');
    var btn = document.getElementById('togglePassword');
    if (!pw || !btn) return;
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      pw.type = pw.type === 'password' ? 'text' : 'password';
    });
  });
</script>
@endpush

@endsection
