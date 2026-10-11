<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    // Form isi presensi untuk 1 jadwal kegiatan (khusus sekretaris)
    public function create(JadwalKegiatan $jadwal)
    {
        // semua anggota (role anggota) yang bisa dipresensi
        $anggotas = User::role('anggota')->orderBy('name')->get();

        // presensi yang udah ada buat jadwal ini (kalau lagi edit)
        $existing = Presensi::where('jadwal_kegiatan_id', $jadwal->id)
            ->pluck('status', 'user_id');

        return view('presensi.create', compact('jadwal', 'anggotas', 'existing'));
    }

    // Simpan presensi massal (checklist per anggota)
    public function store(Request $request, JadwalKegiatan $jadwal)
    {
        $data = $request->validate([
            'presensi' => 'required|array',
            'presensi.*' => 'required|in:hadir,izin,alpa',
        ]);

        foreach ($data['presensi'] as $userId => $status) {
            Presensi::updateOrCreate(
                ['jadwal_kegiatan_id' => $jadwal->id, 'user_id' => $userId],
                ['status' => $status, 'dicatat_oleh' => auth()->id()]
            );
        }

        return redirect()->route('jadwal.index')->with('success', 'Presensi berhasil disimpan.');
    }

    // Rekap persentase kehadiran semua anggota (buat laporan / pembina)
    public function rekap()
    {
        $anggotas = User::role('anggota')->orderBy('name')->get()
            ->map(function ($user) {
                return [
                    'nama' => $user->name,
                    'kelas' => $user->kelas,
                    'persen_kehadiran' => $user->persenKehadiran(),
                ];
            });

        return view('presensi.rekap', compact('anggotas'));
    }
}
