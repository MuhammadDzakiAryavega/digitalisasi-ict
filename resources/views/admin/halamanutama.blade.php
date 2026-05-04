@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - Unit IT')

@section('content')
<style>
    /* --- CSS Jam Digital --- */
    .clock-widget {
        background: #ffffff;
        border-radius: 15px;
        padding: 12px 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #0061ff;
        min-width: 200px;
        transition: all 0.3s ease;
    }

    .clock-widget:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    #clock {
        font-family: 'Courier New', Courier, monospace;
        font-size: 1.5rem;
        letter-spacing: 2px;
        background: linear-gradient(135deg, #0061ff 0%, #60efff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: block;
        line-height: 1.2;
    }

    #date {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #858796;
    }

    /* --- CSS Card Interaktif --- */
    .stat-card-link {
        text-decoration: none !important;
        color: inherit;
        display: block;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card-link:hover {
        transform: translateY(-5px);
    }

    .stat-card-link:hover .card {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    /* Animasi berkedip untuk peringatan pending */
    .blink {
        animation: blink-animation 1.5s steps(5, start) infinite;
    }

    @keyframes blink-animation {
        to { visibility: hidden; }
    }
</style>

<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h4 class="fw-bold text-dark mb-1">Ringkasan Sistem</h4>
            <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}. Berikut adalah statistik terkini Unit IT.</p>
        </div>
        
        <div class="col-md-4 d-flex justify-content-md-end">
            <div class="clock-widget d-flex flex-column align-items-end">
                <div id="clock" class="fw-bold">00:00:00</div>
                <div id="date" class="fw-semibold">Memuat tanggal...</div>
            </div>
        </div>
    </div>

    {{-- Row Statistik --}}
    <div class="row g-4 mb-5">
        {{-- Card Total Pengaduan --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.pengaduan.index') }}" class="stat-card-link">
                <div class="card h-100 p-3 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">Total Pengaduan</small>
                            <h2 class="fw-bold text-primary mt-1 mb-0">{{ $totalPengaduan }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-megaphone-fill text-primary fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($pengaduanPending > 0)
                            <span class="badge bg-danger blink shadow-sm px-2 py-1" style="font-size: 0.8rem;">
                                <i class="bi bi-clock-history me-1"></i> {{ $pengaduanPending }} Pending
                            </span>
                        @else
                            <span class="badge bg-success shadow-sm px-2 py-1" style="font-size: 0.8rem;">
                                <i class="bi bi-check-circle-fill me-1"></i> Selesai
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Galeri Kegiatan --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.galeri.index') }}" class="stat-card-link">
                <div class="card h-100 p-3 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">Galeri Kegiatan</small>
                            <h2 class="fw-bold text-success mt-1 mb-0">{{ $totalGaleri }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-images text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted small">
                        <i class="bi bi-check-circle-fill text-success"></i> Dokumentasi Aktif
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Total Anggota --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.kelola-anggota.index') }}" class="stat-card-link">
                <div class="card h-100 p-3 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">Total Anggota</small>
                            <h2 class="fw-bold text-warning mt-1 mb-0">{{ $totalAnggota }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-person-badge-fill text-warning fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted small">
                        <i class="bi bi-shield-check text-warning"></i> Personil Unit IT
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Total Pengguna --}}
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.kelola-user.index') }}" class="stat-card-link">
                <div class="card h-100 p-3 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">Total Pengguna</small>
                            <h2 class="fw-bold text-info mt-1 mb-0">{{ $totalUser }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-people-fill text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted small">
                        <i class="bi bi-person-plus"></i> Akun Terdaftar
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Row Bawah --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 15px;">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <i class="bi bi-info-circle-fill text-primary fs-4"></i>
                    <h5 class="fw-bold mb-0">Panduan Admin</h5>
                </div>
                <p class="text-muted mb-0">
                    Panel ini digunakan untuk mengelola seluruh data operasional Unit IT Semen Padang. 
                </p>
                <hr class="my-4">
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card p-4 h-100 border-0 border-start border-4 border-primary shadow-sm" style="border-radius: 15px;">
                <h6 class="fw-bold">Status Server</h6>
                <div class="mt-3 d-flex align-items-center gap-2">
                    <span class="p-1 bg-success rounded-circle"></span>
                    <small>Database Online</small>
                </div>
                <div class="mt-2 d-flex align-items-center gap-2">
                    <span class="p-1 bg-success rounded-circle"></span>
                    <small>Storage Connection OK</small>
                </div>
                <div class="mt-4 pt-2">
                    <small class="text-muted d-block">Versi Aplikasi</small>
                    <span class="fw-bold">v1.0.4-Beta</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('clock').innerHTML = `${hours}:${minutes}:${seconds}`;

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('date').textContent = now.toLocaleDateString('id-ID', options);
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>
@endpush
@endsection