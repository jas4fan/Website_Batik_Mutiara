<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Batik Mutiara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #8B4513; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 400px; border-radius: 15px; overflow: hidden; }
        .card-header { background-color: white; border-bottom: none; text-align: center; padding-top: 30px; }
        .btn-login { background-color: #8B4513; color: white; width: 100%; }
        .btn-login:hover { background-color: #A0522D; color: white; }
    </style>
</head>
<body>
    <div class="card login-card shadow-lg">
        <div class="card-header">
            <img src="https://via.placeholder.com/80?text=LOGO" alt="Logo" class="mb-2 rounded-circle">
            <h4 class="fw-bold text-dark">PT BATIK MUTIARA</h4>
            <p class="text-muted small">Sistem Informasi Penjualan</p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-login fw-bold mt-2">Login</button>
            </form>
        </div>
        <div class="card-footer text-center bg-light text-muted small py-3">
            &copy; 2025 PT Batik Mutiara
        </div>
    </div>
</body>
</html>