@extends('layouts.dashboard')

@section('title', 'Kelola Anggota - Unit ICT')

@section('content')
<style>
    /* --- Layout & Card Style --- */
    .card-custom { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); background: #ffffff; }
    
    /* --- Button Tambah (Persis Gambar) --- */
    .btn-tambah { 
        background: linear-gradient(to right, #0052ff, #43d4ff); 
        border: none; 
        color: white; 
        padding: 10px 32px; 
        border-radius: 50px; /* Bentuk Pill Lonjong */
        font-weight: 600; 
        font-size: 1.1rem;
        display: inline-flex; 
        align-items: center; 
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 82, 255, 0.2);
        text-decoration: none;
    }
    .btn-tambah:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 6px 20px rgba(0, 82, 255, 0.3); 
        color: white; 
        opacity: 0.9;
    }
    .btn-tambah i { font-size: 1.4rem; margin-right: 12px; font-weight: bold; }

    /* --- Table Design --- */
    .table thead th { 
        background-color: #f8f9fc; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 1px; 
        color: #4e73df; 
        padding: 1.25rem; 
        border-bottom: 2px solid #eaecf4; 
    }
    .table tbody td { padding: 1.25rem; vertical-align: middle; border-bottom: 1px solid #f1f3f9; }
    
    /* --- Avatar Style --- */
    .avatar-circle { 
        width: 45px; height: 45px; border-radius: 12px; 
        background: #eef2ff; color: #4e73df; 
        display: flex; align-items: center; justify-content: center; 
        font-weight: 800; font-size: 1.1rem; 
    }

    /* --- Badge Pangkat --- */
    .badge-pangkat { 
        background-color: #f0f7ff; color: #0061ff; border-radius: 8px; 
        padding: 6px 14px; font-size: 0.75rem; font-weight: 700;
    }

    /* --- Action Buttons --- */
    .action-btn { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.2s; border: none; }
    .btn-edit { background-color: #f6f9ff; color: #4e73df; }
    .btn-edit:hover { background-color: #4e73df; color: white; }
    .btn-delete { background-color: #fff5f5; color: #e74a3b; }
    .btn-delete:hover { background-color: #e74a3b; color: white; }
</style>

<div class="container-fluid py-4">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark mb-1">Daftar Anggota</h3>
            <p class="text-muted small mb-0">Manajemen data personil Unit IT.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.kelola-anggota.create') }}" class="btn-tambah">
                <i class="bi bi-plus-lg"></i> Tambah Anggota
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card card-custom">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama Lengkap</th>
                        <th class="text-center">Jabatan / Pangkat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    {{ strtoupper(substr($item->nama_anggota, 0, 1)) }}
                                </div>
                                <div class="fw-bold text-dark fs-6">{{ $item->nama_anggota }}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-pangkat">{{ $item->pangkat }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.kelola-anggota.edit', $item->id_anggota) }}" class="action-btn btn-edit shadow-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <form action="{{ route('admin.kelola-anggota.destroy', $item->id_anggota) }}" method="POST" id="delete-form-{{ $item->id_anggota }}">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="action-btn btn-delete shadow-sm" onclick="confirmDelete('{{ $item->id_anggota }}', '{{ $item->nama_anggota }}')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted small">Data anggota belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Anggota " + name + " akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush