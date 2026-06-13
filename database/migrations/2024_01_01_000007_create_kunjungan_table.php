<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('restrict');
            $table->date('tanggal');
            $table->text('keluhan');
            $table->text('diagnosis')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index(['pasien_id', 'tanggal']);
            $table->index(['dokter_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
