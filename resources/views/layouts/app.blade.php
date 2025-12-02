<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT BATIK MUTIARA - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #8B4513; 
            --secondary-color: #D2691E;
            --light-bg: #FFF8DC; 
        }
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: var(--primary-color);
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            color: white;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">PT BATIK MUTIARA</a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    {{-- Cek Apakah Login sebagai ADMIN --}}
                    @if(Auth::guard('admin')->check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.kasir.index') }}">Kasir</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('produk.index') }}">Produk</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.penjualan') }}">Laporan</a></li>
                    
                    {{-- Jika BUKAN Admin, Cek Apakah Login sebagai KASIR --}}
                    @elseif(Auth::guard('kasir')->check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasir.transaksi') }}">Transaksi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasir.produk.index') }}">Kelola Produk</a></li> 
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasir.riwayat') }}">Riwayat Penjualan</a></li>
                    @endif

                    {{-- Tombol Logout --}}
                    @if(Auth::guard('admin')->check() || Auth::guard('kasir')->check())
                        <li class="nav-item ms-3">
                            <a href="{{ route('logout') }}" class="btn btn-warning btn-sm fw-bold">Logout</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>