@extends('layouts.dashboard')

@section('title', 'Edit User - Unit IT')

@push('styles')
<style>
    /* 1. Card & Layout Styling */
    .card-custom {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    /* 2. Custom Input Focus - Tema Kuning */
    .custom-input {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        transition: all 0.3s ease;
        background-color: #fcfcfc;
    }

    .custom-input:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.1);
        background-color: #fff;
    }

    /* 3. Button Styling - Kuning Gradient */
    .btn-update {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        color: #3e2723;
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

    /* 4. Label & Typography */
    .form-label {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #795548;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .input-group-text {
        background-color: #fffdf5;
        border: 1px solid #e2e8f0;
        border-radius: 10px 0 0 10px;
        color: #ffc107;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-person-gear text-warning me-2"></i>Ubah Data: {{ $user->name }}
            </h3>
            <p class="text-muted small">Pastikan informasi NIK dan Role sudah sesuai dengan jabatan saat ini.</p>
        </div>
        <a href="{{ route('admin.kelola-user.index') }}" class="btn btn-cancel px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('admin.kelola-user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control custom-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" placeholder="Nama sesuai KTP" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NIK (Nomor Induk Karyawan)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" name="nik" class="form-control custom-input" 
                                       value="{{ old('nik', $user->nik) }}" placeholder="Contoh: 19920811...">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" placeholder="email@pnp.ac.id" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Hak Akses / Role</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <select name="is_admin" class="form-select custom-input">
                                    <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>Pengguna Biasa (User)</option>
                                    <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Administrator (Admin)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-2 p-3 bg-light rounded-3">
                            <label class="form-label mb-1">Ganti Password</label>
                            <input type="password" name="password" class="form-control custom-input" placeholder="Isi hanya jika ingin ganti password">
                            <div class="form-text small text-muted">
                                <i class="bi bi-info-circle me-1"></i> Kosongkan jika tidak ada perubahan keamanan.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-update px-5 py-3 shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i> Update Informasi User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection