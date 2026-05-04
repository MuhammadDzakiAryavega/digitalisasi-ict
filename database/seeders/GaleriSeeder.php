<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel dulu agar tidak double saat running seeder
        DB::table('galeris')->truncate();

        DB::table('galeris')->insert([
            [
                'judul_kegiatan' => 'Pemasangan Access Point WiFi Kampus',
                'deskripsi_singkat' => 'Perluasan jangkauan jaringan internet di area kantin dan gazebo mahasiswa untuk mendukung akses belajar mandiri.',
                'tanggal_kegiatan' => '2026-03-10',
                // Menggunakan URL langsung agar pasti muncul
                'thumbnail_url' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=1000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul_kegiatan' => 'Maintenance Hardware Ruang Server',
                'deskripsi_singkat' => 'Pembersihan berkala dan penggantian thermal paste pada server database pusat untuk mencegah overheat.',
                'tanggal_kegiatan' => '2026-04-05',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=1000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul_kegiatan' => 'Sosialisasi Sistem Pengaduan Online',
                'deskripsi_singkat' => 'Pengenalan fitur terbaru portal ICT kepada staf biro agar pelaporan kendala IT bisa diproses lebih transparan.',
                'tanggal_kegiatan' => '2026-04-20',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}