@extends('layouts.dashboard')

@section('title', 'Kelola Anggota - Unit ICT')

@push('styles')
<style>
    /* --- CSS DASAR & CARD (Sesuai Pengaduan & Galeri) --- */
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); background: #ffffff; }
    .btn-gradient { background: linear-gradient(135deg, #0061ff 0%, #60efff 100%); border: none; color: white; transition: all 0.3s ease; font-weight: bold; }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 97, 255, 0.3); color: white; }
    
    .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; color: #858796; padding: 1.25rem; border-bottom: 1px solid #e3e6f0; }
    .table tbody td { padding: 1.25rem; vertical-align: middle; color: #5a5c69; transition: all 0.2s; }
    .table tbody tr:hover td { background-color: #f8faff; }

    /* --- AVATAR & BADGE (Spesifik Anggota) --- */
    .avatar-circle { 
        width: 40px; height: 40px; border-radius: 10px; 
        background: #eef2ff; color: #4338ca; 
        display: flex; align-items: center; justify-content: center; 
        font-weight: 800; font-size: 0.9rem; flex-shrink: 0;
    }
    .badge-pangkat { 
        background-color: #f0fdf4; color: #16a34a; border-radius: 8px; 
        padding: 6px 12px; font-size: 0.75rem; font-weight: 700; border: 1px solid #dcfce7;
    }

    /* --- ACTION BUTTONS --- */
    .action-btn { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; border: none; text-decoration: none; }
    .btn-edit { background-color: #eef2ff; color: #4338ca; }
    .btn-edit:hover { background-color: #4338ca; color: white; }
    .btn-delete { background-color: #fff1f2; color: #be123c; }
    .btn-delete:hover { background-color: #be123c; color: white; }

    .search-card { border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); margin-bottom: 1.5rem; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Daftar Anggota</h3>
            <p class="text-muted small">Manajemen data personil dan struktur Unit IT.</p>
        </div>
        <a href="{{ route('admin.kelola-anggota.create') }}" class="btn btn-gradient px-4 py-2 rounded-3 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Tambah Anggota
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
    <div id="react-anggota-root"></div>
</div>

@php
    $reactData = $anggotas->map(function($item) {
        return [
            'id' => $item->id_anggota,
            'nama' => $item->nama_anggota,
            'inisial' => strtoupper(substr($item->nama_anggota, 0, 1)),
            'pangkat' => $item->pangkat,
            'edit_url' => route('admin.kelola-anggota.edit', $item->id_anggota),
            'delete_url' => route('admin.kelola-anggota.destroy', $item->id_anggota),
        ];
    });
@endphp

@push('scripts')
<script>
    window.anggotaData = @json($reactData);
    window.csrfToken = '{{ csrf_token() }}';
</script>

<script type="text/babel">
    const { useState } = React;

    const AnggotaApp = () => {
        const [searchTerm, setSearchTerm] = useState('');
        const [items] = useState(window.anggotaData || []);

        // Objek style untuk menghindari bentrok Blade
        const inputLeft = { borderRadius: '10px 0 0 10px' };
        const inputRight = { borderRadius: '0 10px 10px 0' };

        const filteredItems = items.filter(item => 
            item.nama.toLowerCase().includes(searchTerm.toLowerCase()) || 
            item.pangkat.toLowerCase().includes(searchTerm.toLowerCase())
        );

        const handleDelete = (id, name, deleteUrl) => {
            Swal.fire({
                title: 'Hapus Anggota?',
                text: `Data ${name} akan dihapus secara permanen.`,
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
                {/* Search Card */}
                <div className="card search-card">
                    <div className="card-body p-3">
                        <div className="input-group">
                            <span className="input-group-text bg-white border-end-0" style={inputLeft}>
                                <i className="bi bi-search text-muted"></i>
                            </span>
                            <input 
                                type="text" 
                                className="form-control border-start-0" 
                                style={inputRight}
                                placeholder="Cari nama anggota atau jabatan..." 
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>
                    </div>
                </div>

                {/* Table Card */}
                <div className="card card-custom">
                    <div className="card-body p-0">
                        <div className="table-responsive">
                            <table className="table mb-0">
                                <thead>
                                    <tr>
                                        <th className="ps-4">Nama Lengkap</th>
                                        <th className="text-center">Jabatan / Pangkat</th>
                                        <th className="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {filteredItems.length > 0 ? (
                                        filteredItems.map((item) => (
                                            <tr key={item.id}>
                                                <td className="ps-4">
                                                    <div className="d-flex align-items-center">
                                                        <div className="avatar-circle me-3">
                                                            {item.inisial}
                                                        </div>
                                                        <div className="fw-bold text-dark">{item.nama}</div>
                                                    </div>
                                                </td>
                                                <td className="text-center">
                                                    <span className="badge-pangkat">{item.pangkat}</span>
                                                </td>
                                                <td className="text-center">
                                                    <div className="d-flex justify-content-center gap-2">
                                                        <a href={item.edit_url} className="action-btn btn-edit">
                                                            <i className="bi bi-pencil-square"></i>
                                                        </a>
                                                        <button 
                                                            onClick={() => handleDelete(item.id, item.nama, item.delete_url)}
                                                            className="action-btn btn-delete"
                                                        >
                                                            <i className="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan="3" className="text-center py-5 text-muted">
                                                Anggota tidak ditemukan.
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

    const root = ReactDOM.createRoot(document.getElementById('react-anggota-root'));
    root.render(<AnggotaApp />);
</script>
@endpush
@endsection