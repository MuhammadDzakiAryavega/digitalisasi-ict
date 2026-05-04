@extends('layouts.dashboard') {{-- Menggunakan layout dashboard --}}

@section('title', 'Tambah Anggota - Unit ICT')

@push('styles')
<style>
    .form-container { max-width: 700px; margin: 0 auto; }

    .custom-card {
        background: #ffffff;
        border-radius: 25px;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .custom-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 6px;
        background: linear-gradient(90deg, #0061ff, #60a5fa);
    }

    .header-icon {
        width: 60px; height: 60px;
        background: #ebf2ff; color: #0061ff;
        display: flex; align-items: center; justify-content: center;
        border-radius: 18px; font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .form-label { font-weight: 700; color: #4a5568; font-size: 0.9rem; }
    
    .form-control, .form-select {
        border-radius: 12px; padding: 12px 18px;
        border: 2px solid #edf2f7;
        transition: all 0.3s;
        background-color: #f8fafc;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0061ff;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(0, 97, 255, 0.1);
    }

    .btn-save {
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%);
        color: white !important; border: none; border-radius: 14px;
        padding: 14px; font-weight: 700;
        box-shadow: 0 10px 20px rgba(0, 97, 255, 0.2);
    }

    .btn-cancel {
        border-radius: 14px; padding: 14px;
        font-weight: 700; color: #718096;
        border: 2px solid #edf2f7; background: #fff;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.kelola-anggota.index') }}" class="text-decoration-none">Kelola Anggota</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Tambah Baru</li>
        </ol>
    </nav>

    <div class="card custom-card">
        <div class="d-flex flex-column align-items-center mb-4">
            <div class="header-icon shadow-sm">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">Registrasi Anggota</h4>
            <p class="text-muted small">Tambahkan personel baru ke dalam sistem ICT</p>
        </div>
        
        <form action="{{ route('admin.kelola-anggota.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_anggota" class="form-control @error('nama_anggota') is-invalid @enderror" 
                       placeholder="Contoh: Muhammad Dzaki" value="{{ old('nama_anggota') }}" required>
                @error('nama_anggota') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Jabatan / Pangkat</label>
                <select name="pangkat" class="form-select @error('pangkat') is-invalid @enderror" required>
                    <option value="" selected disabled>Pilih Jabatan</option>
                    <option value="IT Office">ict office</option>
                    <option value="Supervisor">supervisor</option>
                    <option value="Manage Service Infrastructure">manage service infrastruktur</option>
                    <option value="Manage Service Wifi">manage service wifi</option>
                    <option value="It Support">It Support</option>
                </select>
                @error('pangkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3">
                <div class="col-8">
                    <button type="submit" class="btn btn-save w-100">
                        <i class="bi bi-check-circle-fill me-2"></i>Simpan Data
                    </button>
                </div>
                <div class="col-4">
                    <a href="{{ route('admin.kelola-anggota.index') }}" class="btn btn-cancel w-100 text-center text-decoration-none">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection