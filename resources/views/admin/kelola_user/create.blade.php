@extends('layouts.dashboard')

@section('title', 'Tambah User - Unit IT')

@push('styles')
<style>
    /* 1. Card & Layout Styling */
    .card-custom {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    /* 2. Custom Input Focus - Tema Biru */
    .custom-input {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .custom-input:focus {
        border-color: #0061ff;
        box-shadow: 0 0 0 0.25rem rgba(0, 97, 255, 0.1);
        background-color: #fff;
    }

    /* 3. Button Styling - Biru Gradient */
    .btn-save {
        background: linear-gradient(135deg, #0061ff 0%, #60efff 100%);
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        color: white;
        font-weight: bold;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3);
        color: white;
    }

    .btn-back {
        color: #64748b;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        color: #0061ff;
    }

    /* 4. Label & Typography */
    .form-label {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #475569;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .input-group-text {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px 0 0 10px;
        color: #0061ff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <a href="{{ route('admin.kelola-user.index') }}" class="btn-back text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
            <h3 class="fw-bold text-dark mt-2 mb-1">
                <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Pengguna Baru
            </h3>
            <p class="text-muted small">Daftarkan akun administrator atau pengguna baru ke dalam sistem.</p>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('admin.kelola-user.store') }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    {{-- Nama Lengkap --}}
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control custom-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Masukkan nama lengkap..." required>
                            </div>
                        </div>
                    </div>

                    {{-- NIK --}}
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">NIK (16 Digit)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" name="nik" class="form-control custom-input" 
                                       maxlength="16" value="{{ old('nik') }}" placeholder="Masukkan NIK...">
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control custom-input" 
                                       value="{{ old('email') }}" placeholder="email@contoh.com" required>
                            </div>
                        </div>
                    </div>

                    {{-- No Telepon --}}
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="no_telepon" class="form-control custom-input" 
                                       value="{{ old('no_telepon') }}" placeholder="08xxxxxx">
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="col-md-12">
                        <div class="mb-1">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control custom-input" rows="3" placeholder="Masukkan alamat domisili...">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Password Akun</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control custom-input" 
                                       placeholder="Buat password minimal 8 karakter" required>
                            </div>
                        </div>
                    </div>

                    {{-- Role User --}}
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Hak Akses / Role</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                <select name="is_admin" class="form-select custom-input">
                                    <option value="0" selected>Pengguna Biasa (User)</option>
                                    <option value="1">Administrator (Admin)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-save px-5 py-3 shadow-sm">
                            <i class="bi bi-person-check-fill me-2"></i> Simpan Data Pengguna
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection