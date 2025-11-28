@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Dashboard</h2>
        <p class="text-muted">Ringkasan pendapatan toko hari ini.</p>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-white p-3 mb-3 border-start border-5 border-primary">
            <h6 class="text-muted">Pendapatan Hari Ini</h6>
            <h3 class="fw-bold text-primary">Rp {{ number_format($incomeToday, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-white p-3 mb-3 border-start border-5 border-success">
            <h6 class="text-muted">Pendapatan Bulan Ini</h6>
            <h3 class="fw-bold text-success">Rp {{ number_format($incomeMonth, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-white p-3 mb-3 border-start border-5 border-warning">
            <h6 class="text-muted">Pendapatan Tahun Ini</h6>
            <h3 class="fw-bold text-warning">Rp {{ number_format($incomeYear, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-white p-3 mb-3 border-start border-5 border-info">
            <h6 class="text-muted">Total Transaksi</h6>
            <h3 class="fw-bold text-info">{{ $totalTransaksi }}</h3>
        </div>
    </div>
</div>
@endsection