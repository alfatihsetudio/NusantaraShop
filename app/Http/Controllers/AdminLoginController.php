<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // tampilkan form login admin
    public function showLoginForm()
    {
        return view('admin.login'); // resources/views/admin/login.blade.php
    }

    // proses login admin
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // cek flag is_admin (jika tidak ada field ini, akan dianggap false)
            if (! ($user->is_admin ?? false) ) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan akun admin.'])->withInput();
            }

            // set session tambahan (opsional)
            session(['admin_logged_in' => true, 'admin_id' => $user->id]);

            // sukses — redirect ke admin dashboard
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // proses logout admin
    public function logout(Request $request)
    {
        // logout menggunakan Auth facade
        Auth::logout();

        // invalidate session dan regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah logout dari area admin.');
    }
}
