@extends('v_layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">KERANJANG BELANJA</h2>

        @if ($isEmpty)
            <div class="alert alert-info">
                <i class="fas fa-shopping-cart me-2"></i> Keranjang belanja Anda kosong.
                <a href="{{ route('produk.all') }}" class="alert-link">Mulai berbelanja</a>
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <!-- Produk Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>PRODUK</th>
                                    <th>HARGA</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if (isset($item->attributes['foto']) && $item->attributes['foto'])
                                                    <img src="{{ asset('storage/img-produk/thumb_lg_' . $item->attributes['foto']) }}"
                                                        alt="{{ $item->name }}" class="img-thumbnail me-3"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light me-3" style="width: 80px; height: 80px;"></div>
                                                @endif
                                                <div>
                                                    <h5 class="mb-1">{{ $item->name }}</h5>
                                                    <p class="mb-1 small text-muted">Berat:
                                                        {{ ($item->attributes['berat'] ?? 0) * 1000 }} Gram</p>
                                                    <p class="mb-0 small text-muted">Stok:
                                                        {{ $item->attributes['stok'] ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="align-middle">
                                            <form action="{{ route('keranjang.update', $item->id) }}" method="POST"
                                                class="d-flex">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                    min="1" max="{{ $item->attributes['stok'] ?? 1 }}"
                                                    class="form-control me-2" style="width: 80px;">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="align-middle">Rp.
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                        <td class="align-middle">
                                            <form action="{{ route('keranjang.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    title="Hapus dari keranjang">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Belanja:</strong></td>
                                    <td colspan="2"><strong>Rp. {{ number_format($subTotal, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Berat:</strong></td>
                                    <td colspan="2"><strong>{{ $totalWeight }} Gram</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Shipping Calculation Form -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Hitung Ongkos Kirim</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('ongkir.calculate') }}" method="POST" id="shipping-calculation-form">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="origin" class="form-label">Kota Asal</label>
                                        <select class="form-select" id="origin" name="origin" required>
                                            <option value="">Pilih Kota Asal</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city['city_id'] }}"
                                                    {{ old('origin') == $city['city_id'] ? 'selected' : '' }}>
                                                    {{ $city['type'] }} {{ $city['city_name'] }}
                                                    ({{ $city['province'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('origin')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="destination-province" class="form-label">Provinsi Tujuan</label>
                                        <select class="form-select" id="destination-province" name="destination_province"
                                            required>
                                            <option value="">Pilih Provinsi</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province['province_id'] }}"
                                                    {{ old('destination_province') == $province['province_id'] ? 'selected' : '' }}>
                                                    {{ $province['province'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('destination_province')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        <label for="destination" class="form-label mt-2">Kota Tujuan</label>
                                        <select class="form-select" id="destination" name="destination" required>
                                            <option value="">Pilih Provinsi Terlebih Dahulu</option>
                                            @if (old('destination_province'))
                                                @foreach ($cities->where('province_id', old('destination_province')) as $city)
                                                    <option value="{{ $city['city_id'] }}"
                                                        {{ old('destination') == $city['city_id'] ? 'selected' : '' }}>
                                                        {{ $city['type'] }} {{ $city['city_name'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('destination')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Berat Total (gram)</label>
                                        <input type="number" class="form-control" id="weight" name="weight"
                                            value="{{ $totalWeight }}" required min="1" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="courier" class="form-label">Kurir</label>
                                        <select class="form-select" id="courier" name="courier" required>
                                            <option value="">Pilih Kurir</option>
                                            @foreach ($couriers as $key => $courier)
                                                <option value="{{ $key }}"
                                                    {{ old('courier') == $key ? 'selected' : '' }}>
                                                    {{ $courier }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('courier')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary" id="calculate-btn">
                                        <i class="fas fa-calculator me-2"></i> Hitung Ongkos Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table for Ongkir Result -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h3 class="card-title">Hasil Perhitungan Ongkos Kirim</h3>
                            <div class="table-responsive">
                                <table id="shipping-result-table" class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kurir</th>
                                            <th>Layanan</th>
                                            <th>Deskripsi</th>
                                            <th>Biaya (Rp)</th>
                                            <th>Estimasi (Hari)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($result))
                                            @foreach ($result['results'] as $courier)
                                                @foreach ($courier['costs'] as $service)
                                                    <tr>
                                                        <td>{{ $courier['name'] }}</td>
                                                        <td>{{ $service['service'] }}</td>
                                                        <td>{{ $service['description'] }}</td>
                                                        <td>Rp
                                                            {{ number_format($service['cost'][0]['value'], 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ str_replace(' HARI', '', $service['cost'][0]['etd']) }}</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm select-shipping-service"
                                                                data-cost="{{ $service['cost'][0]['value'] }}"
                                                                data-service="{{ $service['service'] }}"
                                                                data-courier="{{ $courier['name'] }}"
                                                                data-etd="{{ str_replace(' HARI', '', $service['cost'][0]['etd']) }}">
                                                                <i class="fas fa-check me-1"></i> Pilih
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">Silakan hitung ongkos kirim
                                                    terlebih dahulu.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card sticky-top" style="top: 20px;">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ringkasan Belanja</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('customer_name') is-invalid @enderror"
                                        name="customer_name" value="{{ old('customer_name', Auth::user()->name ?? '') }}"
                                        required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email"
                                        class="form-control @error('customer_email') is-invalid @enderror"
                                        name="customer_email"
                                        value="{{ old('customer_email', Auth::user()->email ?? '') }}" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('pos_code') is-invalid @enderror"
                                        name="pos_code" value="{{ old('pos_code') }}" required>
                                    @error('pos_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Harga:</span>
                                    <span>Rp {{ number_format($subTotal, 0, ',', '.') }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2 shipping-cost-row"
                                    style="{{ isset($shippingCost) ? '' : 'display:none;' }}">
                                    <span>Ongkos Kirim:</span>
                                    <span class="shipping-cost-value">
                                        @if (isset($shippingCost))
                                            Rp {{ number_format($shippingCost, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total Pembayaran:</span>
                                    <span class="total-payment">
                                        Rp {{ number_format($subTotal + ($shippingCost ?? 0), 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Hidden fields untuk data ongkir -->
                                <input type="hidden" name="shipping_cost" value="{{ $shippingCost ?? '' }}">
                                <input type="hidden" name="shipping_service" value="{{ $shippingService ?? '' }}">
                                <input type="hidden" name="shipping_etd" value="{{ $shippingEtd ?? '' }}">
                                <input type="hidden" name="destination_city" value="{{ $destinationCity ?? '' }}">

                                <button type="submit" class="btn btn-primary w-100 mt-3" id="checkout-btn"
    {{ (isset($shippingCost) && auth()->check()) ? '' : 'disabled' }}>
    <i class="fas fa-credit-card me-2"></i> Proses Checkout
</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Update destination options based on province
            $('#destination-province').change(function() {
                const provinceId = $(this).val();
                const $destination = $('#destination');

                if (provinceId) {
                    $destination.prop('disabled', true);
                    $destination.html('<option value="">Memuat data kota...</option>');

                    $.get(`/ongkir/cities/${provinceId}`, function(data) {
                        $destination.empty();
                        $destination.append('<option value="">Pilih Kota</option>');

                        $.each(data, function(index, city) {
                            $destination.append(
                                `<option value="${city.city_id}">${city.type} ${city.city_name}</option>`
                            );
                        });
                        $destination.prop('disabled', false);
                    }).fail(function() {
                        $destination.html('<option value="">Gagal memuat data</option>');
                    });
                } else {
                    $destination.empty().append('<option value="">Pilih Provinsi Terlebih Dahulu</option>');
                }
            });

            // AJAX untuk menghitung ongkos kirim tanpa reload halaman
            $('#shipping-calculation-form').submit(function(event) {
                event.preventDefault();

                const formData = $(this).serialize();
                const $submitBtn = $(this).find('button[type="submit"]');
                const $tableBody = $('#shipping-result-table tbody');

                // Show loading state
                $submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghitung...'
                    );
                $tableBody.html('<tr><td colspan="6" class="text-center">Memproses data...</td></tr>');

                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $tableBody.empty();

                        if (!response || !response.result) {
                            $tableBody.append(
                                '<tr><td colspan="6" class="text-center text-danger">Format respons tidak valid</td></tr>'
                                );
                            return;
                        }

                        const result = response.result;

                        if (!result.results || result.results.length === 0) {
                            $tableBody.append(
                                '<tr><td colspan="6" class="text-center">Tidak ada layanan pengiriman yang tersedia</td></tr>'
                                );
                            return;
                        }

                        $.each(result.results, function(index, courier) {
                            if (!courier.costs || courier.costs.length === 0) return;

                            $.each(courier.costs, function(i, service) {
                                if (!service.cost || service.cost.length === 0)
                                    return;

                                const cost = service.cost[0];
                                const serviceName = service.service;
                                const description = service.description;
                                const value = cost.value;
                                let etd = cost.etd.replace(' HARI', '');

                                $tableBody.append(
                                    `<tr>
                                <td>${courier.name}</td>
                                <td>${serviceName}</td>
                                <td>${description}</td>
                                <td>Rp ${value.toLocaleString('id-ID')}</td>
                                <td>${etd}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm select-shipping-service"
                                            data-cost="${value}"
                                            data-service="${serviceName}"
                                            data-courier="${courier.name}"
                                            data-etd="${etd}">
                                        <i class="fas fa-check me-1"></i> Pilih
                                    </button>
                                </td>
                            </tr>`
                                );
                            });
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat menghitung ongkos kirim';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $tableBody.empty().append(
                            `<tr><td colspan="6" class="text-center text-danger">${errorMessage}</td></tr>`
                            );
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html(
                            '<i class="fas fa-calculator me-2"></i> Hitung Ongkos Kirim');
                    }
                });
            });

            // Handle shipping service selection
            $(document).on('click', '.select-shipping-service', function() {
                const shippingCost = parseInt($(this).data('cost'));
                const serviceName = $(this).data('service');
                const courierName = $(this).data('courier');
                const etd = $(this).data('etd');
                const destinationCity = $('#destination option:selected').text();

                // Highlight selected row
                $(this).closest('tr').addClass('table-primary').siblings().removeClass('table-primary');

                // Update shipping cost display
                $('.shipping-cost-row').show();
                $('.shipping-cost-value').text('Rp ' + shippingCost.toLocaleString('id-ID'));

                // Update total payment
                const subTotal = {{ $subTotal }};
                const total = subTotal + shippingCost;
                $('.total-payment').text('Rp ' + total.toLocaleString('id-ID'));

                // Update hidden fields in checkout form
                $('#checkout-form input[name="shipping_cost"]').val(shippingCost);
                $('#checkout-form input[name="shipping_service"]').val(serviceName);
                $('#checkout-form input[name="shipping_etd"]').val(etd);
                $('#checkout-form input[name="destination_city"]').val(destinationCity);

                // Enable checkout button
                $('#checkout-btn').prop('disabled', false);

                // Show notification
                showToast(`Layanan ${courierName} - ${serviceName} dipilih`);
            });

            // Helper function to show toast notifications
            function showToast(message, type = 'success') {
                if ($('#toast-container').length === 0) {
                    $('body').append(
                        '<div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>'
                        );
                }

                const toastId = 'toast-' + Date.now();
                const toast = $(`
            <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `);

                $('#toast-container').append(toast);
                toast.toast({
                    delay: 3000
                }).toast('show');
            }
        });
    </script>
@endsection
