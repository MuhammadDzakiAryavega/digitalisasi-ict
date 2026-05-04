<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title', 'Unit IT')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    {{-- Tambahan CDN React & Babel untuk Komponen Interaktif --}}
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    
    <style>
        :root {
            --primary-blue: #0061ff;
            --sidebar-width: 280px;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f0f2f5; 
            overflow-x: hidden;
        }

        /* --- Sidebar Styling --- */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-blue) 0%, #0046b8 100%);
            height: 100vh; 
            color: white;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto; 
        }

        #sidebar::-webkit-scrollbar {
            width: 5px;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0,0,0,0.15);
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 1.1rem;
        }

        #sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 14px 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        #sidebar .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        #sidebar .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #ffc107; 
            font-weight: 600;
        }

        /* --- Main Content Area --- */
        .main-content {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        .top-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 12px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        /* --- Tombol Logout --- */
        .nav-link-logout {
            background-color: #dc3545 !important; 
            color: #ffffff !important; 
            font-weight: 700 !important;
            margin: 20px;
            border-radius: 12px;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            transition: all 0.3s ease;
        }

        .nav-link-logout:hover {
            background-color: #bb2d3b !important;
            transform: translateY(-2px);
        }

        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                position: fixed;
            }
            #sidebar.active {
                margin-left: 0;
            }
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .bg-primary-subtle { background-color: #e0ebff !important; color: #0061ff !important; }
        .bg-danger-subtle { background-color: #ffe5e5 !important; color: #dc3545 !important; }

        @stack('styles')
    </style>
</head>
<body>

<div class="d-flex">
    <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center text-white">
            <i class="bi bi-cpu-fill me-2 fs-3"></i>
            <span>IT DASHBOARD</span>
        </div>

        <div class="py-3 d-flex flex-column justify-content-between flex-grow-1">
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.halamanutama') }}" class="nav-link {{ Request::is('admin/halamanutama') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 fs-5"></i> Dashboard Utama
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.pengaduan.index') }}" class="nav-link {{ Request::is('admin/pengaduan*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text-fill fs-5"></i> Kelola Pengaduan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.galeri.index') }}" class="nav-link {{ Request::is('admin/galeri*') || Request::is('admin/kelola_galeri*') ? 'active' : '' }}">
                        <i class="bi bi-images fs-5"></i> Kelola Galeri
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.kelola-anggota.index') }}" class="nav-link {{ Request::is('admin/kelola-anggota*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill fs-5"></i> Kelola Anggota
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.kelola-user.index') }}" class="nav-link {{ Request::is('admin/kelola-user*') ? 'active' : '' }}">
                        <i class="bi bi-person-gear fs-5"></i> Kelola User
                    </a>
                </li>
            </ul>

            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <a href="javascript:void(0)" onclick="confirmLogout()" class="nav-link nav-link-logout">
                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                </a>
            </form>
        </div>
    </nav>

    <div class="main-content">
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none shadow-sm" id="sidebarCollapse">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark d-none d-sm-block">Panel Manajemen</h5>
            </div>
            
            <div class="dropdown">
                <button class="btn border-0 d-flex align-items-center gap-2 p-1" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-sm-block me-1">
                        <div class="fw-bold mb-0 lh-1" style="font-size: 0.9rem; color: #333;">{{ Auth::user()->name }}</div>
                        <small class="text-muted" style="font-size: 0.75rem;">
                            {{ Auth::user()->is_admin ? 'Administrator' : 'User' }}
                        </small>
                    </div>
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2" style="border-radius: 12px;">
                    <li><a class="dropdown-item rounded-2" href="#"><i class="bi bi-gear me-2"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button onclick="confirmLogout()" class="dropdown-item text-danger rounded-2">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </li>
                </ul>
            </div>
        </header>

        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarCollapse = document.getElementById('sidebarCollapse');

        // 1. Sidebar Toggle Mobile
        if (sidebarCollapse) {
            sidebarCollapse.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('active');
            });
        }

        // 2. Klik di luar sidebar untuk menutup otomatis (Khusus Mobile)
        document.addEventListener('click', function(event) {
            const isClickInside = sidebar.contains(event.target) || sidebarCollapse.contains(event.target);
            if (!isClickInside && sidebar.classList.contains('active') && window.innerWidth < 992) {
                sidebar.classList.remove('active');
            }
        });

        // 3. Inisialisasi Tooltip Global Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // 4. Konfirmasi Logout SweetAlert2
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Sesi anda akan diakhiri!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0061ff',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>

@stack('scripts')
</body>
</html>