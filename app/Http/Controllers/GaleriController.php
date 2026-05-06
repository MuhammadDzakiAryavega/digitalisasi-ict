<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public function index() 
{
    $galeris = Galeri::all();
    return view('public.galeri.galeri', compact('galeris'));
}

// 2. Fungsi untuk Tampilan Kelola (Admin)
public function indexGaleri() 
{
    $galeris = Galeri::all();
    return view('admin.kelola_galeri.index', compact('galeris'));
}

    public function createGaleri() {
        return view('admin.kelola_galeri.create');
    }

    public function storeGaleri(Request $request) {
        $request->validate([
            'judul_kegiatan'    => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'tanggal_kegiatan'  => 'required|date',
            'gambar'            => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('gambar');
        $filename = time() . '_' . Str::slug($request->judul_kegiatan) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('galeri', $filename, 'public');

        Galeri::create([
            'judul_kegiatan'    => $request->judul_kegiatan,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'tanggal_kegiatan'  => $request->tanggal_kegiatan,
            'thumbnail_url'     => $path
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Kegiatan ditambahkan!');
    }

    public function editGaleri($galeri) {
        $galeri = Galeri::findOrFail($galeri);
        // Memanggil file update.blade.php sesuai keinginanmu
        return view('admin.kelola_galeri.update', compact('galeri'));
    }

    public function updateGaleri(Request $request, $galeri) {
        $galeri = Galeri::findOrFail($galeri);

        $request->validate([
            'judul_kegiatan'    => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'tanggal_kegiatan'  => 'required|date',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['judul_kegiatan', 'deskripsi_singkat', 'tanggal_kegiatan']);

        if ($request->hasFile('gambar')) {
            if ($galeri->thumbnail_url && !Str::contains($galeri->thumbnail_url, 'http')) {
                Storage::disk('public')->delete($galeri->thumbnail_url);
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->judul_kegiatan) . '.' . $file->getClientOriginalExtension();
            $data['thumbnail_url'] = $file->storeAs('galeri', $filename, 'public');
        }

        $galeri->update($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Data diperbarui!');
    }

    public function destroyGaleri($galeri) {
        $galeri = Galeri::findOrFail($galeri);
        if ($galeri->thumbnail_url && !Str::contains($galeri->thumbnail_url, 'http')) {
            Storage::disk('public')->delete($galeri->thumbnail_url);
        }
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Data dihapus!');
    }

    public function show($id_kegiatan) {
    // Cari data berdasarkan primary key (id_kegiatan)
    $galeri = Galeri::findOrFail($id_kegiatan);
    
    // Tampilkan ke view detail.blade.php
    return view('public.galeri.detail', compact('galeri'));
    }

    public function incrementViews($id)
{
    // 1. Cari data berdasarkan id_kegiatan (sesuai database kamu)
    $galeri = \App\Models\Galeri::where('id_kegiatan', $id)->first();

    if ($galeri) {
        // 2. Tambah angka di kolom views
        $galeri->increment('views'); 

        // 3. Kirim respon balik ke JavaScript
        return response()->json([
            'success' => true,
            'total_views' => $galeri->views
        ]);
    }

    return response()->json(['success' => false], 404);
}

}