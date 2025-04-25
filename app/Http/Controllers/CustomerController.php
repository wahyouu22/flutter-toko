<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function callback()
    {
        try {
            // Ambil data user dari Google
            $socialUser = Socialite::driver('google')->user();

            // Cek apakah email sudah terdaftar
            $registeredUser = User::where('email', $socialUser->email)->first();

            if (!$registeredUser) {
                // Buat user baru
                $user = User::create([
                    'nama'     => $socialUser->name,
                    'email'    => $socialUser->email,
                    'role'     => '2', // Role customer
                    'status'   => 1,   // Status aktif
                    'password' => Hash::make('default_password'), // Password default
                    // Tambahkan kolom lainnya jika diperlukan
                ]);

                // Debug: dump user yang baru dibuat
                dd($user);

                // Buat data customer
                $customer = Customer::create([
                    'user_id'      => $user->id,
                    'google_id'    => $socialUser->id,
                    'google_token' => $socialUser->token,
                    // Tambahkan kolom lain sesuai dengan kebutuhan
                    'hp'           => null, // Misalnya hp tidak ada dari Google
                    'alamat'       => null, // Misalnya alamat tidak ada dari Google
                    'pos'          => null, // Misalnya pos tidak ada dari Google
                    'foto'         => $socialUser->avatar, // Avatar dari Google
                ]);

                // Debug: dump customer yang baru dibuat
                //dd($customer);

                // Login pengguna baru
                Auth::login($user);
            } else {
                // Jika email sudah terdaftar, langsung login
                Auth::login($registeredUser);
            }

            // Redirect ke halaman utama
            return redirect()->route('customer.dashboard');
        } catch (\Exception $e) {
            // Debug: dump pesan error jika terjadi kesalahan
            dd($e->getMessage());

            return redirect('/')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerate token CSRF

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
