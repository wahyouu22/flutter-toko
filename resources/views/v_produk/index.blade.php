@extends('v_layouts.app')
@section('content')
<!-- template -->
<!-- STORE -->
<div id="store">
    <!-- row -->
    <div class="row">
        @foreach ($produk as $row)
        <!-- Product Single -->
        <div class="col-md-4 col-sm-6 col-xs-6">
            <div class="product product-single">
                <div class="product-thumb">
                    <div class="product-label">
                        <span>Kategori</span>
                        <span class="sale">{{ $row->kategori->nama_kategori }}</span>
                    </div>
                    <a href="{{ route('produk.detail', $row->id) }}">
                        <button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Detail Produk</button>
                    </a>
                    <img src="{{ asset('storage/img-produk/thumb_md_' . $row->foto) }}" alt="">
                </div>
                <div class="product-body">
                    <h3 class="product-price">
                        Rp. {{ number_format($row->harga, 0, ',', '.') }}
                        <span class="product-old-price">{{ $row->kategori->nama_kategori }}</span>
                    </h3>
                    <h2 class="product-name"><a href="#">{{ $row->nama_produk }}</a></h2>
                    <div class="product-btns">
                        <a href="{{ route('produk.detail', $row->id) }}" title="Detail Produk">
                            <button class="main-btn icon-btn"><i class="fa fa-search-plus"></i></button>
                        </a>
                        <form action="{{ route('keranjang.add') }}" method="POST" style="display: inline-block;" title="Pesan Ke Aplikasi">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $row->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="primary-btn add-to-cart">
                                <i class="fa fa-shopping-cart"></i> Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Product Single -->
        @endforeach
        <div class="clearfix visible-md visible-lg visible-sm visible-xs"></div>
    </div>
    <div class="store-filter clearfix">
        <div class="pagination">
            {{ $produk->links() }}
        </div>
    </div>
    <!-- /row -->
</div>
<!-- /STORE -->
<!-- end template -->

<style>
.pagination > li > a,
.pagination > li > span {
    padding: 5px 10px;
    font-size: 14px;
}

.pagination > li:first-child > a,
.pagination > li:last-child > a {
    position: relative;
    padding: 5px 12px;
}

/* Ukuran SVG/icon dalam tombol previous/next */
.pagination svg {
    width: 16px !important;
    height: 16px !important;
}

.pagination .fa-chevron-left,
.pagination .fa-chevron-right {
    font-size: 14px !important;
}
</style>
@endsection
