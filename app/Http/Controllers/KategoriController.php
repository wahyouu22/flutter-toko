<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    // Constructor untuk memeriksa guard sebelum akses controller
    public function __construct()
    {
        // Pastikan hanya user yang menggunakan guard 'admin' yang bisa mengakses
        $this->middleware('auth:user');
    }

    public function index()
    {
        // Pastikan hanya user yang terautentikasi yang bisa melihat data
        if (Auth::guard('user')->check()) {
            $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
            return view('backend.v_kategori.index', [
                'judul' => 'Kategori',
                'index' => $kategori
            ]);
        }

        return redirect()->route('backend.login')->with('error', 'Anda harus login sebagai admin.');
    }

    public function create()
    {
        // Pastikan hanya user yang terautentikasi yang bisa mengakses
        if (Auth::guard('admin')->check()) {
            return view('backend.v_kategori.create', [
                'judul' => 'Kategori',
            ]);
        }

        return redirect()->route('backend.login')->with('error', 'Anda harus login sebagai admin.');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategori',
        ]);

        // Simpan data ke database
        Kategori::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil tersimpan');
    }

    public function destroy(string $id)
    {
        if (Auth::guard('admin')->check()) {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('backend.login')->with('error', 'Anda harus login sebagai admin.');
    }

    public function edit(string $id)
    {
        if (Auth::guard('user')->check()) {
            $kategori = Kategori::find($id);
            return view('backend.v_kategori.edit', [
                'judul' => 'Kategori',
                'edit' => $kategori
            ]);
        }

        return redirect()->route('backend.login')->with('error', 'Anda harus login sebagai admin.');
    }

    public function update(Request $request, string $id)
    {
        if (Auth::guard('user')->check()) {
            $rules = [
                'nama_kategori' => 'required|max:255|unique:kategori,nama_kategori,' . $id,
            ];
            $validatedData = $request->validate($rules);
            Kategori::where('id', $id)->update($validatedData);

            return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil diperbaharui');
        }

        return redirect()->route('backend.login')->with('error', 'Anda harus login sebagai admin.');
    }
}
