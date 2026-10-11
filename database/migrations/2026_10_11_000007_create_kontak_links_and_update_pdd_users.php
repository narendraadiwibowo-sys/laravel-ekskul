<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel Kontak & Link untuk Humas
        Schema::create('kontak_links', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->default('sosmed'); // pembina, sekolah, sosmed, lainnya
            $table->string('kontak_url');
            $table->string('keterangan')->nullable();
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 2. Tambahan kolom pada arsip_drives untuk Manajemen Pamflet H-1
        Schema::table('arsip_drives', function (Blueprint $table) {
            $table->string('tipe')->default('drive')->after('thumbnail'); // drive, pamflet
            $table->string('status_tayang')->default('sudah_tayang')->after('tipe'); // draft, siap_tayang, sudah_tayang
            $table->date('tanggal_tayang')->nullable()->after('status_tayang');
        });

        // 3. Tambahan status aktif pada users untuk approval & kontrol anggota
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('kelas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak_links');

        Schema::table('arsip_drives', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'status_tayang', 'tanggal_tayang']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
