<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surat_menyurats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->string('perihal');
            $table->string('asal_tujuan'); // asal jika masuk, tujuan jika keluar
            $table->date('tanggal_surat');
            $table->date('tanggal_terima_kirim')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('dicatat_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('surat_menyurats'); }
};
