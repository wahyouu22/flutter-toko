@extends('v_layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Invoice #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
        <div>
            <a href="{{ route('history.show', $order->id) }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('history.invoice.download', $order->id) }}" class="btn btn-primary">
                <i class="fas fa-download me-2"></i>Download PDF
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4 class="mb-3">Informasi Toko</h4>
                    <p class="mb-1"><strong>Nama Toko:</strong> {{ config('app.name') }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> Jl. Contoh No. 123, Kota Contoh</p>
                    <p class="mb-1"><strong>Telepon:</strong> (021) 12345678</p>
                    <p class="mb-1"><strong>Email:</strong> info@toko.example.com</p>
                </div>
                <div class="col-md-6 text-end">
                    <h4 class="mb-3">Invoice</h4>
                    <p class="mb-1"><strong>No. Invoice:</strong> INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
                    <p class="mb-1"><strong>Status:</strong> {!! $order->status_badge !!}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h4 class="mb-3">Informasi Pelanggan</h4>
                    <p class="mb-1"><strong>Nama:</strong> {{ $order->customer_name }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p class="mb-1"><strong>Telepon:</strong> {{ $order->hp ?? '-' }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> {{ $order->alamat }}</p>
                    <p class="mb-1"><strong>Kode Pos:</strong> {{ $order->pos }}</p>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Informasi Pengiriman</h4>
                    <p class="mb-1"><strong>Kurir:</strong> {{ $order->shipping_service }}</p>
                    <p class="mb-1"><strong>Estimasi:</strong> {{ $order->shipping_etd }} hari</p>
                    <p class="mb-1"><strong>Resi:</strong> {{ $order->tracking_number ?? 'Belum tersedia' }}</p>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $item->product_name }}
                                    <small class="text-muted d-block">ID: {{ $item->product_id }}</small>
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Ongkos Kirim:</strong></td>
                            <td>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total Pembayaran:</strong></td>
                            <td>Rp {{ number_format($order->final_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="border-top pt-4">
                <h5 class="mb-3">Catatan:</h5>
                <p>Terima kasih telah berbelanja di toko kami. Silakan hubungi kami jika ada pertanyaan mengenai pesanan Anda.</p>
                <p class="mb-0">Invoice ini sah dan diproses oleh sistem.</p>
            </div>
        </div>
    </div>
</div>
@endsection
