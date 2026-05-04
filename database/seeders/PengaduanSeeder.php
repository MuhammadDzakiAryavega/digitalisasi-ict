<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;

class PengaduanSeeder extends Seeder
{
    public function run()
    {
        // Ambil satu ID anggota secara acak untuk penugasan contoh
        $anggotaId = DB::table('anggotas')->first()->id_anggota ?? null;

        $data = [
            [
                'nama_pengadu'      => 'Dzaki Aryavega',
                'email_pengadu'     => 'dzaki@pnp.ac.id',
                'no_hp_pengadu'     => '081234567890',
                'judul_pengaduan'   => 'Koneksi WiFi di Lab ICT Terputus',
                'isi_pengaduan'     => 'Sudah dari pagi WiFi di Lab MI 1 tidak bisa diakses, muncul keterangan No Internet.',
                'id_anggota'        => null, // Masih kosong (Status Baru)
                'tanggal_pengaduan' => now()->subDays(2),
                'status_pengaduan'  => 'Baru',
                'url_lampiran'      => null,
            ],
            [
                'nama_pengadu'      => 'Budi Santoso',
                'email_pengadu'     => 'budi@pnp.ac.id',
                'no_hp_pengadu'     => '085277889900',
                'judul_pengaduan'   => 'Printer Ruang Jurusan Macet',
                'isi_pengaduan'     => 'Printer Epson L3110 di ruang jurusan mengalami paper jam dan tinta merah tidak keluar.',
                'id_anggota'        => $anggotaId, // Sudah ditugaskan ke anggota pertama
                'tanggal_pengaduan' => now()->subDay(),
                'status_pengaduan'  => 'Dalam Proses',
                'url_lampiran'      => null,
            ],
            [
                'nama_pengadu'      => 'Siti Aminah',
                'email_pengadu'     => 'siti@pnp.ac.id',
                'no_hp_pengadu'     => '081366554433',
                'judul_pengaduan'   => 'Lupa Password Email Institusi',
                'isi_pengaduan'     => 'Saya tidak bisa login ke email pnp.ac.id, mohon bantuannya untuk reset password.',
                'id_anggota'        => $anggotaId,
                'tanggal_pengaduan' => now()->subHours(5),
                'status_pengaduan'  => 'Selesai',
                'url_lampiran'      => null,
            ],
        ];

        foreach ($data as $item) {
            Pengaduan::create($item);
        }
    }
}