<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Digital</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f9f4;
            font-family: 'Segoe UI', sans-serif;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #2e7d32;
        }
        .hero h1 {
            font-weight: bold;
        }
        .btn-green {
            background-color: #2e7d32;
            color: white;
        }
        .btn-green:hover {
            background-color: #256528;
            color: white;
        }
        footer {
            background: #2e7d32;
            color: white;
            padding: 15px;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <div class="hero container">
        <div>
            <i class="fas fa-recycle fa-4x mb-3"></i>
            <h1>Selamat Datang di <br> Bank Sampah Asri</h1>
            <p class="lead mt-3">Kelola setoran sampah, tarik dana, dan pantau saldo Anda secara mudah & transparan.</p>
            <div class="mt-4">
                <a href="{{ url('/login') }}" class="btn btn-green btn-lg me-2">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ url('/register') }}" class="btn btn-outline-success btn-lg">
                    <i class="fas fa-user-plus"></i> Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <p>&copy; {{ date('Y') }} Bank Sampah Digital. Semua Hak Dilindungi.</p>
    </footer>

</body>
</html>
