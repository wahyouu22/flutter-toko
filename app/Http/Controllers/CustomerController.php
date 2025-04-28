<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari customer berdasarkan google_id atau email
            $customer = Customer::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            // Jika customer tidak ditemukan, buat customer baru
            if (!$customer) {
                // Buat user terlebih dahulu
                $user = User::create([
                    'nama' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'role' => 2,
                    'status' => 1,
                    'hp' => null,
                    'foto' => $googleUser->avatar,
                ]);

                // Buat customer terkait dengan user
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'hp' => null,
                    'alamat' => null,
                    'pos' => null,
                    'foto' => $googleUser->avatar,
                    'password' => bcrypt('rhyru9'),
                ]);
            } else {
                // Update data customer jika sudah ada
                $customer->google_id = $googleUser->id;
                $customer->google_token = $googleUser->token;
                $customer->foto = $googleUser->avatar;
                $customer->save();

                // Update user terkait jika ada
                if ($customer->user) {
                    $customer->user->update([
                        'nama' => $googleUser->name,
                        'foto' => $googleUser->avatar,
                    ]);
                }

                // Jika customer belum memiliki password, beri password default
                if (!$customer->password) {
                    $customer->password = bcrypt('rhyru9');
                    $customer->save();
                }
            }

            // Login menggunakan data customer
            Auth::login($customer);

            return redirect()->route('beranda');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat login dengan Google: ' . $e->getMessage());
        }
    }

    public function edit()
    {
        $customer = auth()->user();
        $createdAt = $customer->created_at;
        $currentTime = now();
        $timeDifference = $currentTime->diffInHours($createdAt);

        $showPasswordReminder = false;
        if ($timeDifference <= 24) {
            $showPasswordReminder = true;
        }

        return view('customer.account', compact('customer', 'showPasswordReminder'));
    }

    public function update(Request $request)
    {
        $customer = auth()->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'foto' => 'nullable|mimes:jpg,jpeg,png,ico,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $mimeType = $file->getMimeType();
            $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/x-icon'];

            if (!in_array($mimeType, $validMimeTypes)) {
                return redirect()->route('account.edit')->with('error', 'Hanya file gambar yang diperbolehkan (JPG, JPEG, PNG, ICO, GIF).');
            }

            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (substr_count($originalName, '.') > 1) {
                return redirect()->route('account.edit')->with('error', 'Nama file tidak valid.');
            }

            if ($customer->foto && Storage::disk('public')->exists($customer->foto)) {
                Storage::disk('public')->delete($customer->foto);
            }

            $fileName = Str::uuid() . '.' . $extension;
            $path = $file->storeAs('foto_customer', $fileName, 'public');
            $customer->foto = $path;

            // Update foto di user terkait jika ada
            if ($customer->user) {
                $customer->user->update(['foto' => $path]);
            }
        }

        if ($request->filled('name')) {
            $customer->name = $request->name;
            // Update nama di user terkait jika ada
            if ($customer->user) {
                $customer->user->update(['nama' => $request->name]);
            }
        }

        $customer->hp = $request->hp;
        $customer->alamat = $request->alamat;
        $customer->pos = $request->kode_pos;

        $timeDifference = now()->diffInHours($customer->created_at);
        if ($timeDifference <= 24 && $request->filled('password')) {
            $customer->password = bcrypt($request->password);
            // Update password di user terkait jika ada
            if ($customer->user) {
                $customer->user->update(['password' => bcrypt($request->password)]);
            }
        }

        $customer->save();

        return redirect()->route('account.edit')->with('success', 'Data berhasil diperbarui.');
    }

    public function deleteFoto()
    {
        $customer = auth()->user();

        if ($customer->foto && Storage::disk('public')->exists($customer->foto)) {
            Storage::disk('public')->delete($customer->foto);
        }

        $customer->foto = null;
        $customer->save();

        // Hapus foto di user terkait jika ada
        if ($customer->user) {
            $customer->user->update(['foto' => null]);
        }

        return redirect()->route('account.edit')->with('success', 'Foto berhasil dihapus.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }

    public function showLoginForm()
    {
        return view('customer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('beranda')->with('success', 'Selamat datang!');
        }

        return back()->with('error', 'Email atau password salah.');
    }
}
