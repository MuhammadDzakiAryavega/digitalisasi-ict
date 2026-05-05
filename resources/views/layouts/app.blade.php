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
        }

        main { flex: 1; }

        /* --- Efek Navbar --- */
        .navbar { 
            box-shadow: 0 2px 15px rgba(0,0,0,0.1); 
            z-index: 1030;
            transition: all 0.3s ease;
            background-color: #0061ff;
            padding: 12px 0;
        }

        .navbar-nav .nav-link:not(.btn-login):not(.btn-register) {
            position: relative;
            padding: 8px 15px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.8) !important;
        }

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

        /* --- STYLING FOOTER BARU --- */
        .app-footer {
            background-color: #0f172a; /* Biru gelap menyesuaikan tema IT */
            color: #cbd5e1;
            position: relative;
            margin-top: 80px; /* Memberi ruang untuk banner melayang */
            padding-top: 60px;
        }

        /* Banner Bantuan Mendesak */
        .footer-banner-wrapper {
            position: absolute;
            top: -45px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 10;
        }

        .footer-banner {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 20px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.1rem;
            width: 90%;
            max-width: 1000px;
        }

        .footer-banner .badge-darurat {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Konten Footer */
        .app-footer h5 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .footer-logo i {
            color: #0061ff;
            background: white;
            padding: 8px;
            border-radius: 8px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .footer-links a i {
            font-size: 0.8rem;
            margin-right: 8px;
            color: #0061ff;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
            transform: translateX(5px);
        }

        .footer-links a:hover i {
            color: #ffc107;
        }

        /* Kontak & Nomor Penting */
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .contact-item i {
            font-size: 1.2rem;
            color: #3b82f6;
            margin-top: 3px;
        }

        .important-numbers .number-box {
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.3s ease;
        }

        .important-numbers .number-box:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .important-numbers .number-box span {
            font-weight: 700;
            color: #ffffff;
        }

        /* Social Media */
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-radius: 8px;
            margin-right: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-links a:hover {
            background-color: #0061ff;
            transform: translateY(-3px);
        }

        /* Footer Bottom */
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 25px 0;
            margin-top: 40px;
            font-size: 0.9rem;
        }

        .footer-bottom-links a {
            color: #cbd5e1;
            text-decoration: none;
            margin-left: 15px;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: #ffffff;
        }

        @media (max-width: 991px) {
            .footer-banner { flex-direction: column; text-align: center; }
            .app-footer { padding-top: 100px; }
        }

        @stack('styles')
    </style>
</head>
<body>

    <!-- Navbar (Sama seperti sebelumnya) -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center me-4" href="{{ url('/') }}">
                <i class="bi bi-cpu-fill me-2"></i> UNIT IT
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto fw-semibold align-items-center">
                    <li class="nav-item"><a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is('layanan/pengaduan*') ? 'active' : '' }}" href="{{ route('pengaduan.create') }}">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is('galeri*') ? 'active' : '' }}" href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is('tentang*') ? 'active' : '' }}" href="{{ route('tentangs.tentang') }}">Tentang</a></li>
                </ul>

                <ul class="navbar-nav ms-auto fw-semibold align-items-center">
                    @guest
                        <li class="nav-item"><a class="nav-link btn-login" href="{{ url('/login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn-register" href="{{ url('/register') }}">Daftar</a></li>
                    @else
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Akun Saya</a></li>
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
    <main style="padding-top: 80px;"> <!-- Menambahkan padding atas agar konten tidak tertutup navbar fixed -->
        @yield('content')
    </main>

    <!-- FOOTER BARU -->
    <footer class="app-footer">

        <div class="container">
            <div class="row gy-5">
                
                <!-- Kolom 1: Profil Unit IT -->
                <div class="col-lg-4 col-md-6 pe-lg-4">
                    <h4 class="text-white fw-bold d-flex align-items-center mb-3 footer-logo">
                        <i class="bi bi-cpu-fill me-2"></i> Unit IT
                    </h4>
                    <p class="mb-4 text-secondary" style="line-height: 1.6;">
                        Mewujudkan pelayanan digitalisasi yang cepat, modern, transparan, dan akuntabel berbasis teknologi informasi untuk seluruh sivitas akademika.
                    </p>
                    <div class="contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>Plaza Lantai 2, Kelurahan Indarung, Indarung, Kec. Lubuk Kilangan, Kota Padang, Sumatera Barat 25157</div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-envelope-at-fill"></i>
                        <div>it.support@institusi.ac.id</div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-whatsapp"></i>
                        <div>+62 812-3456-7890 (Chat Only)</div>
                    </div>
                </div>

                <!-- Kolom 2: Menu Utama -->
                <div class="col-lg-2 col-md-6">
                    <h5>Menu Utama</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="bi bi-chevron-right"></i> Beranda</a></li>
                        <li><a href="{{ route('pengaduan.create') }}"><i class="bi bi-chevron-right"></i>Buat Pengaduan</a></li>
                        <li><a href="{{ route('galeri.index') }}"><i class="bi bi-chevron-right"></i>Berita & Info</a></li>
                        <li><a href="{{ route('tentangs.tentang') }}"><i class="bi bi-chevron-right"></i>Tentang</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Layanan IT -->
                <div class="col-lg-3 col-md-6">
                    <h5>Layanan IT</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('pengaduan.create') }}"><i class="bi bi-chevron-right"></i> Sistem Pengaduan (Ticketing)</a></li>
                        <li><a href="{{ route('pengaduan.create') }}"><i class="bi bi-chevron-right"></i> Pengajuan Akun Email</a></li>
                        <li><a href="{{ route('pengaduan.create') }}"><i class="bi bi-chevron-right"></i> Instalasi Jaringan & WiFi</a></li>
                        <li><a href="{{ route('pengaduan.create') }}"><i class="bi bi-chevron-right"></i> Hosting & Subdomain</a></li>
                        <li><a href="{{ route('pengaduan.create') }}"><i class="bi bi-chevron-right"></i> Perbaikan Hardware</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Nomor Penting & Sosial Media -->
                <div class="col-lg-3 col-md-6">
                    <h5>Kontak Darurat IT</h5>
                    <div class="important-numbers mb-4">
                        <div class="number-box">
                            <div>Tim Jaringan</div>
                            <span>(0751) 12345</span>
                        </div>
                        <div class="number-box">
                            <div>Tim Software</div>
                            <span>(0751) 12346</span>
                        </div>
                        <div class="number-box">
                            <div>Helpdesk Pusat</div>
                            <span>(0823) 1111-2222</span>
                        </div>
                    </div>

                    <h5 class="mb-3">Ikuti Kami</h5>
                    <div class="social-links">
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

            </div>

            <!-- Bagian Hak Cipta -->
            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center">
                <div class="mb-3 mb-md-0">
                    &copy; {{ date('Y') }} <strong>Unit IT</strong>. Hak Cipta Dilindungi.
                </div>
                <div class="footer-bottom-links">
                    <a href="">Kebijakan Privasi</a>
                    <a href="">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>