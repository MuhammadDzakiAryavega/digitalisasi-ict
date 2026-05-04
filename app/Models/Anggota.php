<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'anggotas';

    // Primary Key kustom
    protected $primaryKey = 'id_anggota';

    /**
     * Field yang boleh diisi (Mass Assignment)
     * Kita sesuaikan persis dengan gambar struktur database kamu:
     * 1. nama_anggota
     * 2. pangkat (Bukan divisi)
     */
    protected $fillable = [
        'nama_anggota',
        'pangkat', 
    ];

    /**
     * Relasi ke Pengaduan 
     */
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'id_anggota', 'id_anggota');
    }
}