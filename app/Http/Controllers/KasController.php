<?php

namespace App\Http\Controllers;

use App\Models\PembayaranKas;
use App\Models\TagihanKas;
use App\Models\User;
use Illuminate\Http\Request;

class KasController extends Controller
{
    // Dashboard bendahara: rekap semua tagihan bulan tertentu
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $tagihans = TagihanKas::with('anggota')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $totalLunas = $tagihans->where('status', 'lunas')->sum('nominal');
        $totalBelumLunas = $tagihans->where('status', 'belum_lunas')->sum('nominal');

        return view('kas.index', compact('tagihans', 'bulan', 'tahun', 'totalLunas', 'totalBelumLunas'));
    }

    // Generate tagihan kas untuk SEMUA anggota di bulan berjalan.
    // Jalankan manual oleh bendahara tiap awal bulan, atau jadwalkan via Laravel Scheduler.
    public function generateTagihan(Request $request)
    {
        $data = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'nominal' => 'required|integer|min:0',
        ]);

        $anggotas = User::role('anggota')->get();

        $dibuat = 0;
        foreach ($anggotas as $anggota) {
            $tagihan = TagihanKas::firstOrCreate(
                [
                    'user_id' => $anggota->id,
                    'bulan' => $data['bulan'],
                    'tahun' => $data['tahun'],
                ],
                [
                    'nominal' => $data['nominal'],
                    'status' => 'belum_lunas',
                ]
            );
            if ($tagihan->wasRecentlyCreated) {
                $dibuat++;
            }
        }

        return back()->with('success', "Tagihan berhasil digenerate untuk {$dibuat} anggota baru.");
    }

    // Bendahara mencatat pembayaran yang melunasi sebuah tagihan
    public function bayar(Request $request, TagihanKas $tagihan)
    {
        $data = $request->validate([
            'nominal' => 'required|integer|min:1',
            'tanggal_bayar' => 'required|date',
        ]);

        PembayaranKas::create([
            'tagihan_kas_id' => $tagihan->id,
            'user_id' => $tagihan->user_id,
            'nominal' => $data['nominal'],
            'tanggal_bayar' => $data['tanggal_bayar'],
            'dicatat_oleh' => auth()->id(),
        ]);

        // tandai lunas kalau total pembayaran >= nominal tagihan
        $totalDibayar = $tagihan->pembayaran()->sum('nominal');
        if ($totalDibayar >= $tagihan->nominal) {
            $tagihan->update(['status' => 'lunas']);
        }

        return back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    // Dashboard anggota: lihat status kas dirinya sendiri
    public function statusSaya()
    {
        $user = auth()->user();

        $tagihanBulanIni = $user->tagihanBulanIni();

        $riwayat = TagihanKas::where('user_id', $user->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('kas.status-saya', compact('tagihanBulanIni', 'riwayat'));
    }
}
