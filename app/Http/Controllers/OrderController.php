<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;  // Add this import
use Illuminate\Support\Facades\Auth;

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
        ]);

        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        try {
            // Calculate totals
            $totalPrice = Cart::getTotal();
            $totalWeight = $cartItems->sum(fn($item) => ($item->attributes['berat'] ?? 0) * $item->quantity);
            $finalPrice = $totalPrice + $validated['shipping_cost'];

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'pos_code' => $validated['pos_code'],
                'total_price' => $totalPrice,
                'shipping_cost' => $validated['shipping_cost'],
                'final_price' => $finalPrice,
                'shipping_service' => $validated['shipping_service'],
                'shipping_etd' => $validated['shipping_etd'],
                'destination_city' => $validated['destination_city'],
                'status' => 'pending'
            ]);

            // Create order items and update product stock
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

                // Update product stock
                $product = Produk::find($item->id);
                if ($product) {
                    $product->decrement('stok', $item->quantity);
                }
            }

            // Clear cart
            Cart::clear();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Nomor Order: #'.$order->id);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: '.$e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $order = Order::with(['items', 'items.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}


/*
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        // Validasi data customer dengan field baru
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'pos_code' => 'required|string|max:10'
        ]);

        // Get cart items
        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang belanja kosong.');
        }

        // Calculate total weight
        $totalWeight = $cartItems->sum(function ($item) {
            return ($item->attributes['berat'] ?? 0) * $item->quantity;
        });

        // Prepare data for shipping page
        $orderData = [
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'pos_code' => $validated['pos_code'],
            'items' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'berat' => $item->attributes['berat'] ?? 0,
                    'total_price' => $item->price * $item->quantity
                ];
            })->toArray(),
            'total_price' => Cart::getTotal(),
            'total_weight' => $totalWeight,
            'total_quantity' => Cart::getTotalQuantity()
        ];

        // Store order data temporarily in session
        $request->session()->put('current_order', $orderData);

        return redirect()->route('ongkir.index');
    }

    public function confirmOrder(Request $request)
    {
        // Validate shipping cost dan tambahkan validasi untuk field baru
        $validated = $request->validate([
            'shipping_cost' => 'required|numeric|min:0',
            'shipping_service' => 'required|string',
            'shipping_etd' => 'required|string',
            'destination_city' => 'required|string',
        ]);

        // Get temporary order data from session
        $orderData = $request->session()->get('current_order');

        if (!$orderData) {
            return redirect()->route('keranjang.index')->with('error', 'Sesi order tidak valid.');
        }

        // Calculate final price
        $finalPrice = $orderData['total_price'] + $validated['shipping_cost'];

        // Create order dengan field baru
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $orderData['customer_name'],
            'customer_email' => $orderData['customer_email'],
            'phone' => $orderData['phone'],
            'address' => $orderData['address'],
            'pos_code' => $orderData['pos_code'],
            'total_price' => $orderData['total_price'],
            'shipping_cost' => $validated['shipping_cost'],
            'final_price' => $finalPrice,
            'shipping_service' => $validated['shipping_service'],
            'shipping_etd' => $validated['shipping_etd'],
            'destination_city' => $validated['destination_city'],
            'status' => 'pending'
        ]);

        // Create order items
        foreach ($orderData['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'berat' => $item['berat'],
                'total_price' => $item['total_price']
            ]);
        }

        // Clear cart and session data
        Cart::clear();
        $request->session()->forget('current_order');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
*/
