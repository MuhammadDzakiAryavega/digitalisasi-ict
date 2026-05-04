<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Menampilkan daftar anggota
     */
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        return view('admin.kelola_anggota.index', compact('anggotas'));
    }

    /**
     * Menampilkan form tambah anggota
     */
    public function create()
    {
        return view('admin.kelola_anggota.create');
    }

    /**
     * Menyimpan data anggota baru
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan dengan kolom di database: pangkat
        $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'pangkat'      => 'required|string|max:255',
        ]);

        // Menggunakan mass assignment sesuai fillable di Model
        Anggota::create([
            'nama_anggota' => $request->nama_anggota,
            'pangkat'      => $request->pangkat,
        ]);

        return redirect()->route('admin.kelola-anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit (mengarah ke update.blade.php)
     */
    public function edit($anggota)
    {
        // Mencari data berdasarkan id_anggota
        $anggota = Anggota::findOrFail($anggota);
        return view('admin.kelola_anggota.update', compact('anggota'));
    }

    /**
     * Memperbarui data anggota
     */
    public function update(Request $request, $anggota)
{
    $request->validate([
        'nama_anggota' => 'required|string|max:255',
        'pangkat'      => 'required|string|max:255', // Mencari input bernama 'pangkat'
    ]);

    $anggotaData = Anggota::findOrFail($anggota);
    $anggotaData->update([
        'nama_anggota' => $request->nama_anggota,
        'pangkat'      => $request->pangkat, 
    ]);

    return redirect()->route('admin.kelola-anggota.index')
        ->with('success', 'Data anggota berhasil diperbarui!');
}

    /**
     * Menghapus data anggota
     */
    public function destroy($anggota)
    {
        $anggotaData = Anggota::findOrFail($anggota);
        $anggotaData->delete();

        return redirect()->route('admin.kelola-anggota.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
}