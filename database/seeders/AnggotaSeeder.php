<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        return view('admin.kelola_anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('admin.kelola_anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'pangkat'      => 'required|string|max:100',
        ]);

        Anggota::create([
            'nama_anggota' => $request->nama_anggota,
            'pangkat'      => $request->pangkat,
        ]);

        return redirect()->route('admin.kelola-anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Mencari berdasarkan id_anggota sesuai primaryKey di Model
        $anggota = Anggota::findOrFail($id);
        return view('admin.kelola_anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'pangkat'      => 'required|string|max:100',
        ]);

        $anggota = Anggota::findOrFail($id);
        $anggota->update([
            'nama_anggota' => $request->nama_anggota,
            'pangkat'      => $request->pangkat,
        ]);

        return redirect()->route('admin.kelola-anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('admin.kelola-anggota.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
}