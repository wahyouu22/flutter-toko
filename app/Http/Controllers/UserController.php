<?php 
namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use App\Helpers\ImageHelper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::orderBy('updated_at', 'desc')->get();
        return view('backend.v_user.index', [
            'judul' => 'Data User',
            'index' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_user.create', [ 
            'judul' => 'Tambah User', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([ 
            'nama' => 'required|max:255', // Gunakan 'nama' sesuai dengan Blade view
            'email' => 'required|max:255|email|unique:users', 
            'role' => 'required', 
            'hp' => 'required|min:10|max:13', 
            'password' => [
                'required',
                'min:4',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ], 
        [
            'nama.required' => 'Nama wajib diisi.',  // Sesuaikan pesan error dengan 'nama'
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'hp.required' => 'Nomor HP wajib diisi.',
            'hp.min' => 'Nomor HP minimal 10 karakter.',
            'hp.max' => 'Nomor HP maksimal 13 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.regex' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol.',
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar maksimal adalah 1024 KB.',
        ]);
        
        // Set status default
        $validatedData['status'] = 0; 

        // Upload foto jika ada
        if ($request->file('foto')) { 
            $file = $request->file('foto'); 
            $extension = $file->getClientOriginalExtension(); 
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
            $directory = 'storage/img-user/'; 
            
            // Simpan gambar dengan ukuran yang ditentukan
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);

            // Simpan nama file asli di database
            $validatedData['foto'] = $originalFileName; 
        } 

        // Validasi pola password
        $password = $request->input('password'); 
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'; 
        
        if (preg_match($pattern, $password)) {
            // Enkripsi password sebelum disimpan
            $validatedData['password'] = Hash::make($validatedData['password']);
            
            // Simpan data pengguna ke database
            User::create($validatedData);
            
            // Redirect ke halaman user.index dengan pesan sukses
            return redirect()->route('backend.user.index')->with('success', 'Data berhasil tersimpan');
        } else {
            // Jika password tidak sesuai dengan pola, kembalikan dengan error
            return redirect()->back()->withErrors(['password' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol karakter.']);
        }
    }

    public function destroy(string $id) 
    { 
        $user = user::findOrFail($id); 
        if ($user->foto) { $oldImagePath = public_path('storage/img-user/') . $user->foto; 
            if (file_exists($oldImagePath)) {unlink($oldImagePath); 
        } 
    } 
    $user->delete(); 
    return redirect()->route('backend.user.index')->with('success', 'Data berhasil dihapus');   
    }

    public function update(Request $request, string $id) 
    { 
    // Debug request jika diperlukan
    // ddd($request); 

    // Ambil data user berdasarkan ID
    $user = User::findOrFail($id); 

    // Atur rules validasi
    $rules = [ 
        'nama' => 'required|max:255', 
        'role' => 'required', 
        'status' => 'required', 
        'hp' => 'required|min:10|max:13', 
        'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024', // Tambahkan 'nullable'
    ]; 

    // Pesan validasi
    $messages = [ 
        'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.', 
        'foto.max' => 'Ukuran file gambar maksimal adalah 1024 KB.' 
    ]; 

    // Jika email diubah, tambahkan validasi unique
    if ($request->email != $user->email) { 
        $rules['email'] = 'required|max:255|email|unique:users'; 
    } 

    // Validasi data
    $validatedData = $request->validate($rules, $messages); 

    // Penanganan file gambar Image Helper
    if ($request->file('foto')) { 
        // Hapus gambar lama jika ada
        if ($user->foto) { 
            $oldImagePath = public_path('storage/img-user/') . $user->foto; 
            if (file_exists($oldImagePath)) { 
                unlink($oldImagePath); 
            } 
        } 

        // Simpan gambar baru
        $file = $request->file('foto'); 
        $extension = $file->getClientOriginalExtension(); 
        $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
        $directory = 'storage/img-user/'; 
        
        // Simpan gambar dengan ukuran yang ditentukan
        ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);

        // Simpan nama file asli di database
        $validatedData['foto'] = $originalFileName; 
    }

    // Update data user di database
    $user->update($validatedData); 

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('backend.user.index')->with('success', 'Data berhasil diperbarui');
    }


    public function edit(string $id) 
    { 
        // Cari data user berdasarkan ID
        $user = User::findOrFail($id); 

        // Tampilkan view edit dengan data user
        return view('backend.v_user.edit', [ 
        'judul' => 'Ubah User', 
        'edit' => $user 
        ]);
    }

    public function formUser() 
    { 
        return view('backend.v_user.form', [ 
            'judul' => 'Laporan Data User', 
        ]); 
    } 
 
    public function cetakUser(Request $request) 
    { 
        // Menambahkan aturan validasi 
        $request->validate([ 
            'tanggal_awal' => 'required|date', 
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal', 
        ], [ 
            'tanggal_awal.required' => 'Tanggal Awal harus diisi.', 
            'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.', 
            'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.', 
        ]); 
 
        $tanggalAwal = $request->input('tanggal_awal'); 
        $tanggalAkhir = $request->input('tanggal_akhir'); 
 
        $query =  User::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]) 
            ->orderBy('id', 'desc'); 
 
        $user = $query->get(); 
        return view('backend.v_user.cetak', [ 
            'judul' => 'Laporan User', 
            'tanggalAwal' => $tanggalAwal, 
            'tanggalAkhir' => $tanggalAkhir, 
            'cetak' => $user 
        ]);
    } 
}
