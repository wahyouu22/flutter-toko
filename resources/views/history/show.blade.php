@extends('v_layouts.app')

@section('content')
<div class="container py-5">
    <!-- Modal for enlarged receipt photo -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto Resi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-light">
                    <img id="enlargedReceipt" src="" class="img-fluid" style="max-height: 70vh; width: auto;" alt="Foto Resi">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a id="downloadReceipt" href="" download class="btn btn-primary">
                        <i class="fas fa-download me-2"></i> Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
        <div>
            <a href="{{ route('history.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Informasi Pesanan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <span class="fw-bold">No. Pesanan:</span> #{{ $order->id }}
                    </div>
                    <div class="mb-3">
                        <span class="fw-bold">Tanggal:</span> {{ $order->created_at->format('d-m-Y H:i') }}
                    </div>
                    <div class="mb-3">
                        <span class="fw-bold">Status:</span> {!! $order->status_badge !!}
                    </div>
                    @if($order->tracking_number)
                        <div class="mb-3">
                            <span class="fw-bold">Nomor Resi:</span> {{ $order->tracking_number }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <span class="fw-bold">Subtotal Produk:</span> Rp{{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                    <div class="mb-3">
                        <span class="fw-bold">Biaya Pengiriman:</span> Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
                    </div>
                    <div class="mb-3">
                        <span class="fw-bold">Total Pembayaran:</span> Rp{{ number_format($order->final_price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Data Pengiriman</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Informasi Pelanggan</h6>
                    <div class="mb-2"><span class="text-muted">Nama:</span> {{ $order->customer_name }}</div>
                    <div class="mb-2"><span class="text-muted">Email:</span> {{ $order->customer_email }}</div>
                    <div class="mb-2"><span class="text-muted">Telepon:</span> {{ $order->hp ?: '-' }}</div>
                    <div class="mb-2"><span class="text-muted">Alamat:</span> {{ $order->alamat ?: '-' }}</div>
                    <div class="mb-2"><span class="text-muted">Kota:</span> {{ $order->destination_city ?: '-' }}</div>
                    <div class="mb-2"><span class="text-muted">Kode Pos:</span> {{ $order->pos ?: '-' }}</div>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('history.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="tracking_number" class="form-label fw-bold">Nomor Resi</label>
                            <input type="text" class="form-control" id="tracking_number" name="tracking_number"
                                   value="{{ old('tracking_number', $order->tracking_number) }}">
                        </div>

                        <div class="mb-3">
                            <label for="foto_resi" class="form-label fw-bold">Upload Foto Resi</label>
                            <input type="file" class="form-control" id="foto_resi" name="foto_resi" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG (Maksimal 2MB)</small>
                        </div>

                        @if($order->foto_resi_url)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Foto Resi Saat Ini</label>
                                <div class="d-flex align-items-center">
                                    <div class="receipt-thumbnail me-3"
                                         onclick="openReceiptModal('{{ $order->foto_resi_url }}')">
                                        <img src="{{ $order->foto_resi_url }}"
                                             class="img-fluid"
                                             style="width: 150px; height: 150px; object-fit: contain; cursor: pointer;"
                                             alt="Foto Resi"
                                             onerror="this.onerror=null;this.src='{{ asset('images/default-receipt.png') }}'">
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="openReceiptModal('{{ $order->foto_resi_url }}')">
                                            <i class="fas fa-search-plus me-1"></i> Perbesar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-2"><span class="text-muted">Kurir:</span> {{ $order->shipping_service }}</div>
                        <div class="mb-2"><span class="text-muted">Estimasi:</span> {{ $order->shipping_etd }}</div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->foto)
                                            <img src="{{ asset('storage/img-produk/thumb_md_' . $item->product->foto) }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light me-3 d-flex align-items-center justify-content-center"
                                                 style="width: 80px; height: 80px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $item->product_name }}</h6>
                                            <small class="text-muted">ID: {{ $item->product_id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Subtotal Produk</th>
                            <th class="text-end">Rp{{ number_format($order->total_price, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Biaya Pengiriman</th>
                            <th class="text-end">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">TOTAL PEMBAYARAN</th>
                            <th class="text-end">Rp{{ number_format($order->final_price, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .receipt-thumbnail {
        width: 150px;
        height: 150px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 5px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .receipt-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-color: #adb5bd;
    }

    .receipt-thumbnail img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .modal-body.bg-light {
        background-color: #f8f9fa !important;
    }
</style>

<script>
    function openReceiptModal(imageSrc) {
        document.getElementById('enlargedReceipt').src = imageSrc;
        document.getElementById('downloadReceipt').href = imageSrc;
        var receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();
    }
</script>
@endsection
