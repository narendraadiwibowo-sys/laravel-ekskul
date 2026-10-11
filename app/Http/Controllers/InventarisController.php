<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\PeminjamanInventaris;
use App\Models\User;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventaris::with(['dicatatOleh', 'peminjamanAktif.peminjam']);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->latest()->paginate(15);
        $totalBarang = Inventaris::sum('jumlah');
        $barangBaik = Inventaris::where('kondisi', 'baik')->sum('jumlah');
        $barangRusak = Inventaris::whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->sum('jumlah');
        $totalDipinjam = PeminjamanInventaris::where('status', 'dipinjam')->sum('jumlah_pinjam');
        $riwayatPinjam = PeminjamanInventaris::with(['inventaris', 'peminjam'])->latest()->take(10)->get();
        $users = User::orderBy('name')->get();

        return view('inventaris.index', compact(
            'items', 'totalBarang', 'barangBaik', 'barangRusak', 'totalDipinjam', 'riwayatPinjam', 'users'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode' => 'nullable|string|max:100|unique:inventaris,kode',
            'kategori' => 'required|in:elektronik,properti,atk,lainnya',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'keterangan' => 'nullable|string',
        ]);

        $data['dicatat_oleh'] = auth()->id();
        Inventaris::create($data);

        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris berhasil ditambahkan.');
    }

    public function update(Request $request, Inventaris $inventari)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode' => 'nullable|string|max:100|unique:inventaris,kode,' . $inventari->id,
            'kategori' => 'required|in:elektronik,properti,atk,lainnya',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'keterangan' => 'nullable|string',
        ]);

        $inventari->update($data);

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diupdate.');
    }

    public function destroy(Inventaris $inventari)
    {
        $inventari->delete();
        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris berhasil dihapus.');
    }

    // Peminjaman
    public function pinjam(Request $request, Inventaris $inventari)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah_pinjam' => 'required|integer|min:1|max:' . $inventari->jumlah,
            'keperluan' => 'nullable|string',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        $data['inventaris_id'] = $inventari->id;
        $data['status'] = 'dipinjam';
        $data['dicatat_oleh'] = auth()->id();

        PeminjamanInventaris::create($data);

        return back()->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function kembalikan(PeminjamanInventaris $peminjaman)
    {
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali_aktual' => now()->toDateString(),
        ]);

        return back()->with('success', 'Barang telah dikembalikan.');
    }
}
