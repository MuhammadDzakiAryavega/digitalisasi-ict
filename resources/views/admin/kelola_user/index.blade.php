@extends('layouts.dashboard')

@section('title', 'Kelola User - Unit IT')

@section('content')
<style>
    /* Dasar & Card Layout */
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: #ffffff; }
    .btn-gradient { background: linear-gradient(135deg, #0061ff 0%, #60efff 100%); border: none; color: white; transition: all 0.3s ease; font-weight: bold; }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3); color: white; }

    /* Header Tabel */
    .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; color: #858796; padding: 1.25rem; border-bottom: 1px solid #e3e6f0; }
    .table tbody td { padding: 1.25rem; vertical-align: middle; color: #5a5c69; }

    /* Status Badge (Soft UI) */
    .role-badge { 
        font-size: 0.65rem; 
        font-weight: 800; 
        padding: 6px 14px; 
        border-radius: 8px; 
        text-transform: uppercase; 
        display: inline-block;
        letter-spacing: 0.5px;
    }
    .role-admin { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; } 
    .role-user { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

    /* Tombol Aksi */
    .action-btn { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.2s; border: none; }
    .btn-edit { background-color: #eef2ff; color: #4338ca; }
    .btn-edit:hover { background-color: #4338ca; color: white; }
    .btn-delete { background-color: #fff1f2; color: #be123c; }
    .btn-delete:hover { background-color: #be123c; color: white; }

    /* Avatar Placeholder */
    .avatar-circle { width: 40px; height: 40px; background-color: #f0f2f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #0061ff; }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Data Pengguna</h3>
            <p class="text-muted small">Kelola hak akses dan informasi profil pengguna sistem.</p>
        </div>
        <a href="{{ route('admin.kelola-user.create') }}" class="btn btn-gradient px-4 py-2 shadow-sm rounded-3">
            <i class="bi bi-plus-lg me-2"></i> Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Table Section --}}
    <div class="card card-custom">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Profil Pengguna</th>
                            <th>Identitas (NIK)</th>
                            <th>Kontak Email</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->no_telepon ?? 'No Telp -' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark fw-medium" style="border-radius: 6px; padding: 5px 10px;">
                                    <i class="bi bi-card-text me-1 text-muted"></i> {{ $user->nik ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-dark">{{ $user->email }}</div>
                            </td>
                            <td class="text-center">
                                @if($user->is_admin == 1)
                                    <span class="role-badge role-admin">Administrator</span>
                                @else
                                    <span class="role-badge role-user">User Biasa</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.kelola-user.edit', $user->id) }}" class="action-btn btn-edit shadow-sm text-decoration-none">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.kelola-user.destroy', $user->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete shadow-sm" onclick="return confirm('Hapus user {{ $user->name }}?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-25" alt="Empty">
                                <p class="text-muted">Belum ada data pengguna yang terdaftar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection