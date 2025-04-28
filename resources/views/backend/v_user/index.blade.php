@extends('backend.v_layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <a href="{{ route('backend.user.create') }}">
            <button type="button" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah User
            </button>
        </a>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">{{ $judul }}</h5>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role == 1)
                                        <span class="badge badge-success">Super Admin</span>
                                    @else
                                        <span class="badge badge-primary">Customer</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->status == 1)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Non Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->foto)
                                        <img src="{{ asset('storage/img-user/' . $user->foto) }}" alt="Foto Profil" width="50" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.user.edit', $user->id) }}" title="Ubah Data" class="btn btn-cyan btn-sm">
                                        <i class="far fa-edit"></i> Ubah
                                    </a>

                                    <form method="POST" action="{{ route('backend.user.destroy', $user->id) }}" style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $user->nama }}" title="Hapus Data">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
