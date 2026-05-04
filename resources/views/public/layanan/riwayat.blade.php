@extends('layouts.app')

@section('title', 'Riwayat Pengaduan - Unit ICT')

@push('styles')
<style>
    body { background-color: #f4f7fa; }

    /* --- Navigasi Tab (Identik dengan Form) --- */
    .nav-toggle-container {
        display: flex; 
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px); 
        border-radius: 16px; 
        padding: 7px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.04); 
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .nav-toggle-btn {
        flex: 1; padding: 12px; text-align: center; border-radius: 12px;
        text-decoration: none; font-weight: 700; transition: all 0.3s ease;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .nav-toggle-btn.active {
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%);
        color: #fff !important; box-shadow: 0 4px 15px rgba(0, 97, 255, 0.3);
    }
    .nav-toggle-btn.inactive { color: #7d879c !important; }
    .nav-toggle-btn.inactive:hover { background-color: #ebf2ff; color: #0061ff !important; }

    /* --- Custom Card (Identik dengan Form) --- */
    .custom-card { 
        background-color: #ffffff; 
        border-radius: 24px; 
        border: none; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.05); 
    }

    /* --- Header Section (Identik dengan Form) --- */
    .form-section-title { 
        display: flex; align-items: center; margin-bottom: 25px; 
        padding-bottom: 15px; border-bottom: 2px solid #f0f2f5; 
    }
    .form-section-title i { 
        font-size: 1.5rem; color: #0061ff; margin-right: 12px; 
        background: #ebf2ff; padding: 10px; border-radius: 12px; 
    }
    .form-section-title h5 { margin-bottom: 0; font-weight: 800; color: #2d3748; }

    /* --- Desain Tabel --- */
    .table thead th { 
        background-color: #ffffff; color: #adb5bd; text-transform: uppercase; 
        font-size: 0.7rem; letter-spacing: 1px; font-weight: 800; 
        padding: 15px 10px; border-bottom: 2px solid #f8f9fa;
    }
    .table tbody td { 
        padding: 20px 10px; vertical-align: middle; 
        border-bottom: 1px solid #f8f9fa; color: #2d3748; 
    }

    /* --- Badge Status --- */
    .status-pill { 
        padding: 6px 12px; border-radius: 10px; font-size: 10px; 
        font-weight: 800; display: inline-flex; align-items: center; gap: 5px; 
    }
    .st-baru { background: #e7f3ff; color: #0061ff; }
    .st-proses { background: #fff4e6; color: #fd7e14; }
    .st-selesai { background: #ebfbee; color: #40c057; }
    .st-decline { background: #fff5f5; color: #fa5252; }

    .officer-info { 
        display: flex; align-items: center; gap: 6px; margin-top: 8px; 
        padding: 5px 10px; background: #f8fafc; width: fit-content; 
        border-radius: 8px; font-size: 0.7rem; font-weight: 600; border: 1px solid #edf2f7;
    }
    
    .btn-detail { 
        width: 38px; height: 38px; display: flex; align-items: center; 
        justify-content: center; border-radius: 10px; background: #f1f3f5; 
        color: #4a5568; border: none; transition: all 0.3s ease; 
    }
    .btn-detail:hover { 
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%); 
        color: #fff; transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        {{-- Diubah menjadi col-lg-8 agar lebar SAMA dengan form layanan --}}
        <div class="col-lg-8">
            
            {{-- Navigasi Tab --}}
            <div class="nav-toggle-container">
                <a href="{{ route('pengaduan.create') }}" 
                   class="nav-toggle-btn {{ Request::routeIs('pengaduan.create') ? 'active' : 'inactive' }}">
                    <i class="bi bi-pencil-square"></i> Buat Pengaduan
                </a>
                <a href="{{ route('pengaduan.index') }}" 
                   class="nav-toggle-btn {{ Request::routeIs('pengaduan.index') ? 'active' : 'inactive' }}">
                    <i class="bi bi-clock-history"></i> Riwayat Pengaduan
                </a>
            </div>

            {{-- Padding disamakan p-4 p-md-5 --}}
            <div class="card custom-card p-4 p-md-5">
                <div class="form-section-title">
                    <i class="bi bi-list-stars"></i>
                    <h5>Daftar Laporan Anda</h5>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="55%">Kendala</th>
                                <th width="25%">Status</th>
                                <th width="15%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengaduans as $item)
                            <tr>
                                <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-extrabold text-dark mb-1" style="font-weight: 800; font-size: 0.95rem;">
                                        {{ $item->judul_pengaduan }}
                                    </div>
                                    <div class="text-muted small mb-2" style="font-size: 0.75rem;">
                                        <i class="bi bi-calendar3 me-1"></i> 
                                        {{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->translatedFormat('d M Y, H:i') }}
                                    </div>
                                    
                                    @if($item->id_anggota)
                                        <div class="officer-info">
                                            <i class="bi bi-person-badge text-primary"></i>
                                            <span class="text-dark">{{ $item->anggota->nama_anggota }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = match($item->status_pengaduan) {
                                            'Baru' => ['c' => 'st-baru', 'i' => 'bi-asterisk'],
                                            'Dalam Proses' => ['c' => 'st-proses', 'i' => 'bi-gear-wide-connected'],
                                            'Selesai' => ['c' => 'st-selesai', 'i' => 'bi-check-circle-fill'],
                                            'Decline' => ['c' => 'st-decline', 'i' => 'bi-x-circle-fill'],
                                            default => ['c' => 'st-baru', 'i' => 'bi-pause-circle'],
                                        };
                                    @endphp
                                    <div class="status-pill {{ $status['c'] }}">
                                        <i class="bi {{ $status['i'] }}"></i> {{ $item->status_pengaduan }}
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn-detail" title="Detail">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/gray/data-analysis.svg" alt="empty" style="width: 120px; opacity: 0.6;">
                                    <p class="text-muted mt-4 fw-bold">Belum ada riwayat laporan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection