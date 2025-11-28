@extends('layouts.app')
@section('title', 'Edit Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">Edit Transaksi: {{ $penjualan->no_invoice }}</div>
            <div class="card-body">
                <form action="{{ route('admin.penjualan.update', $penjualan->id_penjualan) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label>Kasir</label>
                        <input type="text" class="form-control" value="{{ $penjualan->kasir->nama_kasir ?? '-' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Transaksi</label>
                        <input type="date" name="tanggal_penjualan" class="form-control" value="{{ $penjualan->tanggal_penjualan }}">
                    </div>

                    <h5 class="mt-4">Detail Produk</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->details as $detail)
                            <tr>
                                <td>{{ $detail->produk->nama_produk ?? 'Produk dihapus' }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">Total</th>
                                <th>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle"></i> Saat ini Admin hanya diizinkan mengubah Tanggal Transaksi atau Menghapus Transaksi (Void) untuk menjaga integritas stok.
                    </div>

                    <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                    <a href="{{ route('admin.penjualan') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection