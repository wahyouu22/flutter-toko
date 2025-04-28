<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    // Menampilkan daftar history pesanan
    public function index()
    {
        $orders = Order::with(['items'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('history.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with(['items', 'items.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('history.edit', compact('order'));
    }

    // Update pesanan (alamat, kode pos, resi)
    public function update(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'alamat' => 'required|string|max:255',
            'pos' => 'required|string|max:10',
            'tracking_number' => 'nullable|string|max:100',
            'hp' => 'nullable|string|max:20',
        ]);

        $order->update($validated);

        return redirect()->route('history.show', $order->id)
            ->with('success', 'Data pesanan berhasil diperbarui.');
    }

    // Generate invoice PDF
    public function invoice($id)
    {
        $order = Order::with(['items', 'items.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('history.invoice', compact('order'));
    }

    // Download invoice PDF
    public function downloadInvoice($id)
    {
        $order = Order::with(['items', 'items.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('history.invoice-pdf', compact('order'));

        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    // Proses pembayaran
    public function processPayment($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        // Logika pembayaran disini
        // Misalnya redirect ke gateway pembayaran

        return redirect()->back()->with('info', 'Anda akan diarahkan ke halaman pembayaran.');
    }

    // Update status pesanan (untuk admin)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
