@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Daftar Produk</h3>
    
    <div class="d-flex gap-2">
        <form action="{{ route('produk.index') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Kode (cth: BTK001)..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
            <i class="fas fa-plus"></i> Tambah Produk
        </button>
    </div>
</div>

<div class="card p-4">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $produk)
            <tr>
                <td>BTK{{ str_pad($produk->id_produk, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->jenis_produk }}</td>
                <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                <td>{{ $produk->stok }}</td>
                <td>
                    <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editProduk{{ $produk->id_produk }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('produk.destroy', $produk->id_produk) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>

            <div class="modal fade" id="editProduk{{ $produk->id_produk }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3"><label>Nama Produk</label><input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required></div>
                                <div class="mb-3"><label>Jenis</label><input type="text" name="jenis_produk" class="form-control" value="{{ $produk->jenis_produk }}" required></div>
                                <div class="mb-3"><label>Harga</label><input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required></div>
                                <div class="mb-3"><label>Stok</label><input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required></div>
                            </div>
                            <div class="modal-footer"><button type="submit" class="btn btn-primary-custom">Simpan</button></div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambahProduk" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('produk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3"><label>Nama Produk</label><input type="text" name="nama_produk" class="form-control" required></div>
                    <div class="mb-3"><label>Jenis</label>
                        <select name="jenis_produk" class="form-select">
                            <option value="Batik Tulis">Batik Tulis</option>
                            <option value="Batik Cap">Batik Cap</option>
                            <option value="Batik Printing">Batik Printing</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Harga</label><input type="number" name="harga" class="form-control" required></div>
                    <div class="mb-3"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary-custom">Simpan</button></div>
            </form>
        </div>
    </div>
</div>
@endsection