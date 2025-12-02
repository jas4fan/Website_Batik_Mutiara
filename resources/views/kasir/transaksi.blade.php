@extends('layouts.app')
@section('title', 'Transaksi Kasir')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h4 class="mb-0 fw-bold text-primary-custom">Pilih Produk</h4>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    @foreach($produks as $produk)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 shadow-sm border-0 product-card">
                            <div class="card-body text-center d-flex flex-column">
                                <h6 class="fw-bold">{{ $produk->nama_produk }}</h6>
                                <p class="text-muted small mb-1">{{ $produk->jenis_produk }}</p>
                                <h5 class="text-primary fw-bold mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h5>
                                <div class="mt-auto">
                                    <form action="{{ route('kasir.transaksi.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                        <button type="submit" class="btn btn-outline-dark w-100 btn-sm">
                                            <i class="fas fa-cart-plus"></i> Tambah
                                        </button>
                                    </form>
                                    <small class="text-muted">Stok: {{ $produk->stok }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-primary-custom">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Keranjang</h5>
            </div>
            <div class="card-body d-flex flex-column">
                @if(session('cart'))
                    <div class="table-responsive flex-grow-1" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-sm table-borderless">
                            <thead class="border-bottom">
                                <tr>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(session('cart') as $id => $details)
                                <tr>
                                    <td>{{ $details['nama_produk'] }}<br>
                                        <small class="text-muted">@ {{ number_format($details['harga']/1000, 0) }}k</small>
                                    </td>
                                    <td class="align-middle">{{ $details['qty'] }}</td>
                                    <td class="align-middle text-end">
                                        {{ number_format($details['harga'] * $details['qty'], 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle text-end">
                                        <a href="{{ route('kasir.transaksi.delete', $id) }}" class="text-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center my-5 text-muted">
                        <i class="fas fa-shopping-basket fa-3x mb-3"></i>
                        <p>Keranjang masih kosong</p>
                    </div>
                @endif
                
                <div class="mt-auto border-top pt-3">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="h5">Total</span>
                        <span class="h4 fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <form action="{{ route('kasir.transaksi.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small text-muted">Metode Pembayaran</label>
                            <select class="form-select form-select-sm">
                                <option>Cash</option>
                                <option>QRIS</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-bold" 
                            {{ empty($cart) ? 'disabled' : '' }}>
                            PROSES TRANSAKSI
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-primary-custom { color: #8B4513; }
    .border-primary-custom { border-color: #8B4513; }
    .bg-primary { background-color: #8B4513 !important; }
</style>
@endsection