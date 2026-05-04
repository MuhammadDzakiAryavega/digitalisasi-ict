@extends('layouts.app')

@section('title', 'Beranda - Unit IT')

@push('styles')
<style>
    /* Menggunakan Font yang lebih bersih untuk tampilan modern */
    body {
        background-color: #f8f9fa;
        color: #1a1a1a;
        overflow-x: hidden;
    }

    /* Area Utama (Hero) */
    .hero-wrapper {
        min-height: 95vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 0;
    }

    .hero-title {
        font-size: 5rem;
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

    /* Indikator scroll */
    .scroll-indicator {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        color: #b2bec3;
        font-size: 2rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateX(-50%) translateY(0);}
        40% {transform: translateX(-50%) translateY(-10px);}
        60% {transform: translateX(-50%) translateY(-5px);}
    }

    /* Section Konten */
    .content-section {
        padding: 120px 0;
        background-color: #ffffff;
    }

    .title-secondary {
        font-size: 3rem;
        font-weight: 700;
        letter-spacing: -1px;
        margin-bottom: 20px;
    }

    /* --- UPDATE: Card Style dengan Bayangan & Border Lebih Tegas --- */
    .service-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; /* Border lebih gelap agar garis terlihat */
        border-radius: 24px;
        padding: 30px;
        height: 100%;
        position: relative;
        /* Shadow lebih tebal (8% opacity) agar tidak 'lenyap' di bg putih */
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); 
        transition: all 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        border-color: #0061ff; /* Highlight border saat hover */
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
        width: 50px; height: 50px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05); /* Bayangan halus pada icon */
    }

    .icon-blue { background: #eef2ff; color: #4361ee; }
    .icon-green { background: #e8f8f0; color: #2ecc71; }
    .icon-cyan { background: #e0fbff; color: #00bcd4; }
    .icon-red { background: #fff0f0; color: #e74c3c; }

    .feature-item { display: flex; align-items: center; margin-bottom: 15px; font-size: 1.1rem; }
    .feature-item i { color: #2ecc71; margin-right: 12px; }

    /* --- UPDATE: Section Jam Operasional --- */
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
        transition: all 0.3s ease;
    }

    .op-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
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
</style>
@endpush

@section('content')
<header class="hero-wrapper position-relative">
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
    <div class="scroll-indicator">
        <i class="bi bi-chevron-down"></i>
    </div>
</header>

<section class="content-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <h2 class="title-secondary">Apa yang Bisa Kami Bantu?</h2>
                <p class="text-muted fs-5 mb-4">
                    Kami mendigitalisasi proses agar penanganan lebih transparan. Dapatkan layanan teknis dengan mudah.
                </p>
                <div class="feature-list">
                    <div class="feature-item"><i class="bi bi-check2"></i> Layanan 24/7 Online</div>
                    <div class="feature-item"><i class="bi bi-check2"></i> Proses Cepat & Mudah</div>
                    <div class="feature-item"><i class="bi bi-check2"></i> Tracking Status Real-time</div>
                    <div class="feature-item"><i class="bi bi-check2"></i> Respon Teknisi Sigap</div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-blue"><i class="bi bi-diagram-3"></i></div>
                            <h3 class="h5 fw-bold">Update Kabel LAN</h3>
                            <p class="card-desc text-muted small">Perbaikan koneksi internet dan penggantian kabel LAN yang bermasalah.</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 30 menit - 1 jam</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-green"><i class="bi bi-shield-check"></i></div>
                            <h3 class="h5 fw-bold">Instalasi Antivirus</h3>
                            <p class="card-desc text-muted small">Proteksi perangkat komputer dari serangan malware dan virus terbaru.</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 1 jam</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-cyan"><i class="bi bi-laptop"></i></div>
                            <h3 class="h5 fw-bold">Perbaikan Perangkat</h3>
                            <p class="card-desc text-muted small">Pengecekan hardware komputer, printer, dan perangkat IT lainnya.</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 1-2 hari</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="service-card">
                            <span class="badge-available">Tersedia</span>
                            <div class="icon-box icon-red"><i class="bi bi-file-earmark-code"></i></div>
                            <h3 class="h5 fw-bold">Instalasi Software</h3>
                            <p class="card-desc text-muted small">Pemasangan aplikasi perkantoran dan pembaruan sistem operasi (OS).</p>
                            <div class="card-time text-muted small"><i class="bi bi-clock me-1"></i> 30 menit - 1 Jam</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-operating">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-lg-12">
                <h2 class="title-secondary">Jam Operasional</h2>
                <p class="text-muted fs-5">Jadwal pelayanan kantor unit dan layanan digital kami</p>
            </div>
        </div>

        <div class="row g-4">
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
                            <span class="op-day"><i class="bi bi-globe me-2"></i>Portal ICT</span>
                            <span class="op-status-24h"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> 24 Jam</span>
                        </div>
                        <div class="op-item">
                            <span class="op-day"><i class="bi bi-whatsapp me-2"></i>WhatsApp CS</span>
                            <span class="op-time">08:00 - 20:00 WIB</span>
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
@endsection