<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'pos_code' => 'required|string|max:10',
            'shipping_cost' => 'required|numeric|min:0',
            'shipping_service' => 'required|string',
            'shipping_etd' => 'required|string',
            'destination_city' => 'required|string',
            'foto_resi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // resi foto
        ]);

        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang belanja kosong.'], 400);
        }

        try {
            $totalPrice = Cart::getTotal();
            $totalWeight = $cartItems->sum(fn($item) => ($item->attributes['berat'] ?? 0) * $item->quantity);
            $finalPrice = $totalPrice + $validated['shipping_cost'];

            // Upload foto resi jika ada
            $fotoResiPath = null;
            if ($request->hasFile('foto_resi')) {
                $fotoResiPath = $request->file('foto_resi')->store('foto_resi', 'public');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'hp' => $validated['phone'],
                'alamat' => $validated['address'],
                'address' => $validated['address'],
                'pos' => $validated['pos_code'],
                'total_price' => $totalPrice,
                'shipping_cost' => $validated['shipping_cost'],
                'final_price' => $finalPrice,
                'shipping_service' => $validated['shipping_service'],
                'shipping_etd' => $validated['shipping_etd'],
                'destination_city' => $validated['destination_city'],
                'status' => 'pending',
                'foto_resi' => $fotoResiPath // <--- simpan path gambar
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'berat' => $item->attributes['berat'] ?? 0,
                    'total_price' => $item->price * $item->quantity
                ]);

                $product = Produk::find($item->id);
                if ($product) {
                    $product->decrement('stok', $item->quantity);
                }
            }

            Cart::clear();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat! Anda akan diarahkan ke halaman riwayat pesanan dalam 3 detik.',
                'order_id' => $order->id,
                'final_price' => $finalPrice,
                'status' => $order->status,
                'foto_resi_url' => $fotoResiPath ? asset('storage/' . $fotoResiPath) : null,
                'redirect' => route('history.index'),
                'redirect_time' => 3000
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $order = Order::with(['items', 'items.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($order);
    }
}

