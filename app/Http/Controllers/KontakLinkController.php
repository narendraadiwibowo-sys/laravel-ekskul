<?php

namespace App\Http\Controllers;

use App\Models\KontakLink;
use Illuminate\Http\Request;

class KontakLinkController extends Controller
{
    public function index(Request $request)
    {
        $query = KontakLink::with('pembuat');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kontak_url', 'like', '%' . $request->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        $kontaks = $query->latest()->paginate(15);
        $totalKontak = KontakLink::count();

        return view('kontak.index', compact('kontaks', 'totalKontak'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pembina,sekolah,sosmed,grup_link,lainnya',
            'kontak_url' => 'required|string|max:500',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $data['dibuat_oleh'] = auth()->id();
        KontakLink::create($data);

        return redirect()->route('kontak.index')->with('success', 'Kontak / Link resmi berhasil ditambahkan.');
    }

    public function update(Request $request, KontakLink $kontak)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pembina,sekolah,sosmed,grup_link,lainnya',
            'kontak_url' => 'required|string|max:500',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $kontak->update($data);

        return redirect()->route('kontak.index')->with('success', 'Kontak / Link berhasil diperbarui.');
    }

    public function destroy(KontakLink $kontak)
    {
        $kontak->delete();

        return redirect()->route('kontak.index')->with('success', 'Kontak / Link berhasil dihapus.');
    }
}
