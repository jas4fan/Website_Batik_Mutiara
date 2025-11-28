@extends('layouts.app')
@section('title', 'Rekap Penjualan Saya')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-white p-4 border-start border-5 border-primary">
            <h6 class="text-muted">Total Transaksi Saya</h6>
            <h3 class="fw-bold">{{ $totalTransaksi }}</h3>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-white p-4 border-start border-5 border-success">
            <h6 class="text-muted">Total Pendapatan Saya</h6>
            <h3 class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="card p-4">
    <h5 class="mb-3">Daftar Riwayat Transaksi</h5>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualans as $p)
                <tr>
                    <td>{{ $p->no_invoice }}</td>
                    <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td class="fw-bold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-success">Berhasil</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection