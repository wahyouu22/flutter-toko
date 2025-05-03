@extends('v_layouts.app')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Invoice Pesanan</h4>
                <a href="{{ route('history.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Header Invoice -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="mb-1">{{ config('app.name') }}</h2>
                    <p class="mb-1">RT.5/RW.6, Lubang Buaya, Kec. Cipayung</p>
                    <p class="mb-1">Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta, Kode Pos 13810</p>
                    <p class="mb-0">Telp: (021) 12345678</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h3 class="text-primary">INVOICE</h3>
                    <p class="mb-1"><strong>No. Invoice:</strong> INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                    <p class="mb-0"><strong>Status:</strong> {!! $order->status_badge !!}</p>
                </div>
            </div>

            <hr>

            <!-- Info Pelanggan -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informasi Pelanggan</h5>
                    <p class="mb-1"><strong>Nama:</strong> {{ $order->customer_name }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p class="mb-1"><strong>No. HP:</strong> {{ $order->hp }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Alamat Pengiriman</h5>
                    <p class="mb-1">{{ $order->alamat }}</p>
                    <p class="mb-1">{{ $order->destination_city }}</p>
                    <p class="mb-1"><strong>Kode Pos: </strong>{{ $order->pos }}</p>
                </div>
            </div>

            <!-- Detail Pesanan -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Subtotal</strong></td>
                            <td class="text-end">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Ongkos Kirim</strong></td>
                            <td class="text-end">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total Pembayaran</strong></td>
                            <td class="text-end">Rp {{ number_format($order->final_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Info Pengiriman -->
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Pengiriman</h5>
                    <p class="mb-1"><strong>Kurir:</strong> {{ strtoupper($order->shipping_service) }}</p>
                    <p class="mb-1"><strong>Estimasi:</strong> {{ $order->shipping_etd }}</p>
                    @if($order->tracking_number)
                    <p class="mb-1"><strong>No. Resi:</strong> {{ $order->tracking_number }}</p>
                    @endif
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mt-4 pt-2">
                        <a href="{{ route('history.invoice.pdf', $order->id) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf me-2"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light">
            <div class="text-center">
                <p class="mb-0">Terima kasih telah berbelanja di {{ config('app.name') }}</p>
                <p class="mb-0">Silahkan hubungi kami jika ada pertanyaan</p>
            </div>
        </div>
    </div>
</div>
@endsection
