<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'galeris';
    protected $primaryKey = 'id_kegiatan';
    
    protected $fillable = [
        'judul_kegiatan',
        'deskripsi_singkat',
        'tanggal_kegiatan',
        'thumbnail_url'
    ];
}