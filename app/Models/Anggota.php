<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas'; // Sesuai database
    protected $primaryKey = 'id_anggota'; // Sesuai gambar (kunci emas)

    protected $fillable = [
        'nama_anggota',
        'pangkat',
    ];

    public function pengaduans()
    {
        return $this->belongsToMany(Pengaduan::class, 'anggota_pengaduan', 'id_anggota', 'id_pengaduan');
    }
}