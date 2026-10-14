<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $periode = '2026/2027';
        $semua = Pengurus::where('periode', $periode)->orderBy('urutan')->get();

        $inti       = $semua->where('divisi', 'Inti');
        $sekretaris = $semua->where('divisi', 'Sekretaris');
        $bendahara  = $semua->where('divisi', 'Bendahara');
        $humas      = $semua->where('divisi', 'Humas');
        $acara      = $semua->where('divisi', 'Acara');
        $pdd        = $semua->where('divisi', 'PDD');
        $perkap     = $semua->where('divisi', 'Perkap');

        return view('struktur.index', compact(
            'inti', 'sekretaris', 'bendahara',
            'humas', 'acara', 'pdd', 'perkap', 'periode'
        ));
    }

    public function manage()
    {
        $penguruses = Pengurus::orderBy('urutan')->get()->groupBy('divisi');
        return view('struktur.manage', compact('penguruses'));
    }

    public function create() { return view('struktur.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|in:Inti,Sekretaris,Bendahara,Humas,Acara,PDD,Perkap',
            'is_koordinator' => 'nullable|boolean',
            'kelas' => 'nullable|string|max:50',
            'instagram' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'urutan' => 'nullable|integer',
            'periode' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('foto')) {
            $dir = public_path('images/pengurus');
            if (!file_exists($dir)) {
                @mkdir($dir, 0755, true);
            }
            $file = $request->file('foto');
            $nama = time() . '_' . str($data['nama'])->slug() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nama);
            $data['foto'] = $nama;
        }

        $data['is_koordinator'] = $request->boolean('is_koordinator');
        $data['periode'] = $data['periode'] ?? '2026/2027';

        Pengurus::create($data);

        return redirect()->route('struktur.manage')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(Pengurus $pengurus)
    {
        return view('struktur.edit', compact('pengurus'));
    }

    public function update(Request $request, Pengurus $pengurus)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|in:Inti,Sekretaris,Bendahara,Humas,Acara,PDD,Perkap',
            'is_koordinator' => 'nullable|boolean',
            'kelas' => 'nullable|string|max:50',
            'instagram' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'urutan' => 'nullable|integer',
            'periode' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('foto')) {
            $dir = public_path('images/pengurus');
            if (!file_exists($dir)) {
                @mkdir($dir, 0755, true);
            }
            // hapus foto lama jika ada
            if ($pengurus->foto && file_exists($dir . '/' . $pengurus->foto)) {
                @unlink($dir . '/' . $pengurus->foto);
            }
            $file = $request->file('foto');
            $nama = time() . '_' . str($data['nama'])->slug() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nama);
            $data['foto'] = $nama;
        }

        $data['is_koordinator'] = $request->boolean('is_koordinator');

        $pengurus->update($data);

        return redirect()->route('struktur.manage')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(Pengurus $pengurus)
    {
        if ($pengurus->foto && !str_starts_with($pengurus->foto, 'default') && file_exists(public_path('images/pengurus/' . $pengurus->foto))) {
            @unlink(public_path('images/pengurus/' . $pengurus->foto));
        }
        $pengurus->delete();
        return back()->with('success', 'Pengurus berhasil dihapus.');
    }
}
