<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // --- KHUSUS WARGA (Hanya melihat Riwayat Pengaduan miliknya sendiri) ---
    public function index()
    {
        // Mengambil data pengaduan yang emailnya sama dengan email user yang login
        $pengaduans = Pengaduan::with('anggota')
            ->where('email_pengadu', Auth::user()->email) 
            ->orderBy('tanggal_pengaduan', 'desc') // Diubah ke desc supaya laporan terbaru muncul paling atas
            ->get();

        return view('public.layanan.riwayat', compact('pengaduans'));
    }

    // --- KHUSUS ADMIN (Melihat semua Pengaduan) ---
    public function indexAdmin(Request $request)
    {
        $query = Pengaduan::with('anggota');

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul_pengaduan', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pengadu', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status_pengaduan', $request->status);
        }

        $pengaduans = $query->orderBy('tanggal_pengaduan', 'desc')->get();
        
        // Ambil data anggota untuk dropdown di Modal Update Admin
        $anggotas = Anggota::all();

        return view('admin.kelola_pengaduan.index', compact('pengaduans', 'anggotas'));
    }

    // Fungsi Store (Warga melapor)
    public function store(Request $request)
    {
        $request->validate([
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan'   => 'required',
            'no_hp_pengadu'   => 'required',
            'url_lampiran'    => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:2048', 
        ]);

        $path = null;
        if ($request->hasFile('url_lampiran')) {
            $path = $request->file('url_lampiran')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'nama_pengadu'      => Auth::user()->name,
            'email_pengadu'     => Auth::user()->email, // Ini kunci untuk filter di fungsi index()
            'no_hp_pengadu'     => $request->no_hp_pengadu,
            'judul_pengaduan'   => $request->judul_pengaduan,
            'isi_pengaduan'     => $request->isi_pengaduan,
            'id_anggota'        => null,
            'tanggal_pengaduan' => now(),
            'status_pengaduan'  => 'Baru',
            'url_lampiran'      => $path,
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }

    // Update Status & Penugasan Anggota (Admin)
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status_pengaduan' => 'required|in:Baru,Pending,Dalam Proses,Selesai,Decline',
        'id_anggota'       => 'nullable|exists:anggotas,id_anggota',
    ]);

    $pengaduan = Pengaduan::where('id_pengaduan', $id)->firstOrFail();
    
    $pengaduan->update([
        'status_pengaduan' => $request->status_pengaduan,
        'id_anggota'       => $request->id_anggota,
    ]);

    return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
}

    // Fungsi Destroy (Admin)
    public function destroy($id)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $id)->firstOrFail();
        
        if ($pengaduan->url_lampiran) {
            Storage::disk('public')->delete($pengaduan->url_lampiran);
        }

        $pengaduan->delete();
        return redirect()->back()->with('success', 'Data pengaduan berhasil dihapus!');
    }

    public function show($id)
{
    // Menggunakan firstOrFail agar jika ID tidak ada, muncul error 404 bukan crash
    $pengaduan = Pengaduan::with('anggota')->where('id_pengaduan', $id)->firstOrFail();
    return view('admin.kelola_pengaduan.show', compact('pengaduan'));
}
}