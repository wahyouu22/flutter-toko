<header>
    <!-- top Header -->
    <div id="top-header">
        <div class="container">
            <div class="pull-left">
                <span>Selamat datang di toko online</span>
            </div>
        </div>
    </div>
    <!-- /top Header -->

    <!-- header -->
    <div id="header">
        <div class="container">
            <div class="pull-left">
                <!-- Logo -->
                <div class="header-logo">
                    <a class="logo" href="#">
                        <img src="{{ asset('image/logo.png') }}" alt="">
                    </a>
                </div>
                <!-- /Logo -->

                <!-- Search -->

                <!-- /Search -->
            </div>
            <div class="pull-right">
                <ul class="header-btns">
                    <!-- Cart -->
                    <li class="header-cart dropdown default-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <strong class="text-uppercase">Keranjang</strong>
                        </a>
                    </li>
                    <!-- /Cart -->

                    <!-- Account -->
                    <li class="header-account dropdown default-dropdown">
                        <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            @if(auth()->check() && auth()->user()->role == 2)
                                <strong class="text-uppercase">{{ auth()->user()->nama }} <i class="fa fa-caret-down"></i></strong>
                            @else
                                <strong class="text-uppercase">Akun Saya <i class="fa fa-caret-down"></i></strong>
                            @endif
                        </div>
                        @if(auth()->check() && auth()->user()->role == 2)
                            <!-- Tidak menampilkan link Login jika user role 2 sudah login -->
                        @else
                            <a href="{{ route('auth.google') }}" class="text-uppercase">Login</a>
                        @endif
                        <ul class="custom-menu">
                            <li><a href="#"><i class="fa fa-user-o"></i> My Account</a></li>
                            <li><a href="#"><i class="fa fa-heart-o"></i> My Wishlist</a></li>
                            <li><a href="#"><i class="fa fa-exchange"></i> Compare</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Checkout</a></li>
                            @if(auth()->check() && auth()->user()->role == 2)
                                <!-- Tidak menampilkan Login dan Create Account jika user role 2 sudah login -->
                                <li><a href="{{ route('customer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a></li>
                                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="d-none">
                                    @csrf
                                </form>
                            @else
                                <li><a href="{{route('customer.login')}}"><i class="fa fa-unlock-alt"></i> Login</a></li>
                                <li><a href="{{ route('auth.google') }}"><i class="fa fa-user-plus"></i> Create An Account</a></li>
                            @endif
                        </ul>
                    </li>
                    <!-- /Account -->

                    <!-- Mobile nav toggle-->
                    <li class="nav-toggle">
                        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                    </li>
                    <!-- / Mobile nav toggle -->
                </ul>
            </div>
        </div>
        <!-- header -->
    </div>
    <!-- container -->
</header>
