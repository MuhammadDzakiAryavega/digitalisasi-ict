<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nama_pengadu');
            $table->string('email_pengadu');
            $table->string('no_hp_pengadu')->nullable();
            
            // Relasi ke tabel anggotas (Foreign Key)
            // Pastikan tabel 'anggotas' sudah dibuat sebelumnya
            $table->unsignedBigInteger('id_anggota')->nullable();
            
            $table->string('judul_pengaduan');
            $table->text('isi_pengaduan');
            $table->timestamp('tanggal_pengaduan')->useCurrent();
            
            // Status Lengkap: Baru, Pending, Dalam Proses, Selesai, Decline
            $table->enum('status_pengaduan', [
                'Baru', 
                'Pending', 
                'Dalam Proses', 
                'Selesai', 
                'Decline'
            ])->default('Baru');
            
            $table->string('url_lampiran')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};