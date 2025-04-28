<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Http;

class KeranjangController extends Controller
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = 'https://api.rajaongkir.com/starter';
    }

    public function index()
    {
        try {
            $cartItems = Cart::getContent();
            $isEmpty = Cart::isEmpty();

            // Calculate total weight (convert kg to gram)
            $totalWeight = $cartItems->sum(function($item) {
                return ($item->attributes['berat'] ?? 0) * $item->quantity * 1000;
            });

            // Get the validated session data first
            $validated = session('shipping_validated', []);

            // Get all provinces for shipping form
            $provincesResponse = Http::withHeaders([
                'key' => $this->apiKey
            ])->get("{$this->baseUrl}/province");

            $provinces = [];
            if ($provincesResponse->successful()) {
                $provinces = $provincesResponse->json()['rajaongkir']['results'];
            } else {
                session()->flash('error', 'Gagal memuat data provinsi. Silakan coba lagi.');
            }

            // Get all cities for origin selection
            $citiesResponse = Http::withHeaders([
                'key' => $this->apiKey
            ])->get("{$this->baseUrl}/city");

            $cities = [];
            if ($citiesResponse->successful()) {
                $cities = $citiesResponse->json()['rajaongkir']['results'];
            } else {
                session()->flash('error', 'Gagal memuat data kota. Silakan coba lagi.');
            }

            $couriers = [
                'jne' => 'JNE',
                'pos' => 'POS Indonesia',
                'tiki' => 'TIKI'
            ];

            return view('keranjang.index', [
                'cartItems' => $cartItems,
                'isEmpty' => $isEmpty,
                'total' => Cart::getTotal(),
                'subTotal' => Cart::getSubTotal(),
                'totalQuantity' => Cart::getTotalQuantity(),
                'totalWeight' => $totalWeight,
                'provinces' => $provinces,
                'couriers' => $couriers,
                'cities' => $cities,
                'shippingCost' => session('shipping_cost', 0),
                'shippingResult' => session('shipping_result'),
                'validated' => $validated
            ]);
        } catch (\Exception $e) {
            report($e);
            return view('keranjang.index', [
                'cartItems' => collect(),
                'isEmpty' => true,
                'total' => 0,
                'subTotal' => 0,
                'totalQuantity' => 0,
                'totalWeight' => 0,
                'provinces' => [],
                'couriers' => [],
                'cities' => [],
                'shippingCost' => 0,
                'shippingResult' => null,
                'validated' => []
            ])->with('error', 'Terjadi kesalahan saat memuat keranjang belanja.');
        }
    }

    public function calculateShipping(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|numeric',
            'destination_province' => 'required|numeric',
            'destination' => 'required|numeric',
            'weight' => 'required|numeric|min:1',
            'courier' => 'required|in:jne,pos,tiki'
        ]);

        $response = Http::withHeaders([
            'key' => $this->apiKey,
            'content-type' => 'application/x-www-form-urlencoded'
        ])->asForm()->post("{$this->baseUrl}/cost", [
            'origin' => $validated['origin'],
            'destination' => $validated['destination'],
            'weight' => $validated['weight'],
            'courier' => $validated['courier']
        ]);

        $result = [];
        $shippingCost = 0;

        if ($response->successful()) {
            $result = $response->json()['rajaongkir'];

            // Get the cheapest shipping option
            if (!empty($result['results'][0]['costs'])) {
                $cheapest = collect($result['results'][0]['costs'])->sortBy('cost.0.value')->first();
                $shippingCost = $cheapest['cost'][0]['value'] ?? 0;
            }
        } else {
            return back()->with('error', 'Gagal menghitung ongkos kirim. Silakan coba lagi.');
        }

        // Store shipping data in session
        session([
            'shipping_result' => $result,
            'shipping_cost' => $shippingCost,
            'shipping_validated' => $validated
        ]);

        return redirect()->route('keranjang.index');
    }

    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get("{$this->baseUrl}/city", [
            'province' => $provinceId
        ]);

        if ($response->successful()) {
            return response()->json($response->json()['rajaongkir']['results']);
        }

        return response()->json([]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $produk = Produk::findOrFail($validated['produk_id']);

        // Cek stok tersedia
        if ($produk->stok < $validated['quantity']) {
            return back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia: '.$produk->stok);
        }

        // Cek apakah produk sudah ada di keranjang
        $existingItem = Cart::get($produk->id);
        $newQuantity = $existingItem ? $existingItem->quantity + $validated['quantity'] : $validated['quantity'];

        // Validasi ulang stok dengan quantity baru
        if ($produk->stok < $newQuantity) {
            return back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta! Stok tersedia: '.$produk->stok);
        }

        Cart::add([
            'id' => $produk->id,
            'name' => $produk->nama_produk,
            'price' => $produk->harga,
            'quantity' => $validated['quantity'],
            'attributes' => [
                'berat' => $produk->berat,
                'foto' => $produk->foto,
                'stok' => $produk->stok,
                'kategori' => $produk->kategori->nama_kategori ?? 'Tidak ada kategori'
            ],
            'associatedModel' => $produk
        ]);

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $item = Cart::get($validated['id']);

        if (!$item) {
            return back()->with('error', 'Item tidak ditemukan dalam keranjang');
        }

        // Cek stok tersedia
        if ($item->attributes['stok'] < $validated['quantity']) {
            return back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia: '.$item->attributes['stok']);
        }

        Cart::update($validated['id'], [
            'quantity' => [
                'relative' => false,
                'value' => $validated['quantity']
            ]
        ]);

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Keranjang berhasil diperbarui');
    }

    public function remove(Request $request)
    {
        $validated = $request->validate(['id' => 'required']);

        if (!Cart::get($validated['id'])) {
            return back()->with('error', 'Item tidak ditemukan dalam keranjang');
        }

        Cart::remove($validated['id']);

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function clear()
    {
        Cart::clear();
        // Also clear shipping data
        session()->forget(['shipping_result', 'shipping_cost', 'shipping_validated']);

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Keranjang berhasil dikosongkan');
    }
}
