@extends('layouts.app')

@section('title', 'Galeri Kegiatan - Unit IT')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* Menghilangkan padding layout default khusus halaman galeri */
    main {
        padding-top: 0 !important;
    }

    .page-galeri {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* --- HEADER HERO (Menutup celah putih) --- */
    .galeri-header {
        /* Padding disamakan dengan .hero-wrapper Beranda */
        padding: 180px 0 100px 0; 
        text-align: center;
        background: linear-gradient(180deg, #f0f4ff 0%, #ffffff 100%);
        position: relative;
        margin-top: -75px; 
    }

    .galeri-header .title-top {
        /* Ukuran font disamakan persis dengan .hero-title Beranda */
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 850;
        color: #1a1a1a;
        line-height: 1.1; 
        margin-bottom: 0;
        letter-spacing: -3px;
    }

    .galeri-header .title-bottom {
        /* Ukuran font disamakan persis dengan .hero-title Beranda */
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 850;
        color: #0061ff;
        display: block;
        line-height: 1.1; 
        letter-spacing: -3px;
        margin-top: 0; /* Dibuat 0 agar jaraknya menempel seperti di Beranda */
        margin-bottom: 30px;
    }

    .galeri-header .description {
        /* Ukuran deskripsi disamakan dengan .hero-desc Beranda */
        font-size: 1.35rem;
        color: #636e72;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 400;
    }

    /* --- HEADER HERO (Judul Utama) --- */
.hero-title {
    /* Mengecilkan dari 5.5rem ke 4rem agar tidak memenuhi layar */
    font-size: clamp(2.5rem, 6vw, 4rem); 
    font-weight: 850;
    line-height: 1.1;
    letter-spacing: -2px; /* Dipersempit sedikit agar lebih elegan */
    color: #1a1a1a;
    margin-bottom: 10px;
}

.hero-title .text-blue {
    color: #0061ff;
    display: block;
}

/* --- DESKRIPSI (Teks di bawah judul) --- */
.hero-desc {
        /* Ukuran deskripsi disamakan dengan Beranda */
        font-size: 1.35rem;
        color: #636e72;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 400;
    }

/* --- JUDUL SEKSI (Contoh: Apa yang Bisa Kami Bantu?) --- */
.title-secondary {
    /* Mengecilkan dari 3rem ke 2.2rem */
    font-size: clamp(1.8rem, 4vw, 2.2rem);
    font-weight: 700;
    letter-spacing: -1px;
    margin-bottom: 20px;
}

    /* --- SCROLL INDICATOR --- */
    .scroll-indicator {
        margin-top: 50px;
        display: inline-block;
        color: #0061ff;
        font-size: 2.5rem;
        cursor: pointer;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    /* --- SECTION KONTEN --- */
    .section-galeri-content {
        padding: 80px 0 120px 0;
    }

    .galeri-card {
        border: 1px solid #f1f5f9;
        border-radius: 24px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .galeri-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 97, 255, 0.1);
        border-color: #0061ff;
    }

    .img-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .galeri-card:hover .img-wrapper img {
        transform: scale(1.1);
    }

    /* Badge Tanggal */
    .date-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(0, 97, 255, 0.9);
        backdrop-filter: blur(4px);
        color: white;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        z-index: 10;
    }

    .content-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .title-kegiatan {
        font-weight: 800;
        font-size: 1.3rem;
        color: #1a1a1a;
        margin-bottom: 12px;
    }

    .btn-detail {
        margin-top: auto; /* Memaksa tombol ke bawah */
        padding-top: 20px;
        color: #0061ff;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
    }

    .btn-detail i { transition: 0.3s; }
    .btn-detail:hover i { transform: translateX(5px); }
</style>
@endpush

@section('content')
<div class="page-galeri">
    
    <header class="galeri-header" data-aos="fade-down">
        <div class="container">
            <h1 class="title-top">Dokumentasi</h1>
            <span class="title-bottom">Unit IT</span>
            
            <p class="description">
                Melihat lebih dekat kegiatan teknis, pemeliharaan infrastruktur, dan digitalisasi pelayanan di Semen Padang secara komprehensif.
            </p>

            <div class="scroll-indicator" id="scrollTrigger">
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
    </header>

    <section class="section-galeri-content" id="galeri">
        <div class="container">
            <div class="row g-4">
                @forelse($galeris as $index => $galeri)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 150 }}">
                    <article class="galeri-card">
                        <div class="img-wrapper">
                            <div class="date-badge">
                                {{ \Carbon\Carbon::parse($galeri->tanggal_kegiatan)->translatedFormat('d M Y') }}
                            </div>
                            
                            @if($galeri->thumbnail_url)
                                <img src="{{ asset('storage/' . $galeri->thumbnail_url) }}" alt="{{ $galeri->judul_kegiatan }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                    <i class="bi bi-image fs-2"></i>
                                </div>
                            @endif
                        </div>
                        <div class="content-body">
                            <h4 class="title-kegiatan">{{ $galeri->judul_kegiatan }}</h4>
                            <p class="text-muted mb-0 text-deskripsi">
                                {{ Str::limit($galeri->deskripsi_singkat, 100) }}
                            </p>
                            <!-- Tombol Selengkapnya -->
                            <a href="#" class="btn-detail">
                                Selengkapnya
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </article>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Tidak ada dokumentasi untuk ditampilkan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-back'
        });

        const scrollTrigger = document.getElementById('scrollTrigger');
        const targetSection = document.getElementById('galeri');

        if (scrollTrigger && targetSection) {
            scrollTrigger.addEventListener('click', function() {
                targetSection.scrollIntoView({ 
                    behavior: 'smooth' 
                });
            });
        }
    });
</script>
@endpush