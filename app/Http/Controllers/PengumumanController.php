<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->paginate(15);
        // untuk form create di sidebar
        return view('pengumuman.index', compact('pengumumans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'penting' => 'nullable|boolean',
            'berlaku_sampai' => 'nullable|date',
        ]);
        $data['dibuat_oleh'] = auth()->id();
        $data['penting'] = $request->boolean('penting');
        Pengumuman::create($data);
        return back()->with('success', 'Pengumuman berhasil dikirim!');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }

    // API-style untuk dashboard: ambil pengumuman aktif
    public static function aktif()
    {
        return Pengumuman::where(function ($q) {
            $q->whereNull('berlaku_sampai')
              ->orWhere('berlaku_sampai', '>=', now()->toDateString());
        })->latest()->take(5)->get();
    }
}
