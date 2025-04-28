<div id="aside" class="col-md-3 custom-sidebar">
    <!-- TOP RATED PRODUCTS -->
    <div class="custom-sidebar-widget">
        <h3 class="custom-widget-title">TOP RATED PRODUCT</h3>

        <div class="custom-product-widget">
            <div class="custom-product-thumb">
                <img src="{{ asset('frontend/img/thumb-product01.jpg') }}" alt="Product">
            </div>
            <div class="custom-product-details">
                <a href="#" class="custom-product-name">Product Name Goes Here</a>
                <div class="custom-product-price">
                    $32.50 <span class="custom-old-price">$45.00</span>
                </div>
                <div class="custom-product-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                </div>
            </div>
        </div>

        <div class="custom-product-widget">
            <div class="custom-product-thumb">
                <img src="{{ asset('frontend/img/thumb-product01.jpg') }}" alt="Product">
            </div>
            <div class="custom-product-details">
                <a href="#" class="custom-product-name">Product Name Goes Here</a>
                <div class="custom-product-price">$32.50</div>
                <div class="custom-product-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- BRAND FILTER -->
    <div class="custom-sidebar-widget">
        <h3 class="custom-widget-title">FILTER BY BRAND</h3>
        <ul class="custom-brand-list">
            <li><a href="#">NIKE</a></li>
            <li><a href="#">ADIDAS</a></li>
            <li><a href="#">POLO</a></li>
            <li><a href="#">LACOST</a></li>
        </ul>
    </div>
</div>

<style>
    /* Custom Sidebar - Won't affect other elements */
    .custom-sidebar {
        padding-left: 10px;
        padding-right: 15px;
    }

    .custom-sidebar-widget {
        margin-bottom: 25px;
        background: #ffffff;
        padding: 15px;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .custom-widget-title {
        font-size: 15px;
        font-weight: 700;
        text-transform: uppercase;
        color: #333333;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eeeeee;
        letter-spacing: 0.5px;
    }

    .custom-product-widget {
        display: flex;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f5f5f5;
    }

    .custom-product-widget:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .custom-product-thumb {
        width: 50px;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .custom-product-thumb img {
        width: 100%;
        height: auto;
        border-radius: 3px;
    }

    .custom-product-details {
        flex-grow: 1;
    }

    .custom-product-name {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #333333;
        margin-bottom: 3px;
        line-height: 1.3;
    }

    .custom-product-name:hover {
        color: #e53935;
        text-decoration: none;
    }

    .custom-product-price {
        font-size: 13px;
        font-weight: 700;
        color: #e53935;
        margin-bottom: 3px;
    }

    .custom-old-price {
        font-size: 11px;
        color: #999999;
        text-decoration: line-through;
        margin-left: 5px;
    }

    .custom-product-rating {
        color: #FFC107;
        font-size: 11px;
        letter-spacing: 1px;
    }

    .custom-product-rating .fa-star-o {
        color: #dddddd;
    }

    .custom-brand-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .custom-brand-list li {
        margin-bottom: 7px;
    }

    .custom-brand-list li:last-child {
        margin-bottom: 0;
    }

    .custom-brand-list a {
        display: block;
        font-size: 12px;
        color: #555555;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 5px 0;
        transition: all 0.2s;
    }

    .custom-brand-list a:hover {
        color: #e53935;
        padding-left: 3px;
        text-decoration: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .custom-sidebar {
            padding-left: 15px;
            padding-right: 15px;
        }

        .custom-product-widget {
            flex-direction: column;
        }

        .custom-product-thumb {
            width: 100%;
            margin-right: 0;
            margin-bottom: 10px;
        }
    }
</style>
