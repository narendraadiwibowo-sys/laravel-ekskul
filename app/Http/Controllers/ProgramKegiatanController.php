<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatan;
use Illuminate\Http\Request;

class ProgramKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgramKegiatan::with('pembuat');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        $prokers = $query->orderByRaw("FIELD(status, 'sedang_berjalan', 'persiapan', 'pembuatan_proposal', 'perencanaan', 'selesai', 'dibatalkan')")
                         ->orderBy('tanggal_mulai')
                         ->paginate(15);

        $counts = [
            'total' => ProgramKegiatan::count(),
            'perencanaan' => ProgramKegiatan::where('status', 'perencanaan')->count(),
            'proposal' => ProgramKegiatan::where('status', 'pembuatan_proposal')->count(),
            'persiapan' => ProgramKegiatan::where('status', 'persiapan')->count(),
            'berjalan' => ProgramKegiatan::where('status', 'sedang_berjalan')->count(),
            'selesai' => ProgramKegiatan::where('status', 'selesai')->count(),
        ];

        return view('proker.index', compact('prokers', 'counts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:perencanaan,pembuatan_proposal,persiapan,sedang_berjalan,selesai,dibatalkan',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'pic' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $data['dibuat_oleh'] = auth()->id();
        ProgramKegiatan::create($data);

        return redirect()->route('proker.index')->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function update(Request $request, ProgramKegiatan $proker)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:perencanaan,pembuatan_proposal,persiapan,sedang_berjalan,selesai,dibatalkan',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'pic' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $proker->update($data);

        return redirect()->route('proker.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(ProgramKegiatan $proker)
    {
        $proker->delete();
        return redirect()->route('proker.index')->with('success', 'Program kerja berhasil dihapus.');
    }
}
