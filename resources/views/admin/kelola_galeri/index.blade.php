@extends('layouts.dashboard')

@section('title', 'Kelola Galeri - Unit IT')

@push('styles')
<style>
    /* --- CSS DASAR & TABEL --- */
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: #ffffff; }
    .btn-gradient { background: linear-gradient(135deg, #0061ff 0%, #60efff 100%); border: none; color: white; transition: all 0.3s ease; font-weight: bold; }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3); color: white; }
    
    .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; color: #858796; padding: 1.25rem; border-bottom: 1px solid #e3e6f0; }
    .table tbody td { padding: 1.25rem; vertical-align: middle; color: #5a5c69; transition: all 0.2s; }
    .table tbody tr:hover td { background-color: #f8faff; }
    
    /* --- ACTION BUTTONS --- */
    .action-btn { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; border: none; text-decoration: none; }
    .btn-edit { background-color: #eef2ff; color: #4338ca; }
    .btn-edit:hover { background-color: #4338ca; color: white; }
    .btn-delete { background-color: #fff1f2; color: #be123c; }
    .btn-delete:hover { background-color: #be123c; color: white; }

    /* --- GALLERY SPECIFIC --- */
    .thumbnail-container { width: 60px; height: 45px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.05); flex-shrink: 0; border: 1px solid #eef2ff; }
    .thumbnail-img { width: 100%; height: 100%; object-fit: cover; }
    .search-card { border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); margin-bottom: 1.5rem; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Kelola Galeri</h3>
            <p class="text-muted small">Monitor dokumentasi kegiatan dan publikasi Unit IT.</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-gradient px-4 py-2 rounded-3 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Tambah Kegiatan
        </a>
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

    {{-- React Container --}}
    <div id="react-gallery-root"></div>
</div>

@php
    $reactData = $galeris->map(function($item) {
        return [
            'id_kegiatan' => $item->id_kegiatan,
            'judul_kegiatan' => $item->judul_kegiatan,
            'deskripsi_singkat' => \Illuminate\Support\Str::limit($item->deskripsi_singkat, 45),
            'tanggal_format' => \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d/m/Y'),
            'thumbnail_url' => \Illuminate\Support\Str::contains($item->thumbnail_url, 'http') ? $item->thumbnail_url : asset('storage/' . $item->thumbnail_url),
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

    const GalleryApp = () => {
        const [searchTerm, setSearchTerm] = useState('');
        const [items] = useState(window.galleryData || []);

        // Objek style untuk menghindari konflik kurung kurawal Blade
        const styleInputLeft = { borderRadius: '10px 0 0 10px' };
        const styleInputRight = { borderRadius: '0 10px 10px 0' };
        const styleDeskripsi = { maxWidth: '300px' };

        const filteredItems = items.filter(item => 
            item.judul_kegiatan.toLowerCase().includes(searchTerm.toLowerCase()) || 
            item.deskripsi_singkat.toLowerCase().includes(searchTerm.toLowerCase())
        );

        const handleDelete = (deleteUrl) => {
            Swal.fire({
                title: 'Hapus kegiatan ini?',
                text: "Dokumentasi akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#be123c',
                cancelButtonColor: '#858796',
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
            <div>
                {/* Search Bar Section */}
                <div className="card search-card">
                    <div className="card-body p-3">
                        <div className="row g-2">
                            <div className="col-md-12">
                                <div className="input-group">
                                    <span className="input-group-text bg-white border-end-0" style={styleInputLeft}>
                                        <i className="bi bi-search text-muted"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        className="form-control border-start-0" 
                                        style={styleInputRight}
                                        placeholder="Cari dokumentasi kegiatan..." 
                                        value={searchTerm}
                                        onChange={(e) => setSearchTerm(e.target.value)}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Table Section */}
                <div className="card card-custom">
                    <div className="card-body p-0">
                        <div className="table-responsive">
                            <table className="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Deskripsi</th>
                                        <th className="text-center">Tanggal</th>
                                        <th className="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {filteredItems.length > 0 ? (
                                        filteredItems.map((item) => (
                                            <tr key={item.id_kegiatan}>
                                                <td>
                                                    <div className="d-flex align-items-center">
                                                        <div className="thumbnail-container me-3">
                                                            <img src={item.thumbnail_url} className="thumbnail-img" alt="thumb" />
                                                        </div>
                                                        <div className="fw-bold text-dark">{item.judul_kegiatan}</div>
                                                    </div>
                                                </td>
                                                <td style={styleDeskripsi}>
                                                    <div className="text-muted small">{item.deskripsi_singkat}</div>
                                                </td>
                                                <td className="text-center">
                                                    <small className="text-muted fw-bold">{item.tanggal_format}</small>
                                                </td>
                                                <td className="text-center">
                                                    <div className="d-flex justify-content-center gap-2">
                                                        <a href={item.edit_url} className="action-btn btn-edit">
                                                            <i className="bi bi-pencil"></i>
                                                        </a>
                                                        <button 
                                                            onClick={() => handleDelete(item.delete_url)} 
                                                            className="action-btn btn-delete"
                                                        >
                                                            <i className="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan="4" className="text-center py-5 text-muted">
                                                Tidak ada dokumentasi ditemukan.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        );
    };

    const root = ReactDOM.createRoot(document.getElementById('react-gallery-root'));
    root.render(<GalleryApp />);
</script>
@endpush
@endsection