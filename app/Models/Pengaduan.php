<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pengaduans';

    // Primary key yang kamu gunakan bukan 'id'
    protected $primaryKey = 'id_pengaduan';

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama_pengadu',
        'email_pengadu',
        'no_hp_pengadu',
        'id_anggota',
        'judul_pengaduan',
        'isi_pengaduan',
        'tanggal_pengaduan',
        'status_pengaduan',
        'url_lampiran',
    ];

    /**
     * Relasi ke model Anggota
     * Menghubungkan id_anggota di tabel pengaduans ke id_anggota di tabel anggotas
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Casting tipe data agar lebih mudah diolah
     */
    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}