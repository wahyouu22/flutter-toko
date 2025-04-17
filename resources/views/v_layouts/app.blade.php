<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_univ_bsi.png') }}">
    <title>TokoOnline</title>

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <!-- Tambahan CSS untuk toggle dan posisi nav -->
    <style>
        .d-none {
            display: none !important;
        }
        #navigation {
            margin-top: -10px;
        }
        .menu-nav {
            margin-left: auto;
        }
        .category-nav {
            margin-right: auto;
        }
        @media (max-width: 768px) {
            .menu-nav, .category-nav {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    @php
        $kategori = DB::table('kategori')->orderBy('nama_kategori', 'asc')->get();
    @endphp

    <!-- HEADER -->
    <header>
        <div id="top-header">
            <div class="container">
                <div class="pull-left">
                    <span>Selamat datang di Toko Online</span>
                </div>
            </div>
        </div>

        <div id="header">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="header-logo">
                    <a class="logo" href="{{ route('beranda') }}">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo">
                    </a>
                </div>
                <ul class="header-btns d-flex list-unstyled mb-0">
                    <li class="header-cart dropdown default-dropdown me-3">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon"><i class="fa fa-shopping-cart"></i></div>
                            <strong class="text-uppercase">Keranjang</strong>
                        </a>
                    </li>
                    <li class="header-account dropdown default-dropdown me-3">
                        <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon"><i class="fa fa-user-o"></i></div>
                            <strong class="text-uppercase">Akun Saya <i class="fa fa-caret-down"></i></strong>
                        </div>
                        <a href="{{ route('auth.redirect') }}" class="text-uppercase">Login</a>
                    </li>
                    <li class="nav-toggle">
                        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <div id="navigation">
        <div class="container">
            <div id="responsive-nav" class="d-flex align-items-start">
                <div class="category-nav me-4">
                    <span class="category-header" id="toggleKategori">Kategori <i class="fa fa-list"></i></span>
                    <ul class="category-list {{ request()->segment(1) == '' || request()->segment(1) == 'beranda' ? '' : 'd-none' }}" id="kategoriList">
                        @foreach ($kategori as $row)
                            <li><a href="{{ route('produk.kategori', $row->id) }}">{{ $row->nama_kategori }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="menu-nav">
                    <ul class="menu-list d-flex list-unstyled mb-0">
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li><a href="{{ route('produk.all') }}">Produk</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /NAVIGATION -->

    <!-- BANNER -->
    @if (request()->segment(1) == '' || request()->segment(1) == 'beranda')
    <div id="home">
        <div class="container">
            <div class="home-wrap">
                <div id="home-slick">
                    <div class="banner banner-1">
                        <img src="{{ asset('frontend/banner/banner_1.jpg') }}" alt="">
                        <div class="banner-caption text-center">
                            <h1>Jajanan Tradisional</h1>
                            <h3 class="font-weak" style="color: #30323a;">Khas Makanan Indonesia</h3>
                            <button class="primary-btn">Pesan Sekarang</button>
                        </div>
                    </div>
                    <div class="banner banner-1">
                        <img src="{{ asset('frontend/banner/banner_2.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="primary-color">Cita Rasa Nusantara</h1>
                            <button class="primary-btn">Lihat Menu</button>
                        </div>
                    </div>
                    <div class="banner banner-1">
                        <img src="{{ asset('frontend/banner/banner_3.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 style="color: #f8694a;">Makanan Indonesia</h1>
                            <button class="primary-btn">Coba Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- /BANNER -->

    <!-- CONTENT -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div id="main" class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- /CONTENT -->

    <!-- FOOTER -->
    <footer id="footer" class="section section-grey">
        <div class="container">
            <div class="row text-center">
                <p>&copy; {{ date('Y') }} TokoOnline. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JS Plugins -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <!-- Script toggle kategori -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById("toggleKategori");
            const list = document.getElementById("kategoriList");

            if (toggle && list) {
                toggle.addEventListener("click", function () {
                    list.classList.toggle("d-none");
                });
            }
        });
    </script>
</body>
</html>
