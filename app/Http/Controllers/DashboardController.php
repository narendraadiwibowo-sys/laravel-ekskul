<?php

namespace App\Http\Controllers;

use App\Models\ArsipDrive;
use App\Models\Inventaris;
use App\Models\JadwalKegiatan;
use App\Models\PembayaranKas;
use App\Models\PengeluaranKas;
use App\Models\Pengumuman;
use App\Models\ProgramKegiatan;
use App\Models\SuratMenyurat;
use App\Models\TagihanKas;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Notice Board / Pengumuman aktif untuk semua anggota
        $pengumumans = Pengumuman::where(function ($q) {
            $q->whereNull('berlaku_sampai')
              ->orWhere('berlaku_sampai', '>=', now()->toDateString());
        })->latest()->take(5)->get();

        // 2. Banner H-1 & Jadwal Terdekat
        $jadwalBesok = JadwalKegiatan::whereDate("tanggal", now()->addDay()->toDateString())
            ->where("status", "upcoming")
            ->get();

        $jadwalTerdekat = JadwalKegiatan::where("tanggal", ">=", now()->toDateString())
            ->orderBy("tanggal")
            ->take(5)
            ->get();

        $eventTerdekat = ProgramKegiatan::where('tanggal_mulai', '>=', now()->toDateString())
            ->where('status', '!=', 'selesai')
            ->orderBy('tanggal_mulai')
            ->first();

        // 3. Status kas pribadi bulan ini
        $tagihanBulanIni = $user->can("kas.view") ? $user->tagihanBulanIni() : null;

        // 4. Summary Keuangan (Sisa Uang Kas / Saldo)
        $totalPemasukan = PembayaranKas::sum('nominal');
        $totalPengeluaran = PengeluaranKas::sum('nominal');
        $sisaKas = $totalPemasukan - $totalPengeluaran;

        // 5. Inventaris (Perkap)
        $barangTersedia = Inventaris::where('kondisi', 'baik')->sum('jumlah');
        $barangRusak = Inventaris::whereIn('kondisi', ['rusak_ringan', 'rusak_berat', 'hilang'])->sum('jumlah');

        // 6. Stats & Divisi metrics
        $stats = [
            'sisa_kas' => $sisaKas,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'barang_tersedia' => $barangTersedia,
            'barang_rusak' => $barangRusak,
            'total_anggota' => User::count(),
            'total_proker' => ProgramKegiatan::count(),
            'proker_berjalan' => ProgramKegiatan::whereIn('status', ['persiapan', 'sedang_berjalan'])->count(),
            'total_surat' => SuratMenyurat::count(),
            'total_drive' => ArsipDrive::count(),
            'total_lunas' => TagihanKas::where("bulan", now()->month)->where("tahun", now()->year)->where("status", "lunas")->count(),
            'total_belum' => TagihanKas::where("bulan", now()->month)->where("tahun", now()->year)->where("status", "belum_lunas")->count(),
        ];

        $pamfletH1 = ArsipDrive::where('tipe', 'pamflet')
            ->where('status_tayang', 'siap_tayang')
            ->whereDate('tanggal_tayang', '<=', now()->addDay()->toDateString())
            ->get();

        return view("dashboard", compact(
            'pengumumans',
            'jadwalBesok',
            'jadwalTerdekat',
            'eventTerdekat',
            'pamfletH1',
            'tagihanBulanIni',
            'stats'
        ));
    }
}
