<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Utama Users
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 255);
            $table->char('nik', 16)->nullable(); // Sesuai gambar: char(16)
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 16)->nullable();
            $table->string('email', 255)->unique();
            
            // Perhatikan penulisan tinyInteger (Case Sensitive)
            $table->tinyInteger('is_admin')->default(0)->comment('Flag untuk status Admin (1) atau Pengguna Biasa (0)');
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel pendukung bawaan Laravel (biarkan saja)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};