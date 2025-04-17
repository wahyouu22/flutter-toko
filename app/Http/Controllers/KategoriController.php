<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get(); 
        return view('backend.v_kategori.index', [ 
            'judul' => 'Kategori', 
            'index' => $kategori 
        ]);
    }

    public function create()
    {
        return view('backend.v_kategori.create', [ 
            'judul' => 'Kategori', 
        ]); 
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
        $user = kategori::findOrFail($id); 
        $user->delete(); 
        return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil dihapus'); 
    }

    public function edit(string $id)
    {
        $kategori = Kategori::find($id); 
        return view('backend.v_kategori.edit', [ 
            'judul' => 'Kategori', 
            'edit' => $kategori
        ]); 
    }

    public function update(Request $request, string $id)
    {
        $rules = [ 
            'nama_kategori' => 'required|max:255|unique:kategori,nama_kategori,' . $id, 
        ]; 
        $validatedData = $request->validate($rules); 
        Kategori::where('id', $id)->update($validatedData); 
        return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil diperbaharui'); 
    }

}
