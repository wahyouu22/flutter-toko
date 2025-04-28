@extends('v_layouts.app')
@section('content')
<!-- Product Detail Template -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="section-title">
                <h3 class="title">DETAIL PRODUK</h3>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="row product-detail-container">
        <!-- Product Images (Left Side) -->
        <div class="col-md-5">
            <div id="product-main-view" class="product-image-container">
                <div class="product-view main-image">
                    <img src="{{ asset('storage/img-produk/thumb_lg_' . $row->foto) }}" alt="{{ $row->nama_produk }}" class="img-fluid">
                </div>
                @if(count($fotoProdukTambahan) > 0)
                <div class="product-thumbnails">
                    @foreach ($fotoProdukTambahan as $item)
                        @if ($item->produk_id == $row->id)
                        <div class="thumbnail-item">
                            <img src="{{ asset('storage/img-produk/' . $item->foto) }}" alt="Thumbnail" class="img-fluid">
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info (Right Side) -->
        <div class="col-md-7">
            <div class="product-body">
                <div class="product-header">
                    <span class="product-category">
                        <strong>Kategori:</strong> {{ $row->kategori->nama_kategori }}
                    </span>
                    <h1 class="product-name">{{ $row->nama_produk }}</h1>
                    <div class="product-price">
                        Rp. {{ number_format($row->harga, 0, ',', '.') }}
                    </div>
                </div>

                <div class="product-description">
                    <p>{!! $row->detail !!}</p>
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <strong>Berat:</strong> {{ $row->berat }} Gram
                    </div>
                    <div class="meta-item">
                        <strong>Stok:</strong> {{ $row->stok }}
                    </div>
                </div>

                <div class="product-actions">
                    <form action="{{ route('keranjang.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $row->id }}">

                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn minus-btn">-</button>
                            <input type="number" name="quantity" class="quantity-input" value="1" min="1" max="{{ $row->stok }}">
                            <button type="button" class="quantity-btn plus-btn">+</button>
                        </div>

                        <button type="submit" class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Product Detail Layout */
    .product-detail-container {
        margin-top: 30px;
        padding: 20px;
    }

    .product-image-container {
        margin-bottom: 20px;
    }

    .main-image img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 8px;
    }

    .product-thumbnails {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .thumbnail-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        border: 1px solid #ddd;
    }

    .product-body {
        padding: 0 20px;
    }

    .product-header {
        margin-bottom: 20px;
    }

    .product-category {
        display: block;
        color: #666;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .product-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
    }

    .product-price {
        font-size: 22px;
        font-weight: 700;
        color: #e53935;
        margin-bottom: 20px;
    }

    .product-description {
        margin-bottom: 25px;
        line-height: 1.6;
        color: #555;
    }

    .product-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }

    .meta-item {
        font-size: 15px;
        color: #555;
    }

    .product-actions {
        margin-top: 30px;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .quantity-btn {
        width: 35px;
        height: 35px;
        background: #f5f5f5;
        border: 1px solid #ddd;
        font-size: 16px;
        cursor: pointer;
    }

    .quantity-input {
        width: 60px;
        height: 35px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 5px;
    }

    .add-to-cart-btn {
        background: #f8694a;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .add-to-cart-btn:hover {
        background: #e53935;
    }

    @media (max-width: 768px) {
        .product-detail-container {
            flex-direction: column;
        }

        .product-meta {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons functionality
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');
        const quantityInput = document.querySelector('.quantity-input');

        minusBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });

        plusBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value < parseInt(quantityInput.max)) {
                quantityInput.value = value + 1;
            }
        });

        // Thumbnail click functionality
        const thumbnails = document.querySelectorAll('.thumbnail-item img');
        const mainImage = document.querySelector('.main-image img');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                mainImage.src = this.src;
            });
        });
    });
</script>
@endsection
