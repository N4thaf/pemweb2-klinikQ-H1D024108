<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poli_id')->constrained('poli')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->unsignedInteger('nomor_antrian');
            $table->date('tanggal');
            $table->enum('status', ['menunggu', 'dipanggil', 'sedang_dilayani', 'selesai'])->default('menunggu');
            $table->timestamp('waktu_panggil')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->unsignedInteger('estimasi_menit')->nullable();
            $table->timestamps();
            $table->index(['poli_id', 'tanggal']);
            $table->unique(['poli_id', 'nomor_antrian', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrian');
    }
};
