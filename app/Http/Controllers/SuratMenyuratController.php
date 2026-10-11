<?php

namespace App\Http\Controllers;

use App\Models\SuratMenyurat;
use Illuminate\Http\Request;

class SuratMenyuratController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMenyurat::with('pencatat');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                  ->orWhere('perihal', 'like', '%' . $request->search . '%')
                  ->orWhere('asal_tujuan', 'like', '%' . $request->search . '%');
            });
        }

        $surats = $query->latest('tanggal_surat')->paginate(15);
        $totalMasuk = SuratMenyurat::where('jenis', 'masuk')->count();
        $totalKeluar = SuratMenyurat::where('jenis', 'keluar')->count();

        return view('surat.index', compact('surats', 'totalMasuk', 'totalKeluar'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'jenis' => 'required|in:masuk,keluar',
            'perihal' => 'required|string|max:255',
            'asal_tujuan' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima_kirim' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $data['dicatat_oleh'] = auth()->id();
        SuratMenyurat::create($data);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dicatat.');
    }

    public function update(Request $request, SuratMenyurat $surat)
    {
        $data = $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'jenis' => 'required|in:masuk,keluar',
            'perihal' => 'required|string|max:255',
            'asal_tujuan' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima_kirim' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $surat->update($data);

        return redirect()->route('surat.index')->with('success', 'Data surat berhasil diupdate.');
    }

    public function destroy(SuratMenyurat $surat)
    {
        $surat->delete();
        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus.');
    }
}
