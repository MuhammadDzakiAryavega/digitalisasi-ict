@extends('layouts.dashboard')

@section('title', 'Kelola Pengaduan - Unit IT')

@push('styles')
<style>
    /* --- CSS DASAR & TABEL --- */
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: #ffffff; }
    .btn-gradient { background: linear-gradient(135deg, #0061ff 0%, #60efff 100%); border: none; color: white; transition: all 0.3s ease; font-weight: bold; }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3); color: white; }
    
    .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; color: #858796; padding: 1.25rem; border-bottom: 1px solid #e3e6f0; }
    .table tbody td { padding: 1.25rem; vertical-align: middle; color: #5a5c69; transition: all 0.2s; }
    .table tbody tr:hover td { background-color: #f8faff; }
    
    /* --- STATUS BADGE --- */
    .status-badge { font-size: 0.65rem; font-weight: 800; padding: 6px 14px; border-radius: 8px; text-transform: uppercase; display: inline-block; white-space: nowrap; letter-spacing: 0.5px; }
    .status-baru { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; } 
    .status-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; } 
    .status-proses { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; } 
    .status-selesai { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; } 
    .status-decline { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* --- TAGS DI TABEL --- */
    .anggota-wrapper { display: flex; flex-wrap: wrap; gap: 4px; max-width: 200px; }
    .anggota-tag { background-color: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; border: 1px solid #e2e8f0; font-weight: 500; display: inline-flex; align-items: center; }
    
    .action-btn { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; border: none; text-decoration: none; }
    .btn-view { background-color: #f0fdf4; color: #16a34a; }
    .btn-edit { background-color: #eef2ff; color: #4338ca; }
    .btn-delete { background-color: #fff1f2; color: #be123c; }

    /* --- CUSTOM CHECKBOX AREA (GAMBAR 5 STYLE) --- */
    .checkbox-scroll-area {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
        max-height: 210px; /* Batasi tinggi agar muncul scroll jika data banyak */
        overflow-y: auto;
        background-color: #ffffff;
    }
    
    /* Scrollbar minimalis */
    .checkbox-scroll-area::-webkit-scrollbar { width: 5px; }
    .checkbox-scroll-area::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    .form-check-custom {
        padding: 8px 10px;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    .form-check-custom:hover { background-color: #f8faff; }
    
    .form-check-input { width: 1.1rem; height: 1.1rem; cursor: pointer; margin-top: 0; }
    .form-check-label { cursor: pointer; margin-left: 10px; color: #475569; font-size: 0.9rem; font-weight: 500; width: 100%; user-select: none; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Kelola Pengaduan</h3>
            <p class="text-muted small">Monitor laporan masuk dan tugaskan anggota tim IT.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter & Search --}}
    <div class="card card-custom mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.pengaduan.index') }}" method="GET" class="row g-2">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" style="border-radius: 0 10px 10px 0;" placeholder="Cari pelapor..." value="{{ request('search') }}">
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
                    <button type="submit" class="btn btn-gradient w-100 py-2 rounded-3">Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card card-custom">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Tim IT</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduans as $item)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama_pengadu }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="text-dark fw-bold small">{{ $item->judul_pengaduan }}</div>
                                <div class="text-muted small">{{ Str::limit($item->isi_pengaduan, 40) }}</div>
                            </td>
                            <td>
                                <div class="anggota-wrapper">
                                    @forelse($item->anggotas as $petugas)
                                        <span class="anggota-tag">{{ $petugas->nama_anggota }}</span>
                                    @empty
                                        <span class="text-danger small fw-bold">Belum Ada</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $class = match($item->status_pengaduan) {
                                        'Baru' => 'status-baru', 'Pending' => 'status-pending',
                                        'Dalam Proses' => 'status-proses', 'Selesai' => 'status-selesai',
                                        'Decline' => 'status-decline', default => 'bg-light'
                                    };
                                @endphp
                                <span class="status-badge {{ $class }}">{{ $item->status_pengaduan }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.pengaduan.show', $item->id_pengaduan) }}" class="action-btn btn-view"><i class="bi bi-eye"></i></a>
                                    <button type="button" class="action-btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $item->id_pengaduan }}"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.pengaduan.destroy', $item->id_pengaduan) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete btn-confirm-delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- MODAL UPDATE --}}
                        <div class="modal fade" id="modalUpdate{{ $item->id_pengaduan }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <form action="{{ route('admin.pengaduan.update-status', $item->id_pengaduan) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header border-0 px-4 pt-4 pb-0">
                                            <h5 class="fw-bold text-dark">Update Laporan #{{ $item->id_pengaduan }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            
                                            {{-- TUGASKAN TIM IT (SCROLLABLE LIST) --}}
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label fw-bold small text-muted text-uppercase mb-0">Tugaskan Tim IT</label>
                                                    <span class="text-primary fw-bold" style="font-size: 0.7rem;">*Bisa pilih >1</span>
                                                </div>
                                                <div class="checkbox-scroll-area shadow-sm">
                                                    @foreach($anggotas as $agt)
                                                        <div class="form-check-custom mb-1">
                                                            <input class="form-check-input" type="checkbox" 
                                                                name="id_anggota[]" 
                                                                value="{{ $agt->id_anggota }}" 
                                                                id="chk_{{ $item->id_pengaduan }}_{{ $agt->id_anggota }}"
                                                                {{ $item->anggotas->contains('id_anggota', $agt->id_anggota) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="chk_{{ $item->id_pengaduan }}_{{ $agt->id_anggota }}">
                                                                {{ $agt->nama_anggota }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            {{-- STATUS SELECTION --}}
                                            <div class="mb-2">
                                                <label class="form-label fw-bold small text-muted text-uppercase">Status Pengerjaan</label>
                                                <select name="status_pengaduan" class="form-select" style="border-radius: 10px; height: 48px; border: 1px solid #e2e8f0;">
                                                    @foreach(['Baru', 'Pending', 'Dalam Proses', 'Selesai', 'Decline'] as $st)
                                                        <option value="{{ $st }}" {{ $item->status_pengaduan == $st ? 'selected' : '' }}>{{ $st }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="submit" class="btn btn-gradient w-100 py-3 rounded-3 shadow-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Tidak ada data pengaduan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Konfirmasi Hapus
        $('.btn-confirm-delete').on('click', function(e) {
            if(!confirm('Yakin ingin menghapus laporan ini?')) e.preventDefault();
        });

        // Alert auto-hide
        setTimeout(() => { 
            $('.alert').fadeOut('slow'); 
        }, 4000);
    });
</script>
@endpush