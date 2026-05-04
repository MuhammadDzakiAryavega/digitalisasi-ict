@extends('layouts.dashboard')

@section('title', 'Edit Kegiatan - Unit ICT')

@push('styles')
<style>
    /* 1. Card & Layout Styling */
    .card-custom {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    /* 2. Custom Input Focus - Kuning Accent */
    .custom-input {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        transition: all 0.3s ease;
        background-color: #fcfcfc;
    }

    .custom-input:focus {
        border-color: #ffc107; /* Warna Kuning */
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.1);
        background-color: #fff;
    }

    /* 3. Image Preview Area */
    .image-preview-container {
        border-radius: 12px;
        border: 2px dashed #ffda6a !important; /* Border Kuning Putus-putus */
        background-color: #fffdf5;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hover-zoom {
        transition: transform 0.3s ease;
        max-height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }

    .hover-zoom:hover {
        transform: scale(1.05);
    }

    /* 4. Button Styling - Kuning ke Oranye Gradient */
    .btn-update {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        color: #5d4037; /* Teks cokelat gelap agar lebih kontras di atas kuning */
        font-weight: bold;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(253, 160, 133, 0.4);
        color: #3e2723;
    }

    .btn-cancel {
        border-radius: 10px;
        background: #f1f5f9;
        color: #64748b;
        font-weight: 600;
        border: none;
    }

    /* 5. Typography */
    .form-label {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #795548; /* Warna cokelat agar senada dengan kuning */
    }

    .text-warning-custom {
        color: #efa31d;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-pencil-fill text-warning-custom me-2"></i>Edit Kegiatan
            </h3>
            <p class="text-muted small">Perbarui data dokumentasi galeri Unit ICT.</p>
        </div>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-cancel px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('admin.galeri.update', ['galeri' => $galeri->id_kegiatan]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Kegiatan</label>
                            <input type="text" name="judul_kegiatan" 
                                   class="form-control form-control-lg custom-input @error('judul_kegiatan') is-invalid @enderror" 
                                   value="{{ old('judul_kegiatan', $galeri->judul_kegiatan) }}" 
                                   placeholder="Masukkan judul..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Kegiatan</label>
                            <textarea name="deskripsi_singkat" 
                                      class="form-control custom-input @error('deskripsi_singkat') is-invalid @enderror" 
                                      rows="6" placeholder="Berikan detail kegiatan..." required>{{ old('deskripsi_singkat', $galeri->deskripsi_singkat) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal_kegiatan" 
                                       class="form-control custom-input @error('tanggal_kegiatan') is-invalid @enderror" 
                                       value="{{ old('tanggal_kegiatan', $galeri->tanggal_kegiatan) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block mb-3">Visual Dokumentasi</label>
                            <div class="image-preview-container p-2 mb-3 shadow-sm">
                                @if($galeri->thumbnail_url)
                                    <img src="{{ asset('storage/' . $galeri->thumbnail_url) }}" 
                                         alt="Preview" class="img-fluid hover-zoom shadow-sm">
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-image-fill fs-1 opacity-25 text-warning"></i>
                                        <p class="small mt-2 mb-0">Tidak ada gambar</p>
                                    </div>
                                @endif
                            </div>
                            
                            <label class="form-label fw-bold text-warning-custom">Ganti Gambar Baru</label>
                            <input type="file" name="gambar" class="form-control custom-input @error('gambar') is-invalid @enderror">
                            <div class="form-text small mt-2">
                                <i class="bi bi-info-circle-fill me-2 text-warning"></i>
                                <span>Format: PNG, JPG (Maks. 2MB)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-update px-5 py-3 shadow-sm text-dark">
                            <i class="bi bi-check-circle-fill me-2"></i> Perbarui Data Kegiatan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection