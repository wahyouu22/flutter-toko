<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login.login', [
            'judul' => 'Login',
        ]);
    }

    public function authenticateBackend(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Autentikasi menggunakan guard 'user' karena admin berada di tabel users
        if (Auth::guard('user')->attempt($credentials)) {
            $user = Auth::guard('user')->user();

            if ($user->status == 0) {
                Auth::guard('user')->logout();
                return back()->with('error', 'User belum aktif');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('backend.beranda'));
        }

        return back()->with('error', 'Login Gagal');
    }

    public function logoutBackend()
    {
        Auth::guard('user')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('backend.login'));
    }
}
