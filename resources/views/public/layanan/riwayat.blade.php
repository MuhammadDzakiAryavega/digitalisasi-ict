@extends('layouts.app')

@section('title', 'Riwayat Pengaduan - Unit IT')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* --- INTEGRASI STYLE GALERI --- */
    main { padding-top: 0 !important; }

    .page-pengaduan {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* --- HERO HEADER --- */
    .hero-header {
        padding: 180px 0 100px 0; 
        text-align: center;
        background: linear-gradient(180deg, #f0f4ff 0%, #ffffff 100%);
        position: relative;
        margin-top: -75px; 
    }

    .hero-header .title-top {
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 850;
        color: #1a1a1a;
        line-height: 1.1; 
        margin-bottom: 0;
        letter-spacing: -3px;
    }

    .hero-header .title-bottom {
        font-size: clamp(3rem, 8vw, 5rem);
        font-weight: 850;
        color: #0061ff;
        display: block;
        line-height: 1.1; 
        letter-spacing: -3px;
        margin-bottom: 30px;
    }

    .hero-header .description {
        font-size: 1.35rem;
        color: #636e72;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 400;
    }

    /* --- TAB NAVIGASI --- */
    .nav-toggle-container {
        display: flex; 
        background: white;
        border-radius: 20px; 
        padding: 8px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.06); 
        margin: -50px auto 50px auto; 
        position: relative;
        z-index: 10;
        max-width: 550px;
        border: 1px solid #eef2f7;
    }

    .nav-toggle-btn {
        flex: 1; padding: 14px; text-align: center; border-radius: 15px;
        text-decoration: none; font-weight: 700; transition: all 0.3s ease;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .nav-toggle-btn.active {
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%);
        color: #fff !important;
        box-shadow: 0 8px 20px rgba(0, 97, 255, 0.3);
    }

    .nav-toggle-btn.inactive { color: #64748b !important; }
    .nav-toggle-btn.inactive:hover { background-color: #f1f5f9; color: #0061ff !important; }

    /* --- TABLE CARD STYLE --- */
    .custom-card { 
        background: #fff; border-radius: 30px; border: 1px solid #e2e8f0; 
        box-shadow: 0 25px 50px rgba(0,0,0,0.03); 
    }

    .form-section-title { 
        display: flex; align-items: center; margin-bottom: 25px; 
        padding-bottom: 15px; border-bottom: 2px solid #f8fafc; 
    }

    .form-section-title i { 
        font-size: 1.25rem; color: #0061ff; margin-right: 12px; 
        background: #ebf2ff; padding: 10px; border-radius: 12px; 
    }

    .form-section-title h5 { margin-bottom: 0; font-weight: 800; color: #1e293b; letter-spacing: -0.5px; }

    /* --- TABEL STYLING --- */
    .table thead th { 
        background-color: #f8fafc; color: #64748b; text-transform: uppercase; 
        font-size: 0.75rem; letter-spacing: 1px; font-weight: 800; 
        padding: 18px 12px; border: none;
    }

    .table tbody td { 
        padding: 24px 12px; vertical-align: middle; 
        border-bottom: 1px solid #f1f5f9; color: #334155; 
    }

    .status-pill { 
        padding: 8px 14px; border-radius: 12px; font-size: 11px; 
        font-weight: 800; display: inline-flex; align-items: center; gap: 6px; 
        text-transform: uppercase;
    }
    .st-baru { background: #ebf5ff; color: #0061ff; }
    .st-proses { background: #fff7ed; color: #ea580c; }
    .st-selesai { background: #f0fdf4; color: #16a34a; }
    .st-decline { background: #fef2f2; color: #dc2626; }

    /* --- MODIFIKASI OFFICER INFO UNTUK MULTI-TAGS --- */
    .officer-info { 
        display: inline-flex; align-items: center; gap: 6px; 
        padding: 4px 10px; background: #f8fafc; 
        border-radius: 8px; font-size: 0.7rem; font-weight: 600; 
        border: 1px solid #e2e8f0; color: #475569;
    }

    .btn-detail { 
        width: 42px; height: 42px; display: flex; align-items: center; 
        justify-content: center; border-radius: 12px; background: #f1f5f9; 
        color: #64748b; border: none; transition: all 0.3s ease; 
    }
    .btn-detail:hover { 
        background: linear-gradient(135deg, #0061ff 0%, #004ecc 100%); 
        color: #fff; transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="page-pengaduan">
    
    <header class="hero-header" data-aos="fade-down">
        <div class="container">
            <h1 class="title-top">Riwayat</h1>
            <span class="title-bottom">Pengaduan IT</span>
            <p class="description">
                Pantau status perbaikan dan riwayat laporan kendala teknis Anda secara real-time di sini.
            </p>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="nav-toggle-container" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ route('pengaduan.create') }}" 
                       class="nav-toggle-btn {{ Request::routeIs('pengaduan.create') ? 'active' : 'inactive' }}">
                        <i class="bi bi-pencil-square"></i> Buat Pengaduan
                    </a>
                    <a href="{{ route('pengaduan.index') }}" 
                       class="nav-toggle-btn {{ Request::routeIs('pengaduan.index') ? 'active' : 'inactive' }}">
                        <i class="bi bi-clock-history"></i> Riwayat Pengaduan
                    </a>
                </div>

                <div class="card custom-card p-4 p-md-5 mb-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="form-section-title">
                        <i class="bi bi-list-stars"></i>
                        <h5>Daftar Laporan Anda</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table border-0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="55%">Detail Kendala</th>
                                    <th width="25%">Status</th>
                                    <th width="15%" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengaduans as $item)
                                <tr>
                                    <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="mb-1" style="font-weight: 800; font-size: 1rem; color: #1e293b;">
                                            {{ $item->judul_pengaduan }}
                                        </div>
                                        <div class="text-muted small d-flex align-items-center gap-2 mb-2" style="font-size: 0.8rem;">
                                            <i class="bi bi-calendar3"></i> 
                                            {{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->translatedFormat('d M Y, H:i') }}
                                        </div>
                                        
                                        {{-- PERBAIKAN: MULTIPLE TEKNISI --}}
                                        @if($item->anggotas->count() > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($item->anggotas as $petugas)
                                                    <div class="officer-info">
                                                        <i class="bi bi-person-check-fill text-primary"></i>
                                                        <span>{{ $petugas->nama_anggota }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="officer-info" style="background: #fff1f2; border-color: #fecaca; color: #991b1b;">
                                                <i class="bi bi-person-x-fill"></i>
                                                <span>Belum ada teknisi</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $status = match($item->status_pengaduan) {
                                                'Baru' => ['c' => 'st-baru', 'i' => 'bi-asterisk'],
                                                'Pending' => ['c' => 'st-proses', 'i' => 'bi-pause-circle'],
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
                                            <a href="{{ route('pengaduan.show', $item->id_pengaduan) }}" class="btn-detail" title="Lihat Detail">
                                                <i class="bi bi-arrow-right-short fs-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-clipboard-x display-1 text-light"></i>
                                            <p class="text-muted mt-3 fw-bold">Belum ada riwayat laporan yang ditemukan.</p>
                                            <a href="{{ route('pengaduan.create') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Buat Laporan Baru</a>
                                        </div>
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
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({ 
            duration: 1000, 
            once: true 
        });
    });
</script>
@endpush