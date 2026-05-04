<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->string('judul_kegiatan');
            $table->text('deskripsi_singkat');
            $table->date('tanggal_kegiatan');
            $table->string('thumbnail_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};