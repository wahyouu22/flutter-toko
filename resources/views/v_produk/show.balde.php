<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title">Pesan Produk</h4>

        <form action="{{ route('keranjang.add') }}" method="POST">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">

            <div class="row align-items-center">
                <div class="col-md-3 mb-3">
                    <label for="quantity" class="form-label">Jumlah:</label>
                    <input type="number"
                           name="quantity"
                           id="quantity"
                           class="form-control"
                           min="1"
                           max="{{ $produk->stok }}"
                           value="1">
                </div>

                <div class="col-md-9 mb-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </form>

        <div class="product-meta mt-3">
            <p class="mb-1"><strong>Berat:</strong> {{ $produk->berat * 1000 }} Gram</p>
            <p class="mb-1"><strong>Stok:</strong> {{ $produk->stok }}</p>
            <p class="mb-0"><strong>Harga:</strong> Rp. {{ number_format($produk->harga, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
