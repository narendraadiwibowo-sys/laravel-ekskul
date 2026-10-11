<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluaran_kas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->unsignedInteger('nominal');
            $table->date('tanggal');
            $table->enum('kategori', ['alat', 'konsumsi', 'lainnya'])->default('lainnya');
            $table->text('keterangan')->nullable();
            $table->foreignId('dicatat_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_kas');
    }
};
