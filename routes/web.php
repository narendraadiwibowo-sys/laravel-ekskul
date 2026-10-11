<?php

use App\Http\Controllers\ArsipDriveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\KontakLinkController;
use App\Http\Controllers\NotulensiController;
use App\Http\Controllers\PengeluaranKasController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramKegiatanController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\SuratMenyuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ==== Auth routes (dari Laravel Breeze) ====
require __DIR__ . '/auth.php';

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('auth')->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== PROFILE =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== STRUKTUR ORGANISASI / SILSILAH KEPENGURUSAN =====
    Route::get('/struktur', [StrukturOrganisasiController::class, 'index'])->name('struktur.index');
    Route::middleware('permission:pengurus.manage')->group(function () {
        Route::get('/struktur/manage', [StrukturOrganisasiController::class, 'manage'])->name('struktur.manage');
        Route::get('/struktur/create', [StrukturOrganisasiController::class, 'create'])->name('struktur.create');
        Route::post('/struktur', [StrukturOrganisasiController::class, 'store'])->name('struktur.store');
        Route::get('/struktur/{pengurus}/edit', [StrukturOrganisasiController::class, 'edit'])->name('struktur.edit');
        Route::put('/struktur/{pengurus}', [StrukturOrganisasiController::class, 'update'])->name('struktur.update');
        Route::delete('/struktur/{pengurus}', [StrukturOrganisasiController::class, 'destroy'])->name('struktur.destroy');
    });

    // ===== PAPAN PENGUMUMAN / NOTICE BOARD (HUMAS) =====
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])
        ->middleware('permission:pengumuman.create')->name('pengumuman.store');
    Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])
        ->middleware('permission:pengumuman.delete')->name('pengumuman.destroy');

    // ===== MANAJEMEN KONTAK & LINK RESMI (HUMAS) =====
    Route::get('/kontak', [KontakLinkController::class, 'index'])->name('kontak.index');
    Route::post('/kontak', [KontakLinkController::class, 'store'])
        ->middleware('permission:pengumuman.create')->name('kontak.store');
    Route::put('/kontak/{kontak}', [KontakLinkController::class, 'update'])
        ->middleware('permission:pengumuman.create')->name('kontak.update');
    Route::delete('/kontak/{kontak}', [KontakLinkController::class, 'destroy'])
        ->middleware('permission:pengumuman.delete')->name('kontak.destroy');

    // ===== JADWAL KEGIATAN & KALENDER ACARA =====
    Route::middleware('permission:jadwal.view')->group(function () {
        Route::get('/jadwal', [JadwalKegiatanController::class, 'index'])->name('jadwal.index');
    });
    Route::middleware('permission:jadwal.create')->group(function () {
        Route::get('/jadwal/create', [JadwalKegiatanController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [JadwalKegiatanController::class, 'store'])->name('jadwal.store');
    });
    Route::middleware('permission:jadwal.update')->group(function () {
        Route::get('/jadwal/{jadwal}/edit', [JadwalKegiatanController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{jadwal}', [JadwalKegiatanController::class, 'update'])->name('jadwal.update');
    });
    Route::delete('/jadwal/{jadwal}', [JadwalKegiatanController::class, 'destroy'])
        ->middleware('permission:jadwal.delete')->name('jadwal.destroy');

    // ===== PRESENSI KEGIATAN =====
    Route::middleware('permission:presensi.catat')->group(function () {
        Route::get('/jadwal/{jadwal}/presensi', [PresensiController::class, 'create'])->name('presensi.create');
        Route::post('/jadwal/{jadwal}/presensi', [PresensiController::class, 'store'])->name('presensi.store');
    });
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap'])
        ->middleware('permission:presensi.view')->name('presensi.rekap');

    // ===== TIMELINE PROGRAM KERJA (DIVISI ACARA) =====
    Route::get('/proker', [ProgramKegiatanController::class, 'index'])
        ->middleware('permission:proker.view')->name('proker.index');
    Route::post('/proker', [ProgramKegiatanController::class, 'store'])
        ->middleware('permission:proker.create')->name('proker.store');
    Route::put('/proker/{proker}', [ProgramKegiatanController::class, 'update'])
        ->middleware('permission:proker.update')->name('proker.update');
    Route::delete('/proker/{proker}', [ProgramKegiatanController::class, 'destroy'])
        ->middleware('permission:proker.delete')->name('proker.destroy');

    // ===== ARSIP GOOGLE DRIVE & PAMFLET (DIVISI PDD) =====
    Route::get('/drive', [ArsipDriveController::class, 'index'])
        ->middleware('permission:drive.view')->name('drive.index');
    Route::post('/drive', [ArsipDriveController::class, 'store'])
        ->middleware('permission:drive.create')->name('drive.store');
    Route::put('/drive/{drive}', [ArsipDriveController::class, 'update'])
        ->middleware('permission:drive.update')->name('drive.update');
    Route::delete('/drive/{drive}', [ArsipDriveController::class, 'destroy'])
        ->middleware('permission:drive.delete')->name('drive.destroy');

    // ===== MANAJEMEN INVENTARIS & PEMINJAMAN (DIVISI PERKAP) =====
    Route::get('/inventaris', [InventarisController::class, 'index'])
        ->middleware('permission:inventaris.view')->name('inventaris.index');
    Route::post('/inventaris', [InventarisController::class, 'store'])
        ->middleware('permission:inventaris.create')->name('inventaris.store');
    Route::put('/inventaris/{inventari}', [InventarisController::class, 'update'])
        ->middleware('permission:inventaris.update')->name('inventaris.update');
    Route::delete('/inventaris/{inventari}', [InventarisController::class, 'destroy'])
        ->middleware('permission:inventaris.delete')->name('inventaris.destroy');
    Route::post('/inventaris/{inventari}/pinjam', [InventarisController::class, 'pinjam'])
        ->middleware('permission:peminjaman.catat')->name('inventaris.pinjam');
    Route::post('/peminjaman/{peminjaman}/kembalikan', [InventarisController::class, 'kembalikan'])
        ->middleware('permission:peminjaman.catat')->name('peminjaman.kembalikan');

    // ===== ARSIP SURAT MENYURAT (DIVISI SEKRETARIS) =====
    Route::get('/surat', [SuratMenyuratController::class, 'index'])
        ->middleware('permission:surat.view')->name('surat.index');
    Route::post('/surat', [SuratMenyuratController::class, 'store'])
        ->middleware('permission:surat.create')->name('surat.store');
    Route::put('/surat/{surat}', [SuratMenyuratController::class, 'update'])
        ->middleware('permission:surat.update')->name('surat.update');
    Route::delete('/surat/{surat}', [SuratMenyuratController::class, 'destroy'])
        ->middleware('permission:surat.delete')->name('surat.destroy');

    // ===== NOTULENSI (DIVISI SEKRETARIS) =====
    Route::middleware('permission:notulensi.create')->group(function () {
        Route::get('/notulensi/create', [NotulensiController::class, 'create'])->name('notulensi.create');
        Route::post('/notulensi', [NotulensiController::class, 'store'])->name('notulensi.store');
    });
    Route::middleware('permission:notulensi.update')->group(function () {
        Route::get('/notulensi/{notulensi}/edit', [NotulensiController::class, 'edit'])->name('notulensi.edit');
        Route::put('/notulensi/{notulensi}', [NotulensiController::class, 'update'])->name('notulensi.update');
    });
    Route::middleware('permission:notulensi.view')->group(function () {
        Route::get('/notulensi', [NotulensiController::class, 'index'])->name('notulensi.index');
        Route::get('/notulensi/{notulensi}', [NotulensiController::class, 'show'])->name('notulensi.show');
    });
    Route::delete('/notulensi/{notulensi}', [NotulensiController::class, 'destroy'])
        ->middleware('permission:notulensi.delete')->name('notulensi.destroy');

    // ===== KEUANGAN & KAS (DIVISI BENDAHARA) =====
    Route::middleware('permission:kas.view')->group(function () {
        Route::get('/kas/status-saya', [KasController::class, 'statusSaya'])->name('kas.status-saya');
    });
    Route::middleware('permission:kas.catat')->group(function () {
        Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
        Route::post('/kas/generate', [KasController::class, 'generateTagihan'])->name('kas.generate');
        Route::post('/kas/{tagihan}/bayar', [KasController::class, 'bayar'])->name('kas.bayar');
    });

    // ===== PENGELUARAN KAS =====
    Route::middleware('permission:pengeluaran.view')->group(function () {
        Route::get('/pengeluaran', [PengeluaranKasController::class, 'index'])->name('pengeluaran.index');
    });
    Route::middleware('permission:pengeluaran.create')->group(function () {
        Route::post('/pengeluaran', [PengeluaranKasController::class, 'store'])->name('pengeluaran.store');
    });
    Route::delete('/pengeluaran/{pengeluaran}', [PengeluaranKasController::class, 'destroy'])
        ->middleware('permission:pengeluaran.delete')->name('pengeluaran.destroy');

    // ===== MANAJEMEN PENGGUNA & DATABASE ANGGOTA =====
    Route::middleware('permission:user.manage')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
