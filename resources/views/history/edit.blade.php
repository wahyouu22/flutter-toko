@extends('v_layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
        <div>
            <a href="{{ route('history.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('history.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <input type="text" class="form-control" value="{{ $order->customer_name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Customer</label>
                                <input type="text" class="form-control" value="{{ $order->customer_email }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ID Pesanan</label>
                                <input type="text" class="form-control" value="#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Pesanan</label>
                                <input type="text" class="form-control" value="{{ $order->created_at->format('d M Y H:i') }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Nomor Resi</label>
                            <input type="text" class="form-control" id="tracking_number" name="tracking_number"
                                   value="{{ $order->tracking_number }}" {{ $order->status !== 'pending' ? 'readonly' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label for="hp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="hp" name="hp"
                                   value="{{ $order->hp }}" {{ $order->status !== 'pending' ? 'readonly' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                {{ $order->status !== 'pending' ? 'readonly' : '' }}>{{ $order->alamat }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="pos" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="pos" name="pos"
                                   value="{{ $order->pos }}" {{ $order->status !== 'pending' ? 'readonly' : '' }}>
                        </div>

                        @if($order->status === 'pending')
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Detail Produk</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->foto)
                                                    <img src="{{ asset('storage/img-produk/thumb_' . $item->product->foto) }}"
                                                         alt="{{ $item->product_name }}"
                                                         class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light me-3" style="width: 60px; height: 60px;"></div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product_name }}</h6>
                                                    <small class="text-muted">ID: {{ $item->product_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim:</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Pembayaran:</span>
                        <span>Rp {{ number_format($order->final_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Kurir:</strong> {{ $order->shipping_service }}
                    </div>
                    <div class="mb-2">
                        <strong>Estimasi:</strong> {{ $order->shipping_etd }} hari
                    </div>
                    <div class="mb-2">
                        <strong>Status:</strong> {!! $order->status_badge !!}
                    </div>

                    @if($order->tracking_number)
                        <div class="mt-3">
                            <strong>Nomor Resi:</strong> {{ $order->tracking_number }}
                            <a href="#" class="btn btn-sm btn-outline-primary ms-2">Lacak</a>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('history.invoice', $order->id) }}" class="btn btn-outline-info w-100" target="_blank">
                            <i class="fas fa-file-invoice me-2"></i>Lihat Invoice
                        </a>

                        @if($order->status === 'pending')
                            <form action="{{ route('history.pay', $order->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
