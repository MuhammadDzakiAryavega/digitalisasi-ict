@extends('layouts.app') {{-- Pastikan mengarah ke nama file layout kamu --}}

@section('title', 'Galeri Kegiatan - Unit ICT')

@push('styles')
<style>
    /* Desain Card Galeri */
    .galeri-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .galeri-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    /* Pengaturan Gambar */
    .img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .galeri-card:hover .img-wrapper img {
        transform: scale(1.1);
    }

    /* Badge Tanggal di Atas Gambar */
    .date-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(0, 97, 255, 0.9); /* Biru sesuai Navbar */
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }

    .content-body {
        padding: 20px;
    }

    .title-kegiatan {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .desc-kegiatan {
        color: #636e72;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /* Section Background */
    .section-galeri {
        background-color: #f8f9fa; /* Abu-abu muda agar card putih terlihat pop-out */
        padding: 60px 0;
    }
</style>
@endpush

@section('content')
<div class="section-galeri">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-3" style="color: #1a1a1a; font-size: 2.5rem;">
                    Dokumentasi <span style="color: #0061ff;">Unit ICT</span>
                </h2>
                <p class="text-muted">Melihat lebih dekat kegiatan teknis, pemeliharaan infrastruktur, dan digitalisasi pelayanan di Semen Padang.</p>
                <hr class="mx-auto" style="width: 60px; height: 4px; background: #0061ff; border-radius: 10px; opacity: 1;">
            </div>
        </div>

        <div class="row g-4">
            @forelse($galeris as $galeri)
            <div class="col-md-6 col-lg-4">
                <div class="galeri-card">
                    <div class="img-wrapper">
                        <div class="date-badge">
                            <i class="bi bi-calendar3 me-1"></i> 
                            {{ \Carbon\Carbon::parse($galeri->tanggal_kegiatan)->translatedFormat('d M Y') }}
                        </div>
                        
                        @if($galeri->thumbnail_url)
                            <img src="{{ asset('storage/' . $galeri->thumbnail_url) }}" 
     alt="{{ $galeri->judul_kegiatan }}"
     onerror="this.src='https://via.placeholder.com/400x250?text=Gambar+Tidak+Ditemukan'">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light text-secondary">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                        @endif
                    </div>
                    <div class="content-body">
                        <h5 class="title-kegiatan">{{ $galeri->judul_kegiatan }}</h5>
                        <p class="desc-kegiatan mb-0">
                            {{ Str::limit($galeri->deskripsi_singkat, 120, '...') }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm d-inline-block">
                    <i class="bi bi-folder2-open display-1 text-light"></i>
                    <h4 class="mt-3 text-muted">Belum ada data galeri.</h4>
                    <p class="text-muted">Data akan muncul setelah admin mengunggah dokumentasi kegiatan.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection