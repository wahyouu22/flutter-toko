<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ongkir Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .result-card {
            margin-top: 30px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .service-card {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <h1 class="text-center mb-4">Ongkir Calculator</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('ongkir.calculate') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="origin" class="form-label">Origin City</label>
                            <select class="form-select" id="origin" name="origin" required>
                                <option value="">Select Origin City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city['city_id'] }}"
                                        {{ isset($validated['origin']) && $validated['origin'] == $city['city_id'] ? 'selected' : '' }}>
                                        {{ $city['type'] }} {{ $city['city_name'] }} ({{ $city['province'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="destination-province" class="form-label">Destination Province</label>
                            <select class="form-select" id="destination-province" name="destination_province">
                                <option value="">Select Province First</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province['province_id'] }}"
                                        {{ isset($validated['destination_province']) && $validated['destination_province'] == $province['province_id'] ? 'selected' : '' }}>
                                        {{ $province['province'] }}
                                    </option>
                                @endforeach
                            </select>

                            <label for="destination" class="form-label mt-2">Destination City</label>
                            <select class="form-select" id="destination" name="destination" required>
                                <option value="">Select Province First</option>
                                @if(isset($validated['destination_province']))
                                    @foreach($cities->where('province_id', $validated['destination_province']) as $city)
                                        <option value="{{ $city['city_id'] }}"
                                            {{ $validated['destination'] == $city['city_id'] ? 'selected' : '' }}>
                                            {{ $city['type'] }} {{ $city['city_name'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="weight" class="form-label">Weight (gram)</label>
                            <input type="number" class="form-control" id="weight" name="weight"
                                   value="{{ $validated['weight'] ?? '' }}" required min="1">
                        </div>

                        <div class="col-md-4">
                            <label for="courier" class="form-label">Courier</label>
                            <select class="form-select" id="courier" name="courier" required>
                                <option value="">Select Courier</option>
                                @foreach($couriers as $key => $courier)
                                    <option value="{{ $key }}"
                                        {{ isset($validated['courier']) && $validated['courier'] == $key ? 'selected' : '' }}>
                                        {{ $courier }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Calculate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($result))
            <div class="result-card card mt-4">
                <div class="card-body">
                    <h3 class="card-title">Shipping Cost Result</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Origin:</strong>
                                {{ $result['origin_details']['type'] }} {{ $result['origin_details']['city_name'] }},
                                {{ $result['origin_details']['province'] }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Destination:</strong>
                                {{ $result['destination_details']['type'] }} {{ $result['destination_details']['city_name'] }},
                                {{ $result['destination_details']['province'] }}
                            </p>
                        </div>
                    </div>

                    <p><strong>Weight:</strong> {{ $validated['weight'] }} gram</p>
                    <p><strong>Courier:</strong> {{ $result['results'][0]['name'] }}</p>

                    <hr>

                    <h4 class="mt-3">Available Services:</h4>

                    @foreach($result['results'][0]['costs'] as $service)
                        <div class="service-card">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>{{ $service['service'] }}</h5>
                                    <p class="mb-1">{{ $service['description'] }}</p>
                                </div>
                                <div class="text-end">
                                    <h5>Rp {{ number_format($service['cost'][0]['value'], 0, ',', '.') }}</h5>
                                    <p class="mb-1">Est: {{ $service['cost'][0]['etd'] }} days</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#destination-province').change(function() {
                const provinceId = $(this).val();

                if (provinceId) {
                    $.get(`/ongkir/cities/${provinceId}`, function(data) {
                        const $destination = $('#destination');
                        $destination.empty();
                        $destination.append('<option value="">Select City</option>');

                        $.each(data, function(index, city) {
                            $destination.append(
                                `<option value="${city.city_id}">${city.type} ${city.city_name}</option>`
                            );
                        });
                    });
                } else {
                    $('#destination').empty().append('<option value="">Select Province First</option>');
                }
            });
        });
    </script>
</body>
</html>
