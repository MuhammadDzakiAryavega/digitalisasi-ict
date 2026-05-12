@extends('layouts.app')

@section('title', 'Tentang Kami - Unit IT')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* Reset & Base */
    body {
        background-color: #ffffff; 
        color: #1a1a1a;
        overflow-x: hidden;
    }

    main {
        padding-top: 0 !important;
    }

    /* --- HEADER HERO TENTANG (Disamakan dengan Beranda & Galeri) --- */
    .hero-tentang {
        min-height: 95vh; 
        display: flex;
        flex-direction: column;
        align-items: center; 
        justify-content: center; 
        /* Padding dan margin ditarik agar pas dengan navbar */
        padding: 190px 0 100px 0; 
        margin-top: -75px; 
        background: linear-gradient(180deg, #f0f4ff 0%, #ffffff 100%);
        text-align: center; 
        position: relative;
    }

    .badge-info-it {
        display: inline-block;
        padding: 10px 28px;
        background: rgba(0, 97, 255, 0.1);
        color: #0061ff;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .hero-title {
        /* Ukuran font disamakan persis dengan Beranda */
        font-size: clamp(3rem, 8vw, 5rem); 
        font-weight: 850;
        line-height: 1.1;
        letter-spacing: -3px;
        color: #1a1a1a;
        margin-bottom: 25px;
    }

    .hero-title .text-blue {
        color: #0061ff;
        display: block; /* Agar "Solusi Teknologi" turun ke bawah seperti desain */
    }

    .hero-desc {
        /* Ukuran deskripsi disamakan dengan Beranda */
        font-size: 1.35rem;
        color: #636e72;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 400;
    }

    /* Indikator scroll */
    .scroll-indicator {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        color: #0061ff;
        font-size: 2rem;
        animation: bounce 2s infinite;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateX(-50%) translateY(0);}
        40% {transform: translateX(-50%) translateY(-10px);}
        60% {transform: translateX(-50%) translateY(-5px);}
    }

    /* Konten Card & Stats */
    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; 
        border-radius: 40px;
        padding: 80px 60px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); 
        position: relative;
        z-index: 10;
        margin-top: 40px; 
    }

    .vision-item {
        padding: 40px;
        border-radius: 30px;
        background: #f8fbff;
        border: 1px solid #eef2ff;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .vision-item:hover {
        background: #ffffff;
        box-shadow: 0 20px 40px rgba(0, 97, 255, 0.08);
        transform: translateY(-10px);
    }

    .icon-circle {
        width: 60px; height: 60px;
        background: #0061ff; color: white;
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin-bottom: 25px;
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: #0061ff;
        line-height: 1;
    }

    /* --- TIM TEKNIS --- */
    .team-grid { padding: 120px 0; background-color: #ffffff; }

    .member-card {
        text-align: center;
        padding: 50px 30px;
        border-radius: 32px;
        border: 1px solid #f1f5f9;
        background: #ffffff;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
    }

    .member-avatar {
        width: 120px; height: 120px;
        background: #f1f5f9; 
        color: #0061ff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 3.5rem; margin: 0 auto 30px;
        transition: all 0.4s ease;
    }

    .member-card:hover {
        border-color: #0061ff;
        box-shadow: 0 20px 40px rgba(0, 97, 255, 0.1);
        transform: translateY(-10px);
    }

    .member-card:hover .member-avatar {
        background: #0061ff;
        color: #ffffff;
        transform: scale(1.1);
    }

    .member-card h4 {
        transition: color 0.3s ease;
    }
    
    .member-card:hover h4 {
        color: #0061ff;
    }

    /* --- CTA BOX --- */
    .cta-box {
        background: linear-gradient(135deg, #0052d9 0%, #0061ff 100%);
        padding: 100px 0;
        color: white;
        text-align: center;
        border-radius: 80px 80px 0 0; 
    }

    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #0061ff;
        color: white;
        width: 55px; height: 55px; /* Disesuaikan ukurannya dengan yang lain */
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 97, 255, 0.3);
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        z-index: 1000;
        border: 2px solid #ffffff; 
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
<header class="hero-tentang">
    <div class="container">
        <span class="badge-info-it">Profil Unit IT</span>
        <h1 class="hero-title">
            Ekspertis di Balik 
            <span class="text-blue">Solusi Teknologi</span>
        </h1>
        <p class="hero-desc">
            Kami memastikan seluruh infrastruktur digital dan perangkat IT Anda beroperasi secara maksimal guna mendukung produktivitas instansi.
        </p>
    </div>
    <div class="scroll-indicator" id="scrollTrigger">
        <i class="bi bi-chevron-down"></i>
    </div>
</header>

<section class="pb-5" id="targetContent">
    <div class="container">
        <div class="profile-card">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <h2 class="fw-bold mb-4" style="letter-spacing: -2px; font-size: 3rem;">Komitmen Pelayanan</h2>
                    <p class="text-muted mb-5 fs-5">Memberikan respon cepat dan solusi tepat guna bagi setiap kendala teknologi.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="vision-item">
                                <div class="icon-circle"><i class="bi bi-lightning-charge"></i></div>
                                <h4 class="fw-bold">Respon Cepat</h4>
                                <p class="text-muted mb-0">Meminimalisir waktu tunggu dengan sistem antrean digital terintegrasi.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="vision-item">
                                <div class="icon-circle"><i class="bi bi-shield-lock"></i></div>
                                <h4 class="fw-bold">Aman & Terpercaya</h4>
                                <p class="text-muted mb-0">Menjamin kerahasiaan data pada setiap perangkat yang kami tangani.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 ps-lg-5">
                    <div class="row g-4 text-center">
                        <div class="col-12">
                            <div class="stat-box">
                                <span class="stat-number">10+</span>
                                <div class="fw-bold text-uppercase small mt-2">Tahun Pengalaman</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-box border-top pt-5">
                                <span class="stat-number">2.5k</span>
                                <div class="fw-bold text-uppercase small mt-2">Laporan Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="team-grid">
    <div class="container text-center">
        <h2 class="fw-bold mb-5" style="font-size: 3rem; letter-spacing: -2px;">Tim Teknis Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="member-card">
                    <div class="member-avatar"><i class="bi bi-person-fill"></i></div>
                    <h4 class="fw-bold">Manager Unit</h4>
                    <p class="text-blue fw-bold small">STRATEGI & SUPERVISI</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="member-card">
                    <div class="member-avatar"><i class="bi bi-person-fill-gear"></i></div>
                    <h4 class="fw-bold">Hardware Pro</h4>
                    <p class="text-blue fw-bold small">TEKNISI PERANGKAT</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="member-card">
                    <div class="member-avatar"><i class="bi bi-person-fill-check"></i></div>
                    <h4 class="fw-bold">Network Expert</h4>
                    <p class="text-blue fw-bold small">JARINGAN & SERVER</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-tentang">
    <div class="cta-box">
        <div class="container">
            <h2 class="fw-bold mb-4 display-5">Sistem Kami Selalu Siap Membantu</h2>
            <p class="opacity-75 mb-5 mx-auto fs-5" style="max-width: 650px;">
                Laporkan kendala perangkat Anda sekarang juga melalui portal pengaduan online kami.
            </p>
            <a href="{{ route('pengaduan.create') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary py-3 shadow">
                Buat Laporan Sekarang <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<div class="scroll-to-top" id="scrollTopBtn">
    <i class="bi bi-chevron-up"></i>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scrollTrigger = document.getElementById('scrollTrigger');
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        const targetSection = document.getElementById('targetContent');
        const navbarOffset = 1;

        if (scrollTrigger && targetSection) {
            scrollTrigger.addEventListener('click', function() {
                const targetPosition = targetSection.getBoundingClientRect().top + window.scrollY;
                window.scrollTo({ top: targetPosition - navbarOffset, behavior: 'smooth' });
            });
        }

        if (scrollTopBtn) {
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        window.addEventListener('scroll', function() {
            if (window.scrollY > 150) {
                scrollTrigger.style.opacity = '0';
                scrollTrigger.style.pointerEvents = 'none';
            } else {
                scrollTrigger.style.opacity = '1';
                scrollTrigger.style.pointerEvents = 'auto';
            }

            if (window.scrollY > 400) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });
    });
</script>
@endpush