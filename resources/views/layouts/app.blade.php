<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Unit IT - Digitalisasi Pelayanan')</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #ffffff; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 75px; 
        }

        main { flex: 1; }

        footer { 
            background: white; 
            padding: 20px 0; 
            border-top: 1px solid #dee2e6; 
        }

        /* --- Efek Navbar --- */
        .navbar { 
            box-shadow: 0 2px 15px rgba(0,0,0,0.1); 
            z-index: 1030;
            transition: all 0.3s ease;
            background-color: #0061ff;
            padding: 12px 0;
        }

        /* Nav Link Biasa */
        .navbar-nav .nav-link:not(.btn-login):not(.btn-register) {
            position: relative;
            padding: 8px 15px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* Garis bawah kuning */
        .navbar-nav .nav-link:not(.btn-login):not(.btn-register)::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #ffc107;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:not(.btn-login):not(.btn-register):hover::after,
        .navbar-nav .nav-link.active:not(.btn-login):not(.btn-register)::after {
            width: 70%;
        }

        .navbar-nav .nav-link:not(.btn-login):not(.btn-register):hover,
        .navbar-nav .nav-link.active:not(.btn-login):not(.btn-register) {
            color: #ffffff !important;
        }

        /* --- Styling Tombol Login --- */
        .navbar-nav .nav-item .btn-login {
            background-color: #ffffff !important;
            color: #0061ff !important;
            border-radius: 10px;
            padding: 6px 18px !important;
            margin-left: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: none;
            display: inline-block;
            font-weight: 700;
        }

        .navbar-nav .nav-item .btn-login:hover {
            background-color: #f1f2f6 !important;
            transform: translateY(-2px);
        }

        /* --- Styling Tombol Daftar --- */
        .navbar-nav .nav-item .btn-register {
            background-color: transparent !important;
            color: #ffffff !important;
            border: 2px solid #ffffff !important;
            border-radius: 10px;
            padding: 6px 18px !important;
            margin-left: 10px;
            transition: all 0.3s ease;
            display: inline-block;
            font-weight: 700;
        }

        .navbar-nav .nav-item .btn-register:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
            transform: translateY(-2px);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 10px;
        }

        @stack('styles')
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center me-4" href="{{ url('/') }}">
                <i class="bi bi-cpu-fill me-2"></i> UNIT IT
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Menu -->
                <ul class="navbar-nav me-auto fw-semibold align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('layanan/pengaduan*') ? 'active' : '' }}" href="{{ route('pengaduan.create') }}">
                            Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('galeri*') ? 'active' : '' }}" href="{{ route('galeri.index') }}">
                            Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link {{ Request::is('tentang*') ? 'active' : '' }}" href="{{ route('tentangs.tentang') }}">
                             Tentang
                        </a>
                    </li>
                </ul>

                <!-- Right Menu (Auth) -->
                <ul class="navbar-nav ms-auto fw-semibold align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link btn-login" href="{{ url('/login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-register" href="{{ url('/register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person me-2"></i> Akun Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center" style="border: none; background: none; width: 100%;">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0 text-muted">
                &copy; {{ date('Y') }} Unit ICT. Digitalisasi Pelayanan Publik Berbasis Laravel.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>