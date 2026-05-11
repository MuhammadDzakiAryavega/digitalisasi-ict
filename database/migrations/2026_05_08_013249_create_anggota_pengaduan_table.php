<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel pivot.
     */
    public function up()
    {
        Schema::create('anggota_pengaduan', function (Blueprint $table) {
            $table->id();

            // Kolom penghubung ke tabel pengaduans (harus BIGINT UNSIGNED)
            $table->unsignedBigInteger('id_pengaduan');
            
            // Kolom penghubung ke tabel anggotas (harus BIGINT UNSIGNED)
            $table->unsignedBigInteger('id_anggota');

            // Set Foreign Key agar data konsisten (jika pengaduan dihapus, baris ini ikut terhapus)
            $table->foreign('id_pengaduan')
                  ->references('id_pengaduan')
                  ->on('pengaduans')
                  ->onDelete('cascade');

            $table->foreign('id_anggota')
                  ->references('id_anggota')
                  ->on('anggotas')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down()
    {
        Schema::dropIfExists('anggota_pengaduan');
    }
};