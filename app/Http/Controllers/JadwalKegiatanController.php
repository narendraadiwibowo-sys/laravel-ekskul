<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;

class JadwalKegiatanController extends Controller
{
    public function index()
    {
        // Permission sudah dicek via middleware di routes, tidak perlu Policy
        $jadwals = JadwalKegiatan::orderBy("tanggal", "desc")->paginate(15);

        // Banner H-1: jadwal yang jatuh besok
        $jadwalBesok = JadwalKegiatan::whereDate("tanggal", now()->addDay()->toDateString())
            ->where("status", "upcoming")
            ->get();

        return view("jadwal.index", compact("jadwals", "jadwalBesok"));
    }

    public function create()
    {
        return view("jadwal.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "judul"         => "required|string|max:255",
            "deskripsi"     => "nullable|string",
            "tanggal"       => "required|date",
            "waktu_mulai"   => "required",
            "waktu_selesai" => "nullable",
            "lokasi"        => "nullable|string|max:255",
        ]);

        $data["status"]     = "upcoming";
        $data["dibuat_oleh"] = auth()->id();

        JadwalKegiatan::create($data);

        return redirect()->route("jadwal.index")->with("success", "Jadwal berhasil ditambahkan.");
    }

    public function edit(JadwalKegiatan $jadwal)
    {
        return view("jadwal.edit", compact("jadwal"));
    }

    public function update(Request $request, JadwalKegiatan $jadwal)
    {
        $data = $request->validate([
            "judul"         => "required|string|max:255",
            "deskripsi"     => "nullable|string",
            "tanggal"       => "required|date",
            "waktu_mulai"   => "required",
            "waktu_selesai" => "nullable",
            "lokasi"        => "nullable|string|max:255",
            "status"        => "required|in:upcoming,ongoing,completed",
        ]);

        $jadwal->update($data);

        return redirect()->route("jadwal.index")->with("success", "Jadwal berhasil diperbarui.");
    }

    public function destroy(JadwalKegiatan $jadwal)
    {
        $jadwal->delete();

        return redirect()->route("jadwal.index")->with("success", "Jadwal berhasil dihapus.");
    }
}
