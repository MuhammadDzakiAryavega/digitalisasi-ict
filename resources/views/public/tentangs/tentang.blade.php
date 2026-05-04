@extends('layouts.app')

@section('title', 'Tentang Kami - Unit IT')

@push('styles')
<style>
    /* Reset & Base */
    body {
        background-color: #ffffff; 
        color: #1a1a1a;
        overflow-x: hidden;
    }

    main {
        padding-bottom: 0 !important;
    }

    .hero-tentang {
        padding: 80px 0 100px 0; 
        background: linear-gradient(180deg, #f0f4ff 0%, #ffffff 100%);
        text-align: center;
    }

    .badge-info-it {
        display: inline-block;
        padding: 8px 24px;
        background: rgba(0, 97, 255, 0.1);
        color: #0061ff;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .hero-title {
        font-size: clamp(2.5rem, 8vw, 4.5rem); 
        font-weight: 850;
        line-height: 1;
        letter-spacing: -3px;
        color: #1a1a1a;
        margin-bottom: 25px;
    }

    .hero-title .text-blue {
        color: #0061ff;
    }

    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; 
        border-radius: 40px;
        padding: 80px 60px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); 
        position: relative;
        z-index: 10;
        margin-top: 20px; 
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
        width: 60px;
        height: 60px;
        background: #0061ff;
        color: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 25px;
    }

    .stat-box {
        text-align: center;
        padding: 30px;
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: #0061ff;
        line-height: 1;
    }

    .team-grid {
        padding: 120px 0;
        background-color: #ffffff;
    }

    .member-card {
        text-align: center;
        padding: 50px 30px;
        border-radius: 32px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .member-card:hover {
        background: #0061ff;
        color: white !important;
    }

    .member-card:hover .text-blue, 
    .member-card:hover .text-muted,
    .member-card:hover h4 {
        color: white !important;
    }

    .member-avatar {
        width: 120px;
        height: 120px;
        background: #f1f5f9;
        color: #0061ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        margin: 0 auto 30px;
    }

    .cta-tentang {
        padding: 0; /* Menghapus padding agar menempel ke bawah */
        margin: 0;
    }

    .cta-box {
        background: #0061ff;
        padding: 100px 0;
        color: white;
        text-align: center;
        /* Membuat lengkungan hanya di atas agar bagian bawah rata/full */
        border-radius: 80px 80px 0 0; 
    }

    .section-spacing {
        padding: 100px 0;
    }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="hero-tentang">
    <div class="container">
        <span class="badge-info-it">Profil Unit IT</span>
        <h1 class="hero-title">Ekspertis di Balik <br><span class="text-blue">Solusi Teknologi</span></h1>
        <p class="text-muted fs-5 mx-auto" style="max-width: 750px;">
            Kami memastikan seluruh infrastruktur digital dan perangkat IT Anda beroperasi secara maksimal guna mendukung produktivitas instansi.
        </p>
    </div>
</section>

<!-- Profil & Visi -->
<section class="pb-5">
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
                                <div class="fw-bold text-uppercase small tracking-widest mt-2">Tahun Pengalaman</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-box border-top pt-5">
                                <span class="stat-number">2.5k</span>
                                <div class="fw-bold text-uppercase small tracking-widest mt-2">Laporan Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
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

<!-- CTA (Full Bottom) -->
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
@endsection