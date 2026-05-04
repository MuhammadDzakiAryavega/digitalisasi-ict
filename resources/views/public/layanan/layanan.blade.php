@extends('layouts.app')

@section('title', 'Layanan Pengaduan - Unit ICT')

@push('styles')
<style>
    body { background-color: #f4f7fa; }
    .nav-toggle-container {
        display: flex; background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px); border-radius: 16px; padding: 7px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.04); margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .nav-toggle-btn {
        flex: 1; padding: 12px; text-align: center; border-radius: 12px;
        text-decoration: none; font-weight: 700; transition: all 0.3s ease;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .nav-toggle-btn.active {
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%);
        color: #fff !important; box-shadow: 0 4px 15px rgba(0, 97, 255, 0.3);
    }
    .nav-toggle-btn.inactive { color: #7d879c !important; }
    .nav-toggle-btn.inactive:hover { background-color: #ebf2ff; color: #0061ff !important; }
    
    .custom-card { background-color: #ffffff; border-radius: 24px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
    .form-section-title { display: flex; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f2f5; }
    .form-section-title i { font-size: 1.5rem; color: #0061ff; margin-right: 12px; background: #ebf2ff; padding: 10px; border-radius: 12px; }
    .form-section-title h5 { margin-bottom: 0; font-weight: 800; color: #2d3748; }
    
    .form-label { font-weight: 700; font-size: 0.85rem; color: #4a5568; margin-bottom: 10px; }
    .form-control { border-radius: 12px; padding: 12px 18px; border: 2px solid #edf2f7; background-color: #fdfdfd; color: #2d3748; transition: all 0.2s ease; }
    .form-control:focus { border-color: #0061ff; background-color: #fff !important; box-shadow: 0 0 0 4px rgba(0, 97, 255, 0.1); }
    
    .upload-zone { border: 2px dashed #cbd5e0; border-radius: 16px; padding: 25px; background-color: #f8fafc; transition: all 0.3s ease; position: relative; }
    .upload-zone:hover { border-color: #0061ff; background-color: #ebf2ff; }
    
    .btn-kirim { background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%); border: none; border-radius: 15px; padding: 18px; font-weight: 800; letter-spacing: 1px; color: white; box-shadow: 0 10px 20px rgba(0, 97, 255, 0.2); transition: transform 0.2s; }
    .btn-kirim:hover { transform: translateY(-2px); color: white; }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Navigasi Tab --}}
            <div class="nav-toggle-container">
                <a href="{{ route('pengaduan.create') }}" class="nav-toggle-btn active">
                    <i class="bi bi-pencil-square"></i> Buat Pengaduan
                </a>
                <a href="{{ route('pengaduan.index') }}" class="nav-toggle-btn inactive">
                    <i class="bi bi-clock-history"></i> Riwayat Pengaduan
                </a>
            </div>

            <div class="card custom-card p-4 p-md-5">
                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-section-title">
                        <i class="bi bi-person-check-fill"></i>
                        <h5>Data Pelapor</h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" disabled>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Email Institusi</label>
                            <input type="email" class="form-control bg-light" value="{{ auth()->user()->email }}" disabled>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-whatsapp me-1"></i> No. WhatsApp Aktif</label>
                        <input type="text" name="no_hp_pengadu" class="form-control @error('no_hp_pengadu') is-invalid @enderror" placeholder="Contoh: 081234567890" value="{{ old('no_hp_pengadu') }}" required>
                        @error('no_hp_pengadu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="my-5" style="border-top: 2px dashed #f0f2f5;"></div>

                    <div class="form-section-title">
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <h5>Detail Laporan Kendala</h5>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Judul Kendala</label>
                        <input type="text" name="judul_pengaduan" class="form-control @error('judul_pengaduan') is-invalid @enderror" placeholder="Misal: WiFi Lab Tidak Bisa Connect" value="{{ old('judul_pengaduan') }}" required>
                        @error('judul_pengaduan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Deskripsi Masalah</label>
                        <textarea name="isi_pengaduan" class="form-control @error('isi_pengaduan') is-invalid @enderror" rows="5" placeholder="Jelaskan secara detail kendala yang dialami..." required>{{ old('isi_pengaduan') }}</textarea>
                        @error('isi_pengaduan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Dokumentasi / Bukti (Opsional)</label>
                        <div class="upload-zone text-center @error('url_lampiran') border-danger @enderror">
                            <i class="bi bi-cloud-arrow-up fs-2 text-primary mb-2"></i>
                            <input type="file" name="url_lampiran" class="form-control border-0 bg-transparent" accept="image/png, image/jpeg, image/jpg, image/webp, .pdf">
                            <p class="small text-muted mt-2 mb-0">Klik untuk pilih file (Format: JPG, PNG, PDF | Maks. 2MB)</p>
                            @error('url_lampiran')
                                <div class="text-danger small mt-2">{{ $message }}</div>
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
@endsection