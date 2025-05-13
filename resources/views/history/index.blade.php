@extends('v_layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Pesanan</h2>
        <div>
            <a href="{{ route('beranda') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali Berbelanja
            </a>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Anda belum memiliki riwayat pesanan.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>Rp {{ number_format($order->final_price, 0, ',', '.') }}</td>
                            <td>{!! $order->status_badge !!}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{
                                        in_array($order->status, ['processing', 'shipped'])
                                        ? route('history.edit', $order->id)
                                        : route('history.show', $order->id)
                                    }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>

                                    <a href="{{ route('history.invoice', $order->id) }}" class="btn btn-sm btn-outline-info" target="_blank">
                                        <i class="fas fa-file-invoice me-1"></i> Invoice
                                    </a>

                                    @if($order->status === 'pending')
                                        <button class="btn btn-sm btn-success pay-button" 
                                            data-order-id="{{ $order->id }}"
                                            data-snap-token="{{ isset($snapToken) && $currentOrderId == $order->id ? $snapToken : '' }}">
                                            <i class="fas fa-credit-card me-1"></i> Bayar
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@if(isset($snapToken))
<!-- Midtrans Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="payment-container">
                    <!-- Midtrans payment form will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
@parent
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    $(document).ready(function() {
        $('.pay-button').click(function(e) {
            e.preventDefault();
            const orderId = $(this).data('order-id');
            const snapToken = $(this).data('snap-token');
            
            if (snapToken) {
                // Jika sudah ada token, langsung tampilkan popup pembayaran
                initiatePayment(snapToken);
            } else {
                // Jika belum ada token, ambil dulu via AJAX
                fetchSnapToken(orderId);
            }
        });

        function fetchSnapToken(orderId) {
            $.ajax({
                url: "{{ route('history.pay', '') }}/" + orderId,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.snapToken) {
                        initiatePayment(response.snapToken);
                    } else {
                        alert('Gagal mendapatkan token pembayaran');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memproses pembayaran');
                }
            });
        }

        function initiatePayment(snapToken) {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil!');
                    window.location.reload();
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran Anda!');
                    window.location.reload();
                },
                onError: function(result) {
                    alert('Pembayaran gagal! Silakan coba lagi.');
                },
                onClose: function() {
                    console.log('Anda menutup popup pembayaran');
                }
            });
        }
    });
</script>
@endsection