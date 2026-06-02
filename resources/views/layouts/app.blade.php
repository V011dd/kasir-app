<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">🧾 Sistem Kasir Warung Makan</a>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">
                <i class="bi bi-speedometer2"></i> Dashboard
            <a href="{{ route('produk.index') }}" class="btn btn-outline-light btn-sm me-2">
                <i class="bi bi-box"></i> Produk
            </a>
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-cart"></i> Transaksi
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>