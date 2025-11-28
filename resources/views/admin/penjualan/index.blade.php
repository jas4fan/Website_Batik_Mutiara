@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Laporan Penjualan Seluruh Kasir</h3>
    
    <form action="{{ route('admin.penjualan') }}" method="GET" class="d-flex" style="width: 300px;">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari No. Invoice..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
</div>

<div class="card p-4 mt-3">
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualans as $p)
            <tr>
                <td>{{ $p->no_invoice }}</td>
                <td>{{ $p->tanggal_penjualan }}</td>
                <td>{{ $p->kasir->nama_kasir ?? 'Kasir Terhapus' }}</td>
                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('admin.penjualan.edit', $p->id_penjualan) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.penjualan.destroy', $p->id_penjualan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection