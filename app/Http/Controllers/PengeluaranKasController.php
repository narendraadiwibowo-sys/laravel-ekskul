<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranKas;
use Illuminate\Http\Request;

class PengeluaranKasController extends Controller
{
    public function index()
    {
        $pengeluarans = PengeluaranKas::orderBy('tanggal', 'desc')->paginate(15);
        $totalBulanIni = PengeluaranKas::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');

        return view('pengeluaran.index', compact('pengeluarans', 'totalBulanIni'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'nominal' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:alat,konsumsi,lainnya',
            'keterangan' => 'nullable|string',
        ]);

        $data['dicatat_oleh'] = auth()->id();

        PengeluaranKas::create($data);

        return back()->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function destroy(PengeluaranKas $pengeluaran)
    {
        $pengeluaran->delete();
        return back()->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
