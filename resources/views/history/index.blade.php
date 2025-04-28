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
                                    <a href="{{ route('history.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                    <a href="{{ route('history.invoice', $order->id) }}" class="btn btn-sm btn-outline-info" target="_blank">
                                        <i class="fas fa-file-invoice me-1"></i> Invoice
                                    </a>
                                    @if($order->status === 'pending')
                                        <form action="{{ route('history.pay', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-credit-card me-1"></i> Bayar
                                            </button>
                                        </form>
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
@endsection
