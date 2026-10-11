<?php

namespace Database\Seeders;

use App\Models\JadwalKegiatan;
use App\Models\Notulensi;
use App\Models\PembayaranKas;
use App\Models\PengeluaranKas;
use App\Models\Presensi;
use App\Models\TagihanKas;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@email.com')->first();
        $sekretaris = User::where('email', 'sekretaris@ekskul.test')->first() ?? $admin;
        $bendahara = User::where('email', 'bendahara@ekskul.test')->first() ?? $admin;
        $userAnggota = User::where('email', 'user@email.com')->first();
        $dewiAnggota = User::where('email', 'anggota@ekskul.test')->first();

        // 1. Jadwal Kegiatan
        $jadwalBesok = JadwalKegiatan::firstOrCreate(
            ['judul' => 'Weekly English Speaking Club & Debate'],
            [
                'deskripsi' => 'Latihan rutin public speaking, percakapan tematik seputar teknologi dan persiapan lomba debat bahasa Inggris.',
                'tanggal' => now()->addDay()->toDateString(),
                'waktu_mulai' => '15:30:00',
                'waktu_selesai' => '17:00:00',
                'lokasi' => 'Lab Bahasa 1 SMKN 1 Purwokerto',
                'status' => 'upcoming',
                'dibuat_oleh' => $admin->id,
            ]
        );

        $jadwalMingguDepan = JadwalKegiatan::firstOrCreate(
            ['judul' => 'TOEIC / English Proficiency Test Prep'],
            [
                'deskripsi' => 'Pembahasan latihan soal TOEIC Listening and Reading comprehension.',
                'tanggal' => now()->addDays(5)->toDateString(),
                'waktu_mulai' => '15:00:00',
                'waktu_selesai' => '16:30:00',
                'lokasi' => 'Ruang Multimedia 2',
                'status' => 'upcoming',
                'dibuat_oleh' => $admin->id,
            ]
        );

        $jadwalLalu = JadwalKegiatan::firstOrCreate(
            ['judul' => 'SEC General Orientation & Ice Breaking'],
            [
                'deskripsi' => 'Pengenalan struktur organisasi SEC periode baru dan perkenalan anggota baru.',
                'tanggal' => now()->subDays(3)->toDateString(),
                'waktu_mulai' => '15:30:00',
                'waktu_selesai' => '17:00:00',
                'lokasi' => 'Aula Utama SMKN 1 Purwokerto',
                'status' => 'completed',
                'dibuat_oleh' => $admin->id,
            ]
        );

        // 2. Presensi untuk Jadwal yang sudah selesai
        if ($userAnggota) {
            Presensi::firstOrCreate(
                ['jadwal_kegiatan_id' => $jadwalLalu->id, 'user_id' => $userAnggota->id],
                ['status' => 'hadir', 'dicatat_oleh' => $sekretaris->id]
            );
        }
        if ($dewiAnggota) {
            Presensi::firstOrCreate(
                ['jadwal_kegiatan_id' => $jadwalLalu->id, 'user_id' => $dewiAnggota->id],
                ['status' => 'hadir', 'dicatat_oleh' => $sekretaris->id]
            );
        }

        // 3. Notulensi Rapat
        Notulensi::firstOrCreate(
            ['judul' => 'Notulensi: General Orientation & Perencanaan Agenda Semester'],
            [
                'jadwal_kegiatan_id' => $jadwalLalu->id,
                'isi' => "Agenda Orientasi:\n1. Pembukaan oleh Pembina dan Ketua SEC.\n2. Pembagian divisi: Speaking & Debate, Writing, dan Event Organizer.\n3. Iuran kas anggota disepakati sebesar Rp 5.000 / bulan.\n4. Pertemuan rutin diadakan setiap hari Rabu pukul 15.30 WIB di Lab Bahasa.",
                'dibuat_oleh' => $sekretaris->id,
            ]
        );

        // 4. Tagihan Kas Anggota
        $anggotas = User::role('anggota')->get();
        foreach ($anggotas as $agt) {
            // Tagihan bulan ini
            TagihanKas::firstOrCreate(
                [
                    'user_id' => $agt->id,
                    'bulan' => now()->month,
                    'tahun' => now()->year,
                ],
                [
                    'nominal' => 5000,
                    'status' => 'belum_lunas',
                ]
            );

            // Tagihan bulan lalu (tandai sudah lunas)
            $bulanLalu = now()->subMonth();
            $tagihanLalu = TagihanKas::firstOrCreate(
                [
                    'user_id' => $agt->id,
                    'bulan' => $bulanLalu->month,
                    'tahun' => $bulanLalu->year,
                ],
                [
                    'nominal' => 5000,
                    'status' => 'lunas',
                ]
            );

            PembayaranKas::firstOrCreate(
                [
                    'tagihan_kas_id' => $tagihanLalu->id,
                    'user_id' => $agt->id,
                ],
                [
                    'nominal' => 5000,
                    'tanggal_bayar' => $bulanLalu->toDateString(),
                    'dicatat_oleh' => $bendahara->id,
                ]
            );
        }

        // 5. Catatan Pengeluaran Kas
        PengeluaranKas::firstOrCreate(
            ['judul' => 'Pembelian Spidol Whiteboard & Penghapus Lab Bahasa'],
            [
                'nominal' => 25000,
                'tanggal' => now()->subDays(4)->toDateString(),
                'kategori' => 'alat',
                'keterangan' => 'Keperluan latihan speaking & vocabulary di lab',
                'dicatat_oleh' => $bendahara->id,
            ]
        );

        PengeluaranKas::firstOrCreate(
            ['judul' => 'Konsumsi Snack Ice Breaking Peserta'],
            [
                'nominal' => 50000,
                'tanggal' => now()->subDays(2)->toDateString(),
                'kategori' => 'konsumsi',
                'keterangan' => 'Roti dan air mineral untuk orientasi',
                'dicatat_oleh' => $bendahara->id,
            ]
        );
    }
}
