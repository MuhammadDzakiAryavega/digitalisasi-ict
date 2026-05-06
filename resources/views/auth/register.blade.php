<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Unit IT</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;850&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }

        .brand-logo {
            color: #0061ff;
            font-weight: 850;
            font-size: 1.5rem;
            letter-spacing: -1px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 11px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0061ff;
            box-shadow: 0 0 0 4px rgba(0, 97, 255, 0.1);
        }

        .btn-primary {
            background-color: #0061ff;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0052d4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3);
        }

        .text-blue { color: #0061ff; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="auth-card">
        <a href="{{ url('/') }}" class="brand-logo">
            <i class="bi bi-cpu-fill me-2"></i> UNIT IT
        </a>
        
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="letter-spacing: -1px;">Daftar Akun</h2>
            <p class="text-muted">Lengkapi data untuk mulai menggunakan layanan</p>
        </div>

        <form action="{{ url('/register') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger py-2 small mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">DAFTAR SEKARANG</button>
            
            <div class="text-center mt-3">
                <p class="text-muted small">Sudah punya akun? <a href="{{ url('/login') }}" class="text-blue fw-bold text-decoration-none">Masuk di sini</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>