@extends('v_layouts.app')

@section('content')
<style>
    /* Wrapper untuk memastikan konten terpusat di tengah layar */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f4f4f4;
    }

    /* Kotak form login */
    .login-box {
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    /* Menambahkan spasi di antara elemen form */
    .login-box h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    /* Group input fields */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-top: 5px;
    }

    .form-group .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

    /* Button login styling */
    .login-btn {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .login-btn:hover {
        background-color: #0056b3;
    }

    /* Responsive design: Menyesuaikan layout di layar kecil */
    @media (max-width: 480px) {
        .login-box {
            padding: 20px;
        }

        .login-box h2 {
            font-size: 20px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-box">
        <h2>Login sebagai Customer</h2>
        <form action="{{ route('customer.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</div>
@endsection
