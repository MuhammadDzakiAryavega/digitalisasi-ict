@extends('layouts.dashboard')

@section('title', 'Detail Pengaduan - ' . $pengaduan->judul_pengaduan)

@push('styles')
<style>
    /* Tipografi & Layout */
    .ls-1 { letter-spacing: 0.5px; }
    .form-container { max-width: 900px; margin: 0 auto; }
    
    /* Card Styling */
    .custom-detail-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    /* Status Badge Custom */
    .badge-status {
        font-weight: 700;
        padding: 8px 16px;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }

    /* Content Styling */
    .report-box {
        background-color: #f8fafc;
        border: 1.5px solid #edf2f7;
        border-radius: 16px;
        padding: 20px;
        line-height: 1.7;
        color: #2d3748;
        min-height: 150px;
    }

    .data-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 800;
        color: #a0aec0;
        display: block;
        margin-bottom: 4px;
    }

    .data-value {
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 0;
    }

    /* Evidence Image */
    .evidence-wrapper {
        position: relative;
        display: inline-block;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .evidence-img {
        max-width: 300px;
        border-radius: 16px;
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }

    .evidence-wrapper:hover .evidence-img {
        transform: scale(1.03);
    }

    .evidence-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        color: white;
    }

    .evidence-wrapper:hover .evidence-overlay {
        opacity: 1;
    }

    /* Action Buttons */
    .btn-action-delete {
        background: #fff5f5;
        color: #e53e3e;
        border: 1px solid #feb2b2;
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-action-delete:hover {
        background: #e53e3e;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid pb-5">
    <!-- Header Navigation -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
            </nav>
            <h3 class="fw-bold text-dark mb-0">Detail Laporan</h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-light border px-4 rounded-3 fw-600 shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card custom-detail-card">
        <div class="card-body p-4 p-md-5">
            <!-- Status & Title -->
            <div class="row mb-5">
                <div class="col-md-8">
                    <span class="data-label">Subjek Laporan</span>
                    <h2 class="fw-bold text-dark mt-1">{{ $pengaduan->judul_pengaduan }}</h2>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="data-label d-md-block mb-2">Status Saat Ini</span>
                    @php
                        $status = $pengaduan->status_pengaduan;
                        $badgeClass = match($status) {
                            'Baru', 'Pending' => 'bg-warning text-warning border-warning',
                            'Dalam Proses' => 'bg-info text-info border-info',
                            'Selesai' => 'bg-success text-success border-success',
                            default => 'bg-secondary text-secondary border-secondary',
                        };
                    @endphp
                    <span class="badge badge-status bg-opacity-10 rounded-pill border {{ $badgeClass }}">
                        <i class="bi bi-dot me-1"></i>{{ $status == 'Baru' || $status == 'Pending' ? 'Menunggu Konfirmasi' : $status }}
                    </span>
                </div>
            </div>

            <!-- Reporter Info Grid -->
            <div class="row g-4 mb-5">
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 border-start border-4 border-primary rounded-end bg-light bg-opacity-50">
                        <span class="data-label">Nama Pelapor</span>
                        <p class="data-value">{{ $pengaduan->nama_pengadu }}</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 border-start border-4 border-info rounded-end bg-light bg-opacity-50">
                        <span class="data-label">Email Kontak</span>
                        <p class="data-value">{{ $pengaduan->email_pengadu }}</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 border-start border-4 border-success rounded-end bg-light bg-opacity-50">
                        <span class="data-label">Waktu Laporan</span>
                        <p class="data-value">{{ $pengaduan->tanggal_pengaduan->format('d M Y') }} <small class="text-muted">{{ $pengaduan->tanggal_pengaduan->format('H:i') }} WIB</small></p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 border-start border-4 border-secondary rounded-end bg-light bg-opacity-50">
                        <span class="data-label">Nomor Telepon</span>
                        <p class="data-value">{{ $pengaduan->no_hp_pengadu ?? 'Tidak dicantumkan' }}</p>
                    </div>
                </div>
            </div>

            <!-- Report Content -->
            <div class="mb-5">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-chat-left-text me-2"></i>Uraian Laporan</h6>
                <div class="report-box shadow-sm">
                    {!! nl2br(e($pengaduan->isi_pengaduan)) !!}
                </div>
            </div>

            <!-- Evidence / Attachment -->
            <div>
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-paperclip me-2"></i>Lampiran Dokumen/Bukti</h6>
                @if($pengaduan->url_lampiran)
                    <div class="evidence-wrapper shadow-sm">
                        <a href="{{ asset('storage/' . $pengaduan->url_lampiran) }}" target="_blank">
                            <img src="{{ asset('storage/' . $pengaduan->url_lampiran) }}" class="evidence-img img-fluid" alt="Bukti Pengaduan">
                            <div class="evidence-overlay">
                                <i class="bi bi-zoom-in fs-3"></i>
                            </div>
                        </a>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Klik gambar untuk memperbesar</small>
                    </div>
                @else
                    <div class="p-4 border border-dashed rounded-4 text-center bg-light">
                        <i class="bi bi-image text-muted display-6 mb-2 d-block"></i>
                        <p class="text-muted mb-0">Tidak ada lampiran bukti yang disertakan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-body p-4 p-md-5 text-center">
                <div class="mb-3 mx-auto" style="width: 80px; height: 80px; background: #fff5f5; color: #e53e3e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h4 class="fw-bold text-dark">Konfirmasi Hapus</h4>
                <p class="text-muted px-md-4">Apakah Anda yakin ingin menghapus laporan dari <strong>{{ $pengaduan->nama_pengadu }}</strong>? Data yang dihapus tidak dapat dipulihkan kembali.</p>
                
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-light px-4 rounded-3 fw-bold order-2 order-sm-1" data-bs-dismiss="modal">Batalkan</button>
                    <form action="{{ route('admin.pengaduan.destroy', $pengaduan->id_pengaduan) }}" method="POST" class="order-1 order-sm-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 rounded-3 fw-bold w-100">Ya, Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Visual feedback saat tombol hapus diproses
    const deleteForm = document.querySelector('#deleteModal form');
    if(deleteForm) {
        deleteForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';
            submitBtn.disabled = true;
        });
    }
</script>
@endpush