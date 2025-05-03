@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.produk.store') }}" method="post" enctype="multipart/form-data" id="produkForm">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <img id="foto-preview" class="foto-preview img-thumbnail mb-2" style="display: none;">
                                    <div class="upload-message">
                                        <p>Upload foto untuk preview image</p>
                                        <small class="text-muted">(Max size: 2MB, JPG/PNG/GIF)</small>
                                    </div>
                                    <input type="file" name="foto" id="foto-input" class="form-control @error('foto') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/gif" onchange="previewFoto()">
                                    @error('foto')
                                    <div class="invalid-feedback alert-danger d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <!-- Form lainnya tetap -->
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                        <option value="" selected>--Pilih Kategori--</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="form-control @error('nama_produk') is-invalid @enderror" placeholder="Masukkan Nama Produk">
                                    @error('nama_produk')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea name="detail" class="form-control @error('detail') is-invalid @enderror" id="ckeditor">{{ old('detail') }}</textarea>
                                    @error('detail')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="harga" value="{{ old('harga') }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga Produk" onkeypress="return hanyaAngka(event)">
                                    @error('harga')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Berat</label>
                                    <input type="text" name="berat" value="{{ old('berat') }}" class="form-control @error('berat') is-invalid @enderror" placeholder="Masukkan Berat Produk" onkeypress="return hanyaAngka(event)">
                                    @error('berat')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="text" name="stok" value="{{ old('stok') }}" class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan Stok Produk" onkeypress="return hanyaAngka(event)">
                                    @error('stok')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .foto-preview {
        max-width: 100%;
        max-height: 200px;
        margin-bottom: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('#ckeditor')) {
            ClassicEditor.create(document.querySelector('#ckeditor')).catch(error => console.error(error));
        }

        window.previewFoto = function () {
            const fileInput = document.getElementById('foto-input');
            const preview = document.getElementById('foto-preview');
            const file = fileInput.files[0];
            if (file) {
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Hanya file gambar (JPG, PNG, GIF) yang diperbolehkan');
                    fileInput.value = '';
                    preview.style.display = 'none';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB');
                    fileInput.value = '';
                    preview.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        };

        window.hanyaAngka = function(event) {
            const charCode = (event.which) ? event.which : event.keyCode;
            return !(charCode > 31 && (charCode < 48 || charCode > 57));
        }
    });
</script>
@endpush
