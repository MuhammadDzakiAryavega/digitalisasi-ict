@extends('layouts.app')

@section('title', 'Buat Pengaduan - Unit IT')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* --- INTEGRASI STYLE --- */
    main { padding-top: 0 !important; }

    .page-pengaduan {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* --- HERO HEADER --- */
    .hero-header {
        padding: 180px 0 100px 0; 
        text-align: center;
        background: linear-gradient(180deg, #f0f4ff 0%, #ffffff 100%);
        position: relative;
        margin-top: -75px; 
    }

    .hero-header .title-top {
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 850;
        color: #1a1a1a;
        line-height: 1.1; 
        margin-bottom: 0;
        letter-spacing: -3px;
    }

    .hero-header .title-bottom {
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 850;
        color: #0061ff;
        display: block;
        line-height: 1.1; 
        letter-spacing: -3px;
        margin-bottom: 30px;
    }

    .hero-header .description {
        font-size: 1.35rem;
        color: #636e72;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 400;
    }

    /* --- TAB NAVIGASI --- */
    .nav-toggle-container {
        display: flex; 
        background: white;
        border-radius: 20px; 
        padding: 8px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.06); 
        margin: -50px auto 50px auto;
        position: relative;
        z-index: 10;
        max-width: 550px;
        border: 1px solid #eef2f7;
    }

    .nav-toggle-btn {
        flex: 1; padding: 14px; text-align: center; border-radius: 15px;
        text-decoration: none; font-weight: 700; transition: all 0.3s ease;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .nav-toggle-btn.active {
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%);
        color: #fff !important;
        box-shadow: 0 8px 20px rgba(0, 97, 255, 0.3);
    }

    .nav-toggle-btn.inactive { color: #64748b !important; }
    .nav-toggle-btn.inactive:hover { background-color: #f1f5f9; color: #0061ff !important; }

    /* --- FORM CARD & INPUTS --- */
    .custom-card { 
        background: #fff; border-radius: 30px; border: 1px solid #e2e8f0; 
        box-shadow: 0 25px 50px rgba(0,0,0,0.03); 
    }

    .form-section-title { 
        display: flex; align-items: center; margin-bottom: 25px; 
        padding-bottom: 15px; border-bottom: 2px solid #f8fafc; 
    }

    .form-section-title i { 
        font-size: 1.25rem; color: #0061ff; margin-right: 12px; 
        background: #ebf2ff; padding: 10px; border-radius: 12px; 
    }

    .form-section-title h5 { margin-bottom: 0; font-weight: 800; color: #1e293b; letter-spacing: -0.5px; }

    .form-control { 
        border-radius: 15px; padding: 14px 20px; border: 2px solid #f1f5f9; 
        background-color: #f8fafc; transition: all 0.2s ease; 
    }

    .form-control:focus { 
        border-color: #0061ff; background-color: #fff !important; 
        box-shadow: 0 0 0 5px rgba(0, 97, 255, 0.1); 
    }

    .upload-zone { 
        border: 2px dashed #cbd5e0; border-radius: 20px; padding: 40px; 
        background-color: #f8fafc; transition: all 0.3s ease; 
        position: relative;
    }

    .upload-zone:hover { border-color: #0061ff; background-color: #f0f7ff; }
    
    .upload-zone.is-invalid { border-color: #dc3545; }

    .btn-kirim { 
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%); 
        border: none; border-radius: 18px; padding: 20px; 
        font-weight: 800; letter-spacing: 1px; transition: all 0.3s ease; 
        color: white;
    }

    .btn-kirim:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0, 97, 255, 0.4); color: white; }
</style>
@endpush

@section('content')
<div class="page-pengaduan">
    
    <header class="hero-header" data-aos="fade-down">
        <div class="container">
            <h1 class="title-top">Layanan</h1>
            <span class="title-bottom">Pengaduan IT</span>
            <p class="description">
                Sampaikan kendala teknis atau kebutuhan infrastruktur IT Anda secara langsung untuk penanganan yang cepat dan terukur.
            </p>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="nav-toggle-container" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ route('pengaduan.create') }}" 
                       class="nav-toggle-btn {{ Request::routeIs('pengaduan.create') ? 'active' : 'inactive' }}">
                        <i class="bi bi-pencil-square"></i> Buat Laporan
                    </a>
                    <a href="{{ route('pengaduan.index') }}" 
                       class="nav-toggle-btn {{ Request::routeIs('pengaduan.index') ? 'active' : 'inactive' }}">
                        <i class="bi bi-clock-history"></i> Riwayat Laporan
                    </a>
                </div>

                <div class="card custom-card p-4 p-md-5 mb-5" data-aos="fade-up" data-aos-delay="200">
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-section-title">
                            <i class="bi bi-person-badge-fill"></i>
                            <h5>Data Pelapor</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Email Institusi</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="bi bi-whatsapp me-1 text-success"></i> No. WhatsApp Aktif <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp_pengadu" class="form-control @error('no_hp_pengadu') is-invalid @enderror" placeholder="Contoh: 081234567890" value="{{ old('no_hp_pengadu') }}" required>
                            @error('no_hp_pengadu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="my-5" style="border-top: 2px dashed #f1f5f9;"></div>

                        <div class="form-section-title">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <h5>Detail Laporan Kendala</h5>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Kendala <span class="text-danger">*</span></label>
                            <input type="text" name="judul_pengaduan" class="form-control @error('judul_pengaduan') is-invalid @enderror" placeholder="Misal: WiFi Lab Tidak Bisa Connect" value="{{ old('judul_pengaduan') }}" required>
                            @error('judul_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Masalah <span class="text-danger">*</span></label>
                            <textarea name="isi_pengaduan" class="form-control @error('isi_pengaduan') is-invalid @enderror" rows="5" placeholder="Jelaskan secara detail kendala yang dialami..." required>{{ old('isi_pengaduan') }}</textarea>
                            @error('isi_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- BAGIAN DOKUMENTASI (WAJIB) -->
                        <div class="mb-5">
                            <label class="form-label fw-bold">Dokumentasi / Bukti Kendala <span class="text-danger">*</span></label>
                            <div class="upload-zone text-center @error('url_lampiran') is-invalid @enderror">
                                <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-2"></i>
                                <input type="file" name="url_lampiran" class="form-control border-0 bg-transparent @error('url_lampiran') is-invalid @enderror" accept="image/*,.pdf" required>
                                <p class="small text-muted mt-2 mb-0">Klik untuk upload foto atau PDF bukti kendala</p>
                                <p class="badge bg-soft-primary text-primary fw-normal mt-2">Wajib diisi (Maks. 2MB)</p>
                                
                                @error('url_lampiran')
                                    <div class="text-danger small mt-2 d-block fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-kirim btn-lg shadow-sm">
                                <i class="bi bi-send-check-fill me-2"></i> KIRIM LAPORAN SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({ duration: 1000, once: true });
    });
</script>
@endpush