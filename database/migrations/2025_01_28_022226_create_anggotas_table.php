<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('nama_anggota'); // Contoh: Budi Utomo
            $table->string('pangkat');      // Contoh: Supervisor atau IT Support
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};