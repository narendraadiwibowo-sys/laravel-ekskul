<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penguruses', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->enum('divisi', ['Inti', 'Sekretaris', 'Bendahara', 'Humas', 'Acara', 'PDD', 'Perkap']);
            $table->boolean('is_koordinator')->default(false);
            $table->string('kelas')->nullable();
            $table->string('instagram')->nullable();
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(0);
            $table->string('periode')->default('2026/2027');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('penguruses'); }
};
