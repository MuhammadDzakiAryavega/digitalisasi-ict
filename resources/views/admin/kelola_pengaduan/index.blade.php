@extends('layouts.dashboard')

@section('title', 'Kelola Pengaduan - Unit IT')

@section('content')
<style>
    /* Dasar & Card Layout */
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: #ffffff; }
    .btn-gradient { background: linear-gradient(135deg, #0061ff 0%, #60efff 100%); border: none; color: white; transition: all 0.3s ease; font-weight: bold; }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3); color: white; }

    /* Header Tabel */
    .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; color: #858796; padding: 1.25rem; border-bottom: 1px solid #e3e6f0; }
    .table tbody td { padding: 1.25rem; vertical-align: middle; color: #5a5c69; transition: all 0.2s; }
    .table tbody tr:hover td { background-color: #f8faff; }

    /* Status Badge (Soft UI) */
    .status-badge { 
        font-size: 0.65rem; 
        font-weight: 800; 
        padding: 6px 14px; 
        border-radius: 8px; 
        text-transform: uppercase; 
        display: inline-block;
        white-space: nowrap; 
        letter-spacing: 0.5px;
    }

    .status-baru { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; } 
    .status-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; } 
    .status-proses { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; } 
    .status-selesai { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; } 
    .status-decline { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* Petugas Badge */
    .anggota-tag { background-color: #f8fafc; color: #475569; padding: 6px 12px; border-radius: 10px; font-size: 0.8rem; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; font-weight: 500; }

    /* Tombol Aksi */
    .action-btn { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.2s; border: none; text-decoration: none; cursor: pointer; }
    .btn-view { background-color: #f0fdf4; color: #16a34a; }
    .btn-view:hover { background-color: #16a34a; color: white; }
    .btn-edit { background-color: #eef2ff; color: #4338ca; }
    .btn-edit:hover { background-color: #4338ca; color: white; }
    .btn-delete { background-color: #fff1f2; color: #be123c; }
    .btn-delete:hover { background-color: #be123c; color: white; }

    /* Modal Styling */
    .modal-content { border-radius: 20px; border: none; }
    .form-select:focus { border-color: #60efff; box-shadow: 0 0 0 0.25rem rgba(96, 239, 255, 0.1); }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Kelola Pengaduan</h3>
            <p class="text-muted small">Monitor laporan masuk dan tugaskan anggota IT.</p>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter Section --}}
    <div class="card card-custom mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.pengaduan.index') }}" method="GET" class="row g-2">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" style="border-radius: 0 10px 10px 0;" placeholder="Cari nama pelapor atau judul..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" style="border-radius: 10px;">
                        <option value="">Semua Status</option>
                        @foreach(['Baru', 'Pending', 'Dalam Proses', 'Selesai', 'Decline'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-gradient w-100 py-2 rounded-3">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="card card-custom">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Petugas / Disposisi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduans as $item)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama_pengadu }}</div>
                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="text-dark fw-bold small mb-1">{{ $item->judul_pengaduan }}</div>
                                <div class="text-muted small">{{ Str::limit($item->isi_pengaduan, 45) }}</div>
                            </td>
                            <td>
                                @if($item->id_anggota && $item->anggota)
                                    <div class="anggota-tag">
                                        <i class="bi bi-person-circle me-2 text-primary"></i> {{ $item->anggota->nama_anggota }}
                                    </div>
                                @else
                                    <span class="text-danger small fw-bold"><i class="bi bi-exclamation-triangle me-1"></i> Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $class = match($item->status_pengaduan) {
                                        'Baru' => 'status-baru',
                                        'Pending' => 'status-pending',
                                        'Dalam Proses' => 'status-proses',
                                        'Selesai' => 'status-selesai',
                                        'Decline' => 'status-decline',
                                        default => 'bg-light text-dark'
                                    };
                                @endphp
                                <span class="status-badge {{ $class }}">
                                    {{ $item->status_pengaduan }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.pengaduan.show', $item->id_pengaduan) }}" class="action-btn btn-view shadow-sm" data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <button type="button" class="action-btn btn-edit shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $item->id_pengaduan }}" title="Update Status">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <form action="{{ route('admin.pengaduan.destroy', $item->id_pengaduan) }}" method="POST" class="d-inline delete-form">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete shadow-sm btn-confirm-delete" title="Hapus">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Update --}}
                        <div class="modal fade" id="modalUpdate{{ $item->id_pengaduan }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg">
                                    <form action="{{ route('admin.pengaduan.update-status', $item->id_pengaduan) }}" method="POST" class="status-update-form">
                                        @csrf 
                                        @method('PUT')
                                        <div class="modal-header border-0 pb-0 mt-2 px-4">
                                            <h5 class="fw-bold">Update Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted text-uppercase">Tugaskan Petugas</label>
                                                <select name="id_anggota" class="form-select py-2" style="border-radius: 10px;" required>
                                                    <option value="" disabled {{ !$item->id_anggota ? 'selected' : '' }}>-- Pilih Anggota IT --</option>
                                                    @foreach($anggotas as $agt)
                                                        <option value="{{ $agt->id_anggota }}" {{ $item->id_anggota == $agt->id_anggota ? 'selected' : '' }}>
                                                            {{ $agt->nama_anggota }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold small text-muted text-uppercase">Status Pengerjaan</label>
                                                <select name="status_pengaduan" class="form-select py-2" style="border-radius: 10px;">
                                                    @foreach(['Baru', 'Pending', 'Dalam Proses', 'Selesai', 'Decline'] as $st)
                                                        <option value="{{ $st }}" {{ $item->status_pengaduan == $st ? 'selected' : '' }}>{{ $st }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="submit" class="btn btn-gradient w-100 py-3 rounded-3 shadow">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada data pengaduan yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Tooltip Initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // 2. Auto-hide Alerts (5 detik)
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // 3. Loading Animation on Modal Submit
        const statusForms = document.querySelectorAll('.status-update-form');
        statusForms.forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('.btn-gradient');
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
                btn.classList.add('disabled');
            });
        });

        // 4. Enhanced Delete Confirmation
        const deleteButtons = document.querySelectorAll('.btn-confirm-delete');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                if(!confirm('Apakah Anda yakin ingin menghapus data laporan ini? Tindakan ini tidak dapat dibatalkan.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection