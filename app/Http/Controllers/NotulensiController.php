<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\Notulensi;
use Illuminate\Http\Request;

class NotulensiController extends Controller
{
    public function index()
    {
        $notulensis = Notulensi::with('jadwal', 'penulis')->latest()->paginate(10);
        return view('notulensi.index', compact('notulensis'));
    }

    public function show(Notulensi $notulensi)
    {
        return view('notulensi.show', compact('notulensi'));
    }

    public function create()
    {
        $jadwals = JadwalKegiatan::orderBy('tanggal', 'desc')->get();
        return view('notulensi.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jadwal_kegiatan_id' => 'nullable|exists:jadwal_kegiatans,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $data['dibuat_oleh'] = auth()->id();

        Notulensi::create($data);

        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil disimpan.');
    }

    public function edit(Notulensi $notulensi)
    {
        $jadwals = JadwalKegiatan::orderBy('tanggal', 'desc')->get();
        return view('notulensi.edit', compact('notulensi', 'jadwals'));
    }

    public function update(Request $request, Notulensi $notulensi)
    {
        $data = $request->validate([
            'jadwal_kegiatan_id' => 'nullable|exists:jadwal_kegiatans,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $notulensi->update($data);

        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil diperbarui.');
    }

    public function destroy(Notulensi $notulensi)
    {
        $notulensi->delete();
        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil dihapus.');
    }
}
