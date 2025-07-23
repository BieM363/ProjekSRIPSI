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
        Schema::create('realisasi_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('indikator_id')->constrained('parameter_indikators')->onDelete('cascade');
            $table->string('periode', 20); // Format: Q1-2024, Q2-2024, dll.
            $table->decimal('target', 10, 2);
            $table->decimal('realisasi', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_kinerja');
    }
};