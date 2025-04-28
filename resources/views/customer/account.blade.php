@extends('v_layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">AKUN CUSTOMER</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span>{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data" id="account-form">
                        @csrf
                        <div class="row g-4">
                            <!-- Foto Profil Column -->
                            <div class="col-md-4">
                                <div class="d-flex flex-column h-100">
                                    <label class="form-label">Foto</label>
                                    <div class="border p-2 mb-2 text-center" style="height: 180px; cursor: pointer;" id="drop-area">
                                        <img id="foto-preview"
                                             src="{{ $customer->foto ? Storage::url($customer->foto) : 'https://via.placeholder.com/150?text=No+Foto' }}"
                                             alt="Foto Profil"
                                             class="img-fluid rounded h-100"
                                             style="object-fit: contain;">
                                    </div>

                                    <div class="mb-2">
                                        <input type="file" name="foto" class="form-control form-control-sm @error('foto') is-invalid @enderror" id="foto-input" accept="image/*">
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if($customer->foto)
                                        <div class="mt-auto">
                                            <a href="{{ route('account.delete-foto') }}" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus foto?')">Hapus Foto</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Form Column -->
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <!-- Nama -->
                                    <div class="col-12">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Nama diambil dari akun Google Anda</small>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" readonly>
                                        <small class="text-muted">Email tidak dapat diubah</small>
                                    </div>

                                    <!-- HP -->
                                    <div class="col-md-6">
                                        <label for="hp" class="form-label">HP</label>
                                        <input type="text" class="form-control @error('hp') is-invalid @enderror" id="hp" name="hp" value="{{ old('hp', $customer->hp) }}">
                                        @error('hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Kode Pos -->
                                    <div class="col-md-6">
                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $customer->pos) }}">
                                        @error('kode_pos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Alamat -->
                                    <div class="col-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2">{{ old('alamat', $customer->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if($showPasswordReminder)
                                    <!-- Password Baru -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <small class="text-muted">Ubah password setelah akun dibuat, maksimal 1 hari setelah dibuat.</small>
                                    </div>
                                    @endif

                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-danger w-100">SIMPAN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('foto-input');
    const fotoPreview = document.getElementById('foto-preview');
    const dropArea = document.getElementById('drop-area');

    // Handle file selection
    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.match('image.*')) {
            previewImage(file);
        }
    });

    // Handle drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropArea.classList.add('border-primary');
    }

    function unhighlight() {
        dropArea.classList.remove('border-primary');
    }

    dropArea.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];

        if (file && file.type.match('image.*')) {
            fotoInput.files = dt.files; // Assign the file to input
            previewImage(file);
        }
    });

    // Click on drop area triggers file input
    dropArea.addEventListener('click', function() {
        fotoInput.click();
    });

    function previewImage(file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            fotoPreview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }
});
</script>

<style>
#drop-area {
    transition: border-color 0.2s ease;
}
#drop-area:hover {
    border-color: #0d6efd !important;
}

/* Make the form more compact */
.card {
    max-width: 1000px;
    margin: 0 auto;
}
.card-body {
    padding: 1.5rem;
}
.form-control, .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
}
</style>
@endsection
