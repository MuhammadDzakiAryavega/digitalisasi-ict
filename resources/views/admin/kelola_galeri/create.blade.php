@extends('layouts.dashboard')

@section('title', 'Tambah Kegiatan - Unit ICT')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #0061ff 0%, #60efff 100%);
        --soft-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: var(--soft-shadow);
    }

    .form-label {
        font-weight: 600;
        color: #4e73df;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border: 1px solid #e3e6f0;
    }

    .form-control:focus {
        border-color: #60efff;
        box-shadow: 0 0 0 0.2rem rgba(96, 239, 255, 0.25);
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3);
        color: white;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Tambah Kegiatan</h3>
            <p class="text-muted small">Buat dokumentasi kegiatan baru untuk unit ICT.</p>
        </div>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm fw-bold">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-body p-4">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label class="form-label">Judul Kegiatan</label>
                            <input type="text" name="judul_kegiatan" class="form-control" placeholder="Masukkan judul kegiatan..." required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" class="form-control" rows="6" placeholder="Tuliskan deskripsi singkat kegiatan di sini..." required></textarea>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <label class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_kegiatan" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Upload Thumbnail</label>
                            <div class="border rounded-3 p-3 text-center bg-light">
                                <i class="bi bi-cloud-arrow-up display-6 text-muted"></i>
                                <input type="file" name="gambar" class="form-control mt-2" required>
                                <small class="text-muted d-block mt-2">Format: JPG, PNG (Maks. 2MB)</small>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient py-3 fw-bold rounded-pill">
                                <i class="bi bi-check-circle-fill me-2"></i> Simpan Kegiatan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection