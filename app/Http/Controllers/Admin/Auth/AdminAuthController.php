<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // tampilkan form (opsional, kita pakai closure route di atas)
    public function showLogin() {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // coba autentikasi menggunakan guard default (web).
        // Jika Anda memakai kolom is_admin di users table:
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $request->boolean('remember'))) {
            $user = Auth::user();
            // cek apakah user adalah admin (asumsi ada kolom is_admin boolean)
            if (method_exists($user, 'is_admin') || isset($user->is_admin)) {
                if (! ($user->is_admin ?? false) ) {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
                }
            }
            // redirect ke dashboard admin
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput($request->only('email'));
    }
}
