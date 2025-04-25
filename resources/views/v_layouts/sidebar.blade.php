@extends('v_layouts.app')

@section('content')
<div class="dashboard-container">
    <h2>Welcome, {{ auth()->user()->nama }}</h2>
    <p>Ini adalah  sidebar</p>
    <!-- Tambahkan fitur dashboard customer di sini -->
</div>
@endsection
