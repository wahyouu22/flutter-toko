@extends('backend.v_layouts.app')

@section('content')
<!-- contentAwal -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
                <h5 class="card-title">{{ $judul }}</h5>

                @php
                    $user = Auth::guard('user')->user();
                @endphp

                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">
                        Selamat Datang, {{ $user->nama ?? 'Guest' }}
                    </h4>

                    Aplikasi Toko Online dengan hak akses yang anda miliki sebagai
                    <b>
                        @if ($user && $user->role == 1)
                            Super Admin
                        @elseif ($user && $user->role == 0)
                            Admin
                        @else
                            Tidak Dikenal
                        @endif
                    </b>

                    ini adalah halaman utama dari aplikasi Web Programming. Studi Kasus Toko Online.

                    <hr>
                    <p class="mb-0">Kuliah..? BSI Aja !!!</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contentAkhir -->
@endsection
