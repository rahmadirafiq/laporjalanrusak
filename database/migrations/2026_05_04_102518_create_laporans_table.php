<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_pelapor');
            $table->string('telepon_pelapor')->nullable();
            $table->string('jenis_kerusakan');
            $table->string('tingkat_kerusakan');
            $table->text('lokasi_lengkap');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('deskripsi');
            $table->json('foto')->nullable();
            $table->enum('status', ['menunggu', 'diverifikasi', 'proses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('laporans');
    }
};