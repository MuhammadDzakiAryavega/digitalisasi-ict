<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable([
    'name', 
    'email', 
    'password', 
    'nik', 
    'alamat', 
    'no_telepon', 
    'is_admin'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tentukan konversi tipe data (Casting).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // Kita cast is_admin ke boolean agar di aplikasi nilainya true/false, 
            // bukan cuma angka 1/0.
            'is_admin' => 'boolean', 
        ];
    }
}