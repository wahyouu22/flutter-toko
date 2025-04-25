<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    /**
     * Menampilkan form login untuk customer
     */
    public function showLoginForm()
    {
        return view('auth.customer_login');
    }

    /**
     * Proses login customer
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // Cari user dengan email
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Periksa peran berdasarkan nilai role
            if ($user->role == 2) { // Peran customer (role == 2)
                auth()->login($user);  // Login user
                return redirect()->route('customer.dashboard');  // Redirect ke halaman dashboard customer
            } else {
                return back()->withErrors(['email' => 'Email atau password salah, atau Anda bukan customer.']);
            }
        } else {
            return back()->withErrors(['email' => 'Email atau password salah, atau Anda bukan customer.']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
    /**
     * Halaman dashboard customer setelah login
     */
    public function dashboard()
    {
        return view('customer.dashboard');
    }
}
