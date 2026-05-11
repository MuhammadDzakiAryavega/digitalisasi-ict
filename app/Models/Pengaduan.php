<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'nama_pengadu',
        'email_pengadu',
        'no_hp_pengadu',
        // 'id_anggota', <-- Hapus ini dari fillable karena sudah pakai tabel pivot
        'judul_pengaduan',
        'isi_pengaduan',
        'tanggal_pengaduan',
        'status_pengaduan',
        'url_lampiran',
    ];

    /**
     * Relasi ke model Anggota (Pivot)
     */
    public function anggotas() {
        return $this->belongsToMany(Anggota::class, 'anggota_pengaduan', 'id_pengaduan', 'id_anggota');
    }

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}