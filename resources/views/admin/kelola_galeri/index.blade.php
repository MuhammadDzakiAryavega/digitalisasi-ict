@extends('layouts.dashboard')

@section('title', 'Kelola Galeri - Unit IT')

@section('content')
<style>
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: #ffffff; }
    .btn-gradient { background: linear-gradient(135deg, #0061ff 0%, #60efff 100%); border: none; color: white; transition: all 0.3s ease; }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3); color: white; }
    .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: #858796; padding: 1.25rem; border-bottom: 1px solid #e3e6f0; }
    .table tbody td { padding: 1.25rem; vertical-align: middle; color: #5a5c69; }
    .thumbnail-container { width: 80px; height: 55px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); flex-shrink: 0; }
    .thumbnail-img { width: 100%; height: 100%; object-fit: cover; }
    .action-btn { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.2s; border: none; text-decoration: none; cursor: pointer; }
    .btn-edit { background-color: #fff4e5; color: #ff9800; }
    .btn-edit:hover { background-color: #ff9800; color: white; }
    .btn-delete { background-color: #ffe5e5; color: #e91e63; }
    .btn-delete:hover { background-color: #e91e63; color: white; }
</style>

<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Daftar Kegiatan</h3>
            <p class="text-muted small mb-0">Kelola dokumentasi galeri Unit IT.</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-gradient rounded-pill px-4 py-2 fw-bold shadow-sm text-nowrap">
            <i class="bi bi-plus-lg me-2"></i> Tambah Kegiatan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
    @endif

    <div id="react-gallery-root"></div>
</div>

@php
    $reactData = $galeris->map(function($item) {
        return [
            'id_kegiatan' => $item->id_kegiatan,
            'judul_kegiatan' => $item->judul_kegiatan,
            'deskripsi_singkat' => Str::limit($item->deskripsi_singkat, 50),
            'tanggal_format' => \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y'),
            'thumbnail_url' => Str::contains($item->thumbnail_url, 'http') ? $item->thumbnail_url : asset('storage/' . $item->thumbnail_url),
            'edit_url' => route('admin.galeri.edit', $item->id_kegiatan),
            'delete_url' => route('admin.galeri.destroy', $item->id_kegiatan),
        ];
    });
@endphp

@push('scripts')
<script>
    window.galleryData = @json($reactData);
    window.csrfToken = '{{ csrf_token() }}';
</script>

<script type="text/babel">
    const { useState } = React;

    const GalleryTable = () => {
        const [searchTerm, setSearchTerm] = useState('');
        const [items] = useState(window.galleryData || []);

        // --- SOLUSI ERROR: Pindahkan Style ke Variabel ---
        const headerCardStyle = { 
            borderTopLeftRadius: '15px', 
            borderTopRightRadius: '15px' 
        };
        
        const searchBoxStyle = { 
            maxWidth: '300px' 
        };

        const filteredItems = items.filter(item => 
            item.judul_kegiatan.toLowerCase().includes(searchTerm.toLowerCase()) || 
            item.deskripsi_singkat.toLowerCase().includes(searchTerm.toLowerCase())
        );

        const handleDelete = (deleteUrl) => {
            Swal.fire({
                title: 'Hapus data ini?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e91e63',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = window.csrfToken;

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        };

        return (
            <div className="card card-custom">
                <div className="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center" style={headerCardStyle}>
                    <h6 className="mb-0 fw-bold text-primary">Total: {filteredItems.length}</h6>
                    <div className="input-group" style={searchBoxStyle}>
                        <span className="input-group-text bg-transparent border-end-0 rounded-start-pill">
                            <i className="bi bi-search text-muted"></i>
                        </span>
                        <input 
                            type="text" 
                            className="form-control border-start-0 rounded-end-pill shadow-none" 
                            placeholder="Cari kegiatan..." 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                        />
                    </div>
                </div>

                <div className="card-body p-0">
                    <div className="table-responsive">
                        <table className="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th className="text-center">Tanggal</th>
                                    <th className="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filteredItems.length > 0 ? (
                                    filteredItems.map((item, idx) => (
                                        <tr key={idx}>
                                            <td>
                                                <div className="d-flex align-items-center">
                                                    <div className="thumbnail-container me-3">
                                                        <img src={item.thumbnail_url} className="thumbnail-img" />
                                                    </div>
                                                    <div>
                                                        <div className="fw-bold text-dark">{item.judul_kegiatan}</div>
                                                        <small className="text-muted">{item.deskripsi_singkat}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="text-center">
                                                <span className="badge bg-light text-primary border px-3 py-2 rounded-pill">
                                                    {item.tanggal_format}
                                                </span>
                                            </td>
                                            <td className="text-center">
                                                <div className="d-flex justify-content-center gap-2">
                                                    <a href={item.edit_url} className="action-btn btn-edit">
                                                        <i className="bi bi-pencil-fill"></i>
                                                    </a>
                                                    <button onClick={() => handleDelete(item.delete_url)} className="action-btn btn-delete">
                                                        <i className="bi bi-trash3-fill"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="3" className="text-center py-5 text-muted">Data tidak ditemukan.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        );
    };

    const root = ReactDOM.createRoot(document.getElementById('react-gallery-root'));
    root.render(<GalleryTable />);
</script>
@endpush
@endsection