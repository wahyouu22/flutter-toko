<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerAuthController;

Route::get('/', function () {
    return redirect()->route('beranda');
});

// Frontend Routes
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

// Backend Routes
Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda');
Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login.authenticate');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

Route::resource('backend/user', UserController::class, ['as' => 'backend'])->middleware('auth');
Route::resource('backend/kategori', KategoriController::class, ['as' => 'backend'])->middleware('auth');
Route::resource('backend/produk', ProdukController::class, ['as' => 'backend'])->middleware('auth');

// Route untuk foto produk
Route::post('foto-produk/store', [ProdukController::class, 'storeFoto'])->name('backend.foto_produk.store')->middleware('auth');
Route::delete('foto-produk/{id}', [ProdukController::class, 'destroyFoto'])->name('backend.foto_produk.destroy')->middleware('auth');
Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser')->middleware('auth');
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser')->middleware('auth');

Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('backend.laporan.formproduk')->middleware('auth');
Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])->name('backend.laporan.cetakproduk')->middleware('auth');

// Frontend Produk Routes
Route::get('/produk/detail/{id}', [ProdukController::class, 'detail'])->name('produk.detail');
Route::post('/produk/detail/{id}', [ProdukController::class, 'detail'])->name('produk.detail');
Route::get('/produk/kategori/{id}', [ProdukController::class, 'produkKategori'])->name('produk.kategori');
Route::get('/produk/all', [ProdukController::class, 'produkAll'])->name('produk.all');

// API Google
Route::get('auth/google', [CustomerController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [CustomerController::class, 'callback'])->name('auth.google.callback');

// Customer Login Routes
Route::get('customer/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('customer/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');
// logout customer
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

//tentang kami
Route::get('/tentang-kami', function () {
    return view('tantang-kami'); // atau 'pages.tantang-kami' jika di folder
});

// Customer Dashboard Routes
Route::middleware('auth')->group(function() {
    Route::get('customer/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard');
    Route::post('customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
});
