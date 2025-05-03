<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Invoice Pesanan #{{$order->id}}</title>
    <style type="text/css">
        body {
            font-family: "Helvetica", Arial, sans-serif;
            font-size: 9pt;
            background: #fff;
            margin: 10px;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .logo {
            width: 40px;
            max-height: 60px;
        }

        .company-address {
            font-size: 8pt;
            margin-top: 5px;
            line-height: 1.4;
        }

        .invoice-title {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
        }

        table.invoice {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 15px;
        }

        table.invoice th {
            padding: 8px 10px;
            background-color: #E6EE9C;
            border: 1px solid #81C784;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table.invoice td {
            padding: 8px 10px;
            border: 1px solid #81C784;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .customer-info {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .customer-info th {
            background-color: #E6EE9C;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        .customer-info td {
            padding: 8px;
            vertical-align: top;
        }

        .customer-detail {
            margin-bottom: 5px;
        }

        .customer-label {
            display: inline-block;
            width: 80px;
            font-weight: bold;
        }

        .summary {
            margin-top: 20px;
            font-size: 9pt;
        }

        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #81C784;
            font-size: 8pt;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr>
            <td width="50%" valign="top">
                @if(file_exists(public_path('image/logo.png')))
                    <img src="{{ public_path('image/logo.png') }}" class="logo" alt="Logo Perusahaan"/>
                @else
                    <h2>{{ config('app.name') }}</h2>
                @endif
                <div class="company-address">
                    RT.5/RW.6, Lubang Buaya, Kec. Cipayung<br>
                    Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta, Kode Pos 13810<br>
                    Telp: (021) 12345678
                </div>
            </td>
            <td width="50%" valign="top" align="right">
                <p>
                    <span style="font-size: 10pt">No. Pesanan: <b>#{{$order->id}}</b></span><br/>
                    Tanggal: <b>{{$order->created_at->format('d-m-Y H:i')}}</b><br/>
                    Status: <b>{{ ucfirst($order->status) }}</b><br/>
                    @if($order->tracking_number)
                        No. Resi: <b>{{$order->tracking_number}}</b>
                    @endif
                </p>
            </td>
        </tr>
    </table>

    <div class="invoice-title">
        INVOICE PEMBAYARAN
    </div>

    <table class="invoice">
        <thead>
            <tr>
                <th>Produk</th>
                <th width="10%">Qty</th>
                <th width="15%">Harga Satuan</th>
                <th width="15%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderItems as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-right" style="font-weight: bold;">Subtotal Produk</td>
                <td class="text-right" style="font-weight: bold;">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Biaya Pengiriman</td>
                <td class="text-right">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="font-weight: bold;">TOTAL PEMBAYARAN</td>
                <td class="text-right" style="font-weight: bold;">Rp{{ number_format($order->final_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="customer-info">
        <tr>
            <th width="50%">Informasi Pelanggan</th>
            <th width="50%">Informasi Pengiriman</th>
        </tr>
        <tr>
            <td>
                <div class="customer-detail"><span class="customer-label">Nama</span>: {{ $order->customer_name }}</div>
                <div class="customer-detail"><span class="customer-label">Email</span>: {{ $order->customer_email }}</div>
                <div class="customer-detail"><span class="customer-label">Telepon</span>: {{ $order->hp ?: '-' }}</div>
                <div class="customer-detail"><span class="customer-label">Alamat</span>: {{ $order->alamat ?: '-' }}</div>
                <div class="customer-detail"><span class="customer-label">Kota</span>: {{ $order->destination_city ?: '-' }}</div>
                <div class="customer-detail"><span class="customer-label">Kode Pos</span>: {{ $order->pos ?: '-' }}</div>
            </td>
            <td>
                <div class="customer-detail"><span class="customer-label">Kurir</span>: {{ $order->shipping_service }}</div>
                <div class="customer-detail"><span class="customer-label">Estimasi</span>: {{ $order->shipping_etd }}</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>Terima kasih telah berbelanja di {{ config('app.name') }}</p>
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
    </div>
</body>
</html>
