@extends('layouts.app')

@section('title', 'Manajemen Kasir')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Manajemen Kasir</h3>
    
    <div class="d-flex gap-2">
        <form action="{{ route('admin.kasir.index') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Username..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
        
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus"></i> Tambah Kasir
        </button>
    </div>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kasirs as $key => $kasir)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $kasir->nama_kasir }}</td>
                    <td>{{ $kasir->username }}</td>
                    <td><span class="badge bg-success">Aktif</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning text-white" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEdit{{ $kasir->id_kasir }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.kasir.destroy', $kasir->id_kasir) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kasir ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit{{ $kasir->id_kasir }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Kasir</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.kasir.update', $kasir->id_kasir) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama_kasir" class="form-control" value="{{ $kasir->nama_kasir }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ $kasir->username }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password Baru (Opsional)</label>
                                        <input type="password" name="password" class="form-control" placeholder="Isi jika ingin ubah password">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kasir Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kasir.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_kasir" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary-custom">Tambah Kasir</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection