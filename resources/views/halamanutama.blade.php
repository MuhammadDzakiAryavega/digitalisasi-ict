@extends('layouts.app')

@section('title', 'Beranda - Unit IT')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* 1. Base Style */
    body {
        background-color: #ffffff;
        color: #1a1a1a;
        overflow-x: hidden;
    }

    /* Menghilangkan padding bawaan main agar hero menempel ke navbar */
    main {
        padding-top: 0 !important;
    }

    /* 2. Hero Section (Disesuaikan agar mirip halaman Tentang) */
    .hero-wrapper {
        min-height: 95vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 250px 0 100px 0; 
        background: linear-gradient(180deg, #f0f4ff 0%, #ffffff 100%);
        margin-top: -75px; 
        position: relative;
    }

    .hero-title {
        /* Menggunakan clamp agar teks fleksibel di layar HP maupun Desktop */
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 850;
        line-height: 1.1;
        letter-spacing: -3px;
        color: #1a1a1a;
        margin-bottom: 30px;
    }

    .hero-title .text-blue {
        color: #0061ff;
        display: block;
    }

    .hero-desc {
        font-size: 1.35rem;
        color: #636e72;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 400;
    }

    /* 3. Scroll Indicator */
    .scroll-indicator {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        color: #0061ff;
        font-size: 2rem;
        cursor: pointer;
        transition: opacity 0.3s ease;
        animation: bounce 2s infinite;
        z-index: 10;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateX(-50%) translateY(0);}
        40% {transform: translateX(-50%) translateY(-10px);}
        60% {transform: translateX(-50%) translateY(-5px);}
    }

    /* 4. Content Sections */
    .content-section {
        padding: 120px 0;
        background-color: #ffffff;
    }

    .title-secondary {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        letter-spacing: -1px;
        margin-bottom: 20px;
    }

    /* 5. Service Cards */
    .service-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 30px;
        height: 100%;
        position: relative;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06); 
        transition: all 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 97, 255, 0.12);
        border-color: #0061ff;
    }

    .badge-available {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #e8f8f0;
        color: #2ecc71;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        border: 1px solid rgba(46, 204, 113, 0.2);
    }

    .icon-box {
        width: 55px; height: 55px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; margin-bottom: 25px;
    }

    .icon-blue { background: #eef2ff; color: #4361ee; }
    .icon-green { background: #e8f8f0; color: #2ecc71; }
    .icon-cyan { background: #e0fbff; color: #00bcd4; }
    .icon-red { background: #fff0f0; color: #e74c3c; }

    .feature-item { display: flex; align-items: center; margin-bottom: 15px; font-size: 1.1rem; }
    .feature-item i { color: #2ecc71; margin-right: 12px; font-size: 1.3rem; }

    /* 6. Operating Hours Section */
    .section-operating {
        padding: 100px 0;
        background-color: #fcfcfc;
        border-top: 1px solid #e2e8f0;
    }

    .op-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .op-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .op-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .bg-light-green-op { background: #e8f8f0; color: #2ecc71; }
    .bg-light-blue-op { background: #eef2ff; color: #4361ee; }

    .op-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f2f6;
    }

    .op-item:last-child { border-bottom: none; margin-bottom: 0; }
    .op-day { font-weight: 600; color: #1a1a1a; }
    
    .op-time {
        font-size: 0.85rem;
        font-weight: 700;
        background: #f1f2f6;
        padding: 5px 14px;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
    }

    .op-status-24h {
        background: #e8f8f0; color: #2ecc71;
        font-size: 0.85rem; padding: 5px 14px;
        border-radius: 50px; font-weight: 700;
        border: 1px solid rgba(46, 204, 113, 0.2);
    }

    .op-status-closed {
        background: #fff0f0; color: #e74c3c;
        font-size: 0.85rem; padding: 5px 14px;
        border-radius: 50px; font-weight: 700;
        border: 1px solid rgba(231, 76, 60, 0.2);
    }

    .rest-time {
        font-size: 0.75rem; color: #f39c12;
        display: block; margin-top: 4px;
    }

    /* 7. Scroll to Top Button */
    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #0061ff;
        color: white;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 97, 255, 0.3);
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
    }

    .scroll-to-top:hover {
        background-color: #1a1a1a;
        transform: translateY(-5px);
    }

    .scroll-to-top.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<header class="hero-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h1 class="hero-title">
                    Digitalisasi Pelayanan
                    <span class="text-blue">Unit IT</span>
                </h1>
                <p class="hero-desc">
                    Laporkan kendala IT Anda secara cepat melalui sistem online yang terintegrasi. Kami siap melayani kebutuhan perbaikan perangkat Anda.
                </p>
            </div>
        </div>
    </div>
    <div class="scroll-indicator" id="scrollTrigger">
        <i class="bi bi-chevron-down"></i>
    </div>
</header>

<!-- Main Features Section -->
<section class="content-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <h2 class="title-secondary">Apa yang Bisa Kami Bantu?</h2>
                <p class="text-muted fs-5 mb-4">
                    Kami mendigitalisasi proses agar penanganan lebih transparan. Dapatkan layanan teknis dengan mudah melalui portal kami.
                </p>
                <div class="feature-list">
                    <div class="feature-item"><i class="bi bi-check-circle-fill"></i> Layanan 24/7 Online</div>
                    <div class="feature-item"><i class="bi bi-check-circle-fill"></i> Proses Cepat & Mudah</div>
                    <div class="feature-item"><i class="bi bi-check-circle-fill"></i> Tracking Status Real-time</div>
                    <div class="feature-item"><i class="bi bi-check-circle-fill"></i> Respon Teknisi Sigap</div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="row g-4">
                    <!-- Card 1 -->
                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-blue"><i class="bi bi-diagram-3"></i></div>
                            <h3 class="h5 fw-bold">Update Kabel LAN</h3>
                            <p class="card-desc text-muted small">Perbaikan koneksi internet dan penggantian kabel LAN yang bermasalah.</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 30m - 1j</div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-green"><i class="bi bi-shield-check"></i></div>
                            <h3 class="h5 fw-bold">Instalasi Antivirus</h3>
                            <p class="card-desc text-muted small">Proteksi perangkat komputer dari serangan malware dan virus terbaru.</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 1 jam</div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-cyan"><i class="bi bi-laptop"></i></div>
                            <h3 class="h5 fw-bold">Perbaikan Perangkat</h3>
                            <p class="card-desc text-muted small">Pengecekan hardware komputer, printer, dan perangkat IT lainnya.</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 1-2 hari</div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-red"><i class="bi bi-file-earmark-code"></i></div>
                            <h3 class="h5 fw-bold">Instalasi Software</h3>
                            <p class="card-desc text-muted small">Pemasangan aplikasi perkantoran dan pembaruan sistem operasi (OS).</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 30m - 1j</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Operating Hours Section -->
<section class="section-operating">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-lg-12">
                <h2 class="title-secondary">Jam Operasional</h2>
                <p class="text-muted fs-5">Jadwal pelayanan kantor unit dan layanan digital kami</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Offline Office -->
            <div class="col-lg-6">
                <div class="op-card">
                    <div class="op-header">
                        <div class="op-icon-wrapper bg-light-green-op">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3 class="h5 mb-0 fw-bold">Pelayanan Tatap Muka</h3>
                    </div>
                    <div class="op-list">
                        <div class="op-item">
                            <div>
                                <span class="op-day"><i class="bi bi-calendar-check me-2"></i>Senin - Kamis</span>
                                <small class="rest-time"><i class="bi bi-clock-history me-1"></i>Istirahat: 12:00 - 13:00 WIB</small>
                            </div>
                            <span class="op-time">08:00 - 17:00 WIB</span>
                        </div>
                        <div class="op-item">
                            <div>
                                <span class="op-day"><i class="bi bi-calendar-check me-2"></i>Jumat</span>
                                <small class="rest-time"><i class="bi bi-clock-history me-1"></i>Istirahat: 12:00 - 13:30 WIB</small>
                            </div>
                            <span class="op-time">08:00 - 17:00 WIB</span>
                        </div>
                        <div class="op-item">
                            <span class="op-day text-danger"><i class="bi bi-calendar-x me-2"></i>Sabtu - Minggu</span>
                            <span class="op-status-closed">Tutup</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Online Support -->
            <div class="col-lg-6">
                <div class="op-card">
                    <div class="op-header">
                        <div class="op-icon-wrapper bg-light-blue-op">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <h3 class="h5 mb-0 fw-bold">Layanan Digital (Online)</h3>
                    </div>
                    <div class="op-list">
                        <div class="op-item">
                            <span class="op-day"><i class="bi bi-globe me-2"></i>Portal IT</span>
                            <span class="op-status-24h"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> 24 Jam</span>
                        </div>
                        <div class="op-item">
                            <span class="op-day"><i class="bi bi-whatsapp me-2"></i>WhatsApp CS</span>
                            <span class="op-time">08:00 - 17:00 WIB</span>
                        </div>
                        <div class="op-item">
                            <span class="op-day"><i class="bi bi-envelope-at me-2"></i>Email Support</span>
                            <span class="op-status-24h"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> 24 Jam</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Scroll to Top -->
<div class="scroll-to-top" id="scrollTopBtn">
    <i class="bi bi-chevron-up"></i>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scrollTrigger = document.getElementById('scrollTrigger');
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        const targetSection = document.querySelector('.content-section'); 
        const navbarOffset = -50; // Sesuaikan dengan tinggi navbar Anda

        // 1. Klik Panah Bawah di Hero
        if (scrollTrigger && targetSection) {
            scrollTrigger.addEventListener('click', function() {
                const targetPosition = targetSection.getBoundingClientRect().top + window.scrollY;
                window.scrollTo({
                    top: targetPosition - navbarOffset, 
                    behavior: 'smooth' 
                });
            });
        }

        // 2. Klik Tombol Scroll Up
        if (scrollTopBtn) {
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // 3. Efek saat Scroll
        window.addEventListener('scroll', function() {
            // Hilangkan panah bawah secara perlahan saat scroll
            if (window.scrollY > 150) {
                scrollTrigger.style.opacity = '0';
                scrollTrigger.style.pointerEvents = 'none';
            } else {
                scrollTrigger.style.opacity = '1';
                scrollTrigger.style.pointerEvents = 'auto';
            }

            // Munculkan tombol UP jika scroll lebih dari 400px
            if (window.scrollY > 400) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });
    });
</script>
@endpush