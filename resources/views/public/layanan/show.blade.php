@extends('layouts.app')

@section('content')
<style>
    /* --- CUSTOM CSS --- */
    .page-detail {
        background-color: #f8f9fa;
        min-height: 90vh;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none !important;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.075) !important;
    }
    .bg-soft-primary {
        background-color: #e7f1ff;
        color: #0d6efd;
    }
    .info-label {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #adb5bd;
    }
    .status-badge {
        font-size: 0.85rem;
        padding: 8px 16px;
        font-weight: 700;
    }
    .evidence-preview {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        cursor: zoom-in;
        transition: opacity 0.3s;
    }
    .evidence-preview:hover {
        opacity: 0.9;
    }
    /* Animasi masuk */
    .animate-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="page-detail">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 animate-up">
            <div>
                <h3 class="fw-bold text-dark mb-0">Detail Laporan Pengaduan</h3>
            </div>
            <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-primary shadow-sm rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Riwayat
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8 animate-up" style="animation-delay: 0.1s;">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4">
                            <span class="info-label d-block mb-1">Judul Pengaduan</span>
                            <h4 class="fw-bold text-dark">{{ $pengaduan->judul_pengaduan }}</h4>
                        </div>

                        <div class="mb-4">
                            <span class="info-label d-block mb-2">Isi Laporan</span>
                            <div class="p-4 bg-light rounded-4 border-start border-primary border-4">
                                {!! nl2br(e($pengaduan->isi_pengaduan)) !!}
                            </div>
                        </div>

                        @if($pengaduan->url_lampiran)
                        <div>
                            <span class="info-label d-block mb-2">Lampiran Bukti</span>
                            <div class="rounded-4 overflow-hidden border shadow-sm" style="max-width: 450px;">
                                <a href="{{ asset('storage/' . $pengaduan->url_lampiran) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $pengaduan->url_lampiran) }}" 
                                         class="evidence-preview img-fluid" 
                                         alt="Lampiran Pengaduan">
                                </a>
                            </div>
                            <small class="text-muted mt-2 d-block small italic">
                                <i class="bi bi-info-circle me-1"></i>Klik gambar untuk melihat dalam ukuran penuh.
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4 animate-up" style="animation-delay: 0.2s;">
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <span class="info-label d-block mb-3">Status Penanganan</span>
                        
                        @php
                            $status = $pengaduan->status_pengaduan;
                            $badgeClass = match($status) {
                                'Baru' => 'bg-warning text-dark',
                                'Dalam Proses' => 'bg-primary text-white',
                                'Selesai' => 'bg-success text-white',
                                'Decline' => 'bg-danger text-white',
                                default => 'bg-secondary text-white',
                            };
                        @endphp
                        
                        <div class="mb-4">
                            <span class="badge rounded-pill {{ $badgeClass }} status-badge shadow-sm">
                                <i class="bi bi-info-circle-fill me-2"></i>{{ $status }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span class="info-label d-block mb-1">Tanggal Pengaduan</span>
                            <p class="fw-bold mb-0 text-dark">
                                {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-muted small">Pukul {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('H:i') }} WIB</p>
                        </div>

                        <hr class="my-4 opacity-50">

                        <span class="info-label d-block mb-3">Petugas IT Penanggung Jawab</span>
                        
                        @if($pengaduan->anggotas->count() > 0)
                            @foreach($pengaduan->anggotas as $petugas)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-soft-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-badge fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0 fw-bold text-dark">{{ $petugas->nama_anggota }}</p>
                                    <p class="mb-0 text-muted small">{{ $petugas->jabatan }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-3 bg-light rounded-3 border">
                                <i class="bi bi-clock-history text-muted d-block fs-3 mb-2"></i>
                                <p class="text-muted small mb-0 px-3">Laporan Anda sedang diverifikasi admin untuk penugasan petugas IT.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card bg-primary text-white rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold"><i class="bi bi-lightbulb me-2"></i>Butuh Bantuan?</h6>
                        <p class="small mb-0 opacity-75">Jika kendala belum teratasi atau ingin memberikan informasi tambahan, silakan hubungi Unit IT di gedung pusat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- --- JAVASCRIPT --- --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Detail Pengaduan #{{ $pengaduan->id_pengaduan }} loaded.");
        
        // Contoh interaksi: Toast atau Log status
        const currentStatus = "{{ $pengaduan->status_pengaduan }}";
        if(currentStatus === 'Selesai') {
            // Kamu bisa tambahkan animasi kembang api ringan di sini jika mau
        }
    });
</script>
@endsection