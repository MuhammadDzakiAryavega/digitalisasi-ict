@extends('layouts.dashboard')

@section('title', 'Update Anggota - Unit ICT')

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

    /* Aksen Warna Orange/Amber untuk Update */
    .custom-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 6px;
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .header-icon {
        width: 60px; height: 60px;
        background: #fff8eb; color: #d97706;
        display: flex; align-items: center; justify-content: center;
        border-radius: 18px; font-size: 1.5rem;
        margin-bottom: 20px;
        box-shadow: 0 10px 20px rgba(217, 119, 6, 0.1);
    }

    .form-label { font-weight: 700; color: #2d3748; font-size: 0.9rem; }
    
    .form-control, .form-select {
        border-radius: 12px; padding: 12px 18px;
        border: 2px solid #fef3c7;
        transition: all 0.3s;
        background-color: #fffcf5;
    }

    .form-control:focus, .form-select:focus {
        border-color: #f59e0b;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }

    .btn-update {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white !important; border: none; border-radius: 14px;
        padding: 14px; font-weight: 700;
        box-shadow: 0 10px 20px rgba(217, 119, 6, 0.2);
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(217, 119, 6, 0.3);
    }

    .btn-cancel {
        border-radius: 14px; padding: 14px;
        font-weight: 700; color: #718096;
        border: 2px solid #edf2f7; background: #fff;
        transition: all 0.3s;
    }
    
    .btn-cancel:hover { background: #f8fafc; color: #1a202c; }
</style>
@endpush

@section('content')
<div class="form-container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.kelola-anggota.index') }}" class="text-decoration-none text-muted">Daftar Anggota</a></li>
            <li class="breadcrumb-item active fw-bold" style="color: #d97706;" aria-current="page">Update Data</li>
        </ol>
    </nav>

    <div class="card custom-card">
        <div class="d-flex flex-column align-items-center mb-4 text-center">
            <div class="header-icon shadow-sm">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">Update Informasi</h4>
            <p class="text-muted small">Memperbarui data personel: <span class="badge bg-light text-dark border px-2 py-1">{{ $anggota->nama_anggota }}</span></p>
        </div>
        
        <form action="{{ route('admin.kelola-anggota.update', ['anggota' => $anggota->id_anggota]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-person-vcard me-2"></i>Nama Lengkap</label>
                <input type="text" name="nama_anggota" 
                       class="form-control @error('nama_anggota') is-invalid @enderror" 
                       value="{{ old('nama_anggota', $anggota->nama_anggota) }}" required>
                @error('nama_anggota') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
    <label class="form-label"><i class="bi bi-shield-check me-2"></i>Pangkat / Jabatan</label>
    {{-- Ganti name menjadi 'pangkat' --}}
    <select name="pangkat" class="form-select @error('pangkat') is-invalid @enderror" required>
        <option value="" disabled {{ is_null($anggota->pangkat) ? 'selected' : '' }}>Pilih Pangkat</option>
        <option value="IT Office" {{ old('pangkat', $anggota->pangkat) == 'IT Office' ? 'selected' : '' }}>ict office</option>
        <option value="Supervisor" {{ old('pangkat', $anggota->pangkat) == 'Supervisor' ? 'selected' : '' }}>supervisor</option>
        <option value="Manage Service Infrastructure" {{ old('pangkat', $anggota->pangkat) == 'Manage Service Infrastructure' ? 'selected' : '' }}>manage service infrastruktur</option>
        <option value="Manage Service Wifi" {{ old('pangkat', $anggota->pangkat) == 'Manage Service Wifi' ? 'selected' : '' }}>manage service wifi</option>
        <option value="It Support" {{ old('pangkat', $anggota->pangkat) == 'It Support' ? 'selected' : '' }}>It Support</option>
    </select>
    @error('pangkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
            <div class="row g-3">
                <div class="col-8">
                    <button type="submit" class="btn btn-update w-100">
                        <i class="bi bi-save2-fill me-2"></i>Simpan Update
                    </button>
                </div>
                <div class="col-4">
                    <a href="{{ route('admin.kelola-anggota.index') }}" class="btn btn-cancel w-100 text-center text-decoration-none d-flex align-items-center justify-content-center">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection