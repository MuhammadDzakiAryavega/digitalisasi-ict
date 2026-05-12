<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // --- KHUSUS WARGA (Riwayat Pengaduan Sendiri) ---
    public function index()
    {
        // Kita panggil relasi 'anggotas' karena satu laporan bisa banyak petugas
        $pengaduans = Pengaduan::with('anggotas')
            ->where('email_pengadu', Auth::user()->email) 
            ->orderBy('tanggal_pengaduan', 'desc')
            ->get();

        return view('public.layanan.riwayat', compact('pengaduans'));
    }

    // --- KHUSUS ADMIN (Kelola Semua Pengaduan) ---
    public function indexAdmin(Request $request)
    {
        $query = Pengaduan::with('anggotas');

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
        $anggotas = Anggota::all();

        return view('admin.kelola_pengaduan.index', compact('pengaduans', 'anggotas'));
    }

    // --- UPDATE STATUS & PENUGASAN (BAGIAN PALING PENTING) ---
    public function updateStatus(Request $request, $id)
{
    // 1. Validasi input
    $request->validate([
        'status_pengaduan' => 'required',
        'id_anggota'       => 'required|array', // Harus array karena pilih banyak
    ]);

    // 2. Cari data pengaduan
    $pengaduan = Pengaduan::findOrFail($id);
    
    // 3. Update status di tabel pengaduans
    $pengaduan->update([
        'status_pengaduan' => $request->status_pengaduan,
    ]);

    // 4. Sinkronisasi anggota ke tabel pivot
    // Fungsi sync() akan otomatis menghapus anggota lama dan menggantinya dengan yang baru dipilih
    $pengaduan->anggotas()->sync($request->id_anggota);

    return redirect()->back()->with('success', 'Status pengaduan dan tim IT berhasil diperbarui!');
    } 

    // --- DETAIL PENGADUAN ---
    // --- DETAIL PENGADUAN ---
    public function show($id){
    // Ambil data pengaduan beserta teknisinya
    $pengaduan = Pengaduan::with('anggotas')->where('id_pengaduan', $id)->firstOrFail();
    
    // CEK ROLE LOGIN
    // Jika yang login memiliki role admin, arahkan ke folder admin
    if (auth()->user()->role === 'admin') {
        return view('admin.kelola_pengaduan.show', compact('pengaduan'));
    }

    // Jika bukan admin (berarti warga/user), arahkan ke folder public
    return view('public.layanan.show', compact('pengaduan'));
    }
    
    // --- SISANYA (Store & Destroy) TETAP SAMA ---
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
            'email_pengadu'     => Auth::user()->email,
            'no_hp_pengadu'     => $request->no_hp_pengadu,
            'judul_pengaduan'   => $request->judul_pengaduan,
            'isi_pengaduan'     => $request->isi_pengaduan,
            'tanggal_pengaduan' => now(),
            'status_pengaduan'  => 'Baru',
            'url_lampiran'      => $path,
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }
    public function destroy($id)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $id)->firstOrFail();

        // [KEAMANAN TAMBAHAN] 
        // Pastikan hanya status 'Baru' atau 'Pending' yang bisa dibatalkan dari sisi backend
        if (!in_array($pengaduan->status_pengaduan, ['Baru', 'Pending'])) {
            return redirect()->back()->with('error', 'Laporan yang sudah diproses tidak dapat dibatalkan!');
        }

        // Hapus file lampiran dari storage jika ada
        if ($pengaduan->url_lampiran) {
            Storage::disk('public')->delete($pengaduan->url_lampiran);
        }

        // Hapus relasi pada tabel pivot (pengaduan_anggota) jika sudah terlanjur ada
        $pengaduan->anggotas()->detach();

        // Hapus data utama
        $pengaduan->delete();

        return redirect()->back()->with('success', 'Pengaduan berhasil dibatalkan dan dihapus!');
    }
}