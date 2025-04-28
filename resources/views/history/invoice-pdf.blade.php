<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .invoice-info {
            text-align: right;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .row {
            display: flex;
            margin-bottom: 15px;
        }
        .col-md-6 {
            width: 50%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .text-end {
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            padding: 3px 7px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border-radius: 10px;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .badge-info {
            background-color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>No. Invoice:</strong> INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong>
                    @if($order->status === 'completed' || $order->status === 'sukses')
                        <span class="badge badge-success">{{ ucfirst($order->status) }}</span>
                    @elseif($order->status === 'pending')
                        <span class="badge badge-warning">{{ ucfirst($order->status) }}</span>
                    @elseif($order->status === 'cancelled')
                        <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                    @else
                        <span class="badge badge-info">{{ ucfirst($order->status) }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="section">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title">Informasi Toko</div>
                    <p><strong>Nama Toko:</strong> {{ config('app.name') }}</p>
                    <p><strong>Alamat:</strong> Jl. Contoh No. 123, Kota Contoh</p>
                    <p><strong>Telepon:</strong> (021) 12345678</p>
                    <p><strong>Email:</strong> info@toko.example.com</p>
                </div>
                <div class="col-md-6">
                    <div class="section-title">Informasi Pelanggan</div>
                    <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Telepon:</strong> {{ $order->hp ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ $order->alamat }}</p>
                    <p><strong>Kode Pos:</strong> {{ $order->pos }}</p>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Detail Pesanan</div>
            <table>
                <thead>
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
                                <small style="color: #666;">ID: {{ $item->product_id }}</small>
                            </td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
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

        <div class="section">
            <div class="section-title">Informasi Pengiriman</div>
            <p><strong>Kurir:</strong> {{ $order->shipping_service }}</p>
            <p><strong>Estimasi:</strong> {{ $order->shipping_etd }} hari</p>
            <p><strong>Resi:</strong> {{ $order->tracking_number ?? 'Belum tersedia' }}</p>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di toko kami</p>
            <p>Invoice ini sah dan diproses oleh sistem</p>
        </div>
    </div>
</body>
</html>
