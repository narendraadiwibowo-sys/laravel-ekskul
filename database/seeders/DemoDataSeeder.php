<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use App\Models\JadwalKegiatan;
use App\Models\Notulensi;
use App\Models\PembayaranKas;
use App\Models\PengeluaranKas;
use App\Models\Pengumuman;
use App\Models\PeminjamanInventaris;
use App\Models\Presensi;
use App\Models\ProgramKegiatan;
use App\Models\SuratMenyurat;
use App\Models\TagihanKas;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin      = User::where('email', 'admin@email.com')->first();
        $ketua      = User::where('email', 'ketua@ekskul.test')->first() ?? $admin;
        $sekretaris = User::where('email', 'sekretaris@ekskul.test')->first() ?? $admin;
        $bendahara  = User::where('email', 'bendahara@ekskul.test')->first() ?? $admin;
        $humas      = User::where('email', 'humas@ekskul.test')->first() ?? $admin;
        $acara      = User::where('email', 'acara@ekskul.test')->first() ?? $admin;
        $pdd        = User::where('email', 'pdd@ekskul.test')->first() ?? $admin;
        $perkap     = User::where('email', 'perkap@ekskul.test')->first() ?? $admin;
        $userAnggota= User::where('email', 'user@email.com')->first();
        $dewiAnggota= User::where('email', 'anggota@ekskul.test')->first();

        // ==========================================
        // 1. JADWAL KEGIATAN (DIVISI ACARA)
        // ==========================================
        $jadwal1 = JadwalKegiatan::updateOrCreate(
            ['judul' => 'Weekly English Speaking Club & Debate Routine'],
            [
                'deskripsi' => 'Latihan rutin public speaking, percakapan tematik seputar teknologi dan persiapan lomba debat bahasa Inggris antar-SMK.',
                'tanggal' => now()->addDays(2)->toDateString(),
                'waktu_mulai' => '15:30:00',
                'waktu_selesai' => '17:00:00',
                'lokasi' => 'Lab Bahasa 1 SMKN 1 Purwokerto',
                'status' => 'upcoming',
                'dibuat_oleh' => $acara->id,
            ]
        );

        $jadwal2 = JadwalKegiatan::updateOrCreate(
            ['judul' => 'TOEIC & English Proficiency Intensive Preparation'],
            [
                'deskripsi' => 'Bedah materi & drilling latihan soal TOEIC Listening and Reading comprehension bersama pembina.',
                'tanggal' => now()->addDays(7)->toDateString(),
                'waktu_mulai' => '15:00:00',
                'waktu_selesai' => '16:45:00',
                'lokasi' => 'Ruang Multimedia 2',
                'status' => 'upcoming',
                'dibuat_oleh' => $acara->id,
            ]
        );

        $jadwalLalu = JadwalKegiatan::updateOrCreate(
            ['judul' => 'SEC General Orientation & Ice Breaking 2026'],
            [
                'deskripsi' => 'Pengenalan struktur organisasi SEC periode baru, pemaparan proker, dan sambutan pengurus inti.',
                'tanggal' => now()->subDays(4)->toDateString(),
                'waktu_mulai' => '15:30:00',
                'waktu_selesai' => '17:15:00',
                'lokasi' => 'Aula Sasana Krida SMKN 1 Purwokerto',
                'status' => 'completed',
                'dibuat_oleh' => $acara->id,
            ]
        );

        // ==========================================
        // 2. PRESENSI (DIVISI SEKRETARIS)
        // ==========================================
        if ($userAnggota) {
            Presensi::updateOrCreate(
                ['jadwal_kegiatan_id' => $jadwalLalu->id, 'user_id' => $userAnggota->id],
                ['status' => 'hadir', 'dicatat_oleh' => $sekretaris->id]
            );
        }
        if ($dewiAnggota) {
            Presensi::updateOrCreate(
                ['jadwal_kegiatan_id' => $jadwalLalu->id, 'user_id' => $dewiAnggota->id],
                ['status' => 'hadir', 'dicatat_oleh' => $sekretaris->id]
            );
        }

        // ==========================================
        // 3. NOTULENSI (DIVISI SEKRETARIS)
        // ==========================================
        Notulensi::updateOrCreate(
            ['judul' => 'Notulensi: Rapat Pleno Perdana & Pemantapan Agenda Semester'],
            [
                'jadwal_kegiatan_id' => $jadwalLalu->id,
                'isi' => "Ringkasan Rapat Pleno:\n1. Sambutan dan pengesahan kepengurusan oleh Pembina SEC.\n2. Penetapan jadwal rutin: Setiap hari Rabu sore pukul 15.30 di Lab Bahasa.\n3. Divisi Acara menetapkan target penyelenggaraan SEC English Festival bulan depan.\n4. Iuran kas anggota diputuskan Rp 5.000 / bulan untuk operasional berkas dan konsumsi.\n5. Divisi PDD mengelola repository drive arsip foto kegiatan secara terpusat.",
                'dibuat_oleh' => $sekretaris->id,
            ]
        );

        // ==========================================
        // 4. SURAT MENYURAT (DIVISI SEKRETARIS)
        // ==========================================
        SuratMenyurat::updateOrCreate(
            ['nomor_surat' => '001/SEC-SMKN1/UND/X/2026'],
            [
                'jenis' => 'keluar',
                'perihal' => 'Permohonan Peminjaman Lab Bahasa untuk Kegiatan Rutin',
                'asal_tujuan' => 'Kepala Laboratorium Komputer & Bahasa SMKN 1',
                'tanggal_surat' => now()->subDays(6)->toDateString(),
                'tanggal_terima_kirim' => now()->subDays(5)->toDateString(),
                'keterangan' => 'Disetujui untuk pemakaian setiap Rabu siang - sore.',
                'dicatat_oleh' => $sekretaris->id,
            ]
        );

        SuratMenyurat::updateOrCreate(
            ['nomor_surat' => '421.5/082/OSIS/2026'],
            [
                'jenis' => 'masuk',
                'perihal' => 'Undangan Partisipasi Perwakilan Gelar Budaya & Lomba Bahasa',
                'asal_tujuan' => 'Pengurus OSIS SMKN 1 Purwokerto',
                'tanggal_surat' => now()->subDays(3)->toDateString(),
                'tanggal_terima_kirim' => now()->subDays(2)->toDateString(),
                'keterangan' => 'Delegasi 4 peserta untuk kategori Storytelling dan Speech.',
                'dicatat_oleh' => $sekretaris->id,
            ]
        );

        // ==========================================
        // 5. PAPAN PENGUMUMAN (DIVISI HUMAS)
        // ==========================================
        Pengumuman::updateOrCreate(
            ['judul' => '📢 Pendaftaran Delegasi English Speech & Story Telling Contest 2026'],
            [
                'isi' => "Halo kawan-kawan anggota SEC! Bagi anggota kelas X dan XI yang berminat mewakili SMKN 1 Purwokerto dalam Lomba Bahasa Inggris tingkat Kabupaten Banyumas, harap mendaftarkan diri ke Divisi Humas atau menghubungi koordinator paling lambat hari Jumat ini.",
                'penting' => true,
                'berlaku_sampai' => now()->addDays(14)->toDateString(),
                'dibuat_oleh' => $humas->id,
            ]
        );

        Pengumuman::updateOrCreate(
            ['judul' => 'Informasi Jadwal Latihan Rutin & Tata Tertib Lab Bahasa'],
            [
                'isi' => "Diberitahukan kepada seluruh anggota, mulai minggu depan sesi speaking akan menggunakan modul conversation baru. Harap hadir tepat waktu pukul 15.30 WIB dan menjaga kebersihan Lab Bahasa 1.",
                'penting' => false,
                'berlaku_sampai' => now()->addDays(30)->toDateString(),
                'dibuat_oleh' => $humas->id,
            ]
        );

        // ==========================================
        // 6. PROGRAM KEGIATAN / PROKER (DIVISI ACARA)
        // ==========================================
        ProgramKegiatan::updateOrCreate(
            ['judul' => 'SEC English Week & Festival Competition 2026'],
            [
                'deskripsi' => 'Kompetisi internal sekolah yang mencakup Speech, Scrabble, Spelling Bee, dan Short Movie dubbing antar-kelas.',
                'tanggal_mulai' => now()->addDays(20)->toDateString(),
                'tanggal_selesai' => now()->addDays(25)->toDateString(),
                'status' => 'persiapan',
                'prioritas' => 'tinggi',
                'pic' => 'Fellisya Luthfia Milani',
                'catatan' => 'Proposal telah ditandatangani Pembina, sedang pengajuan ruangan ke Waka Kesiswaan.',
                'dibuat_oleh' => $acara->id,
            ]
        );

        ProgramKegiatan::updateOrCreate(
            ['judul' => 'Workshop TOEIC Mastery for Vocational Students'],
            [
                'deskripsi' => 'Pelatihan intensif kiat sukses meraih skor TOEIC 750+ untuk persiapan magang dan beasiswa kerja luar negeri.',
                'tanggal_mulai' => now()->addDays(40)->toDateString(),
                'tanggal_selesai' => now()->addDays(41)->toDateString(),
                'status' => 'perencanaan',
                'prioritas' => 'sedang',
                'pic' => 'Shahinda Adawiyah',
                'catatan' => 'Sedang menyusun draft pemateri alumni yang bekerja di multinasional.',
                'dibuat_oleh' => $acara->id,
            ]
        );

        ProgramKegiatan::updateOrCreate(
            ['judul' => 'Open Recruitment & Welcoming Party New Members'],
            [
                'deskripsi' => 'Penerimaan anggota baru angkatan 2026 dan pembekalan dasar.',
                'tanggal_mulai' => now()->subDays(10)->toDateString(),
                'tanggal_selesai' => now()->subDays(4)->toDateString(),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'pic' => 'Ravanelli Putra (Ketua)',
                'catatan' => 'Sukses dilaksanakan, total 48 peserta baru bergabung.',
                'dibuat_oleh' => $acara->id,
            ]
        );

        // ==========================================
        // 7. INVENTARIS & PEMINJAMAN (DIVISI PERKAP)
        // ==========================================
        $inv1 = Inventaris::updateOrCreate(
            ['nama_barang' => 'Wireless Microphone Set Sony (2 Mic + Receiver)'],
            [
                'kode' => 'INV-SEC-001',
                'kategori' => 'elektronik',
                'jumlah' => 2,
                'kondisi' => 'baik',
                'keterangan' => 'Disimpan di lemari inventaris SEC Lab Bahasa',
                'dicatat_oleh' => $perkap->id,
            ]
        );

        $inv2 = Inventaris::updateOrCreate(
            ['nama_barang' => 'Portable Bluetooth Speaker Advance 12 Inch'],
            [
                'kode' => 'INV-SEC-002',
                'kategori' => 'elektronik',
                'jumlah' => 1,
                'kondisi' => 'baik',
                'keterangan' => 'Untuk latihan speaking outdoor dan acara festival',
                'dicatat_oleh' => $perkap->id,
            ]
        );

        $inv3 = Inventaris::updateOrCreate(
            ['nama_barang' => 'Papan Whiteboard Kecil & Spidol Snowman Boardmarker'],
            [
                'kode' => 'INV-SEC-003',
                'kategori' => 'atk',
                'jumlah' => 6,
                'kondisi' => 'baik',
                'keterangan' => 'Media kuis dan vocabulary challenge kelompok',
                'dicatat_oleh' => $perkap->id,
            ]
        );

        $inv4 = Inventaris::updateOrCreate(
            ['nama_barang' => 'Banner Backdrop SEC SMKN 1 (Ukuran 3x2 M)'],
            [
                'kode' => 'INV-SEC-004',
                'kategori' => 'properti',
                'jumlah' => 1,
                'kondisi' => 'baik',
                'keterangan' => 'Backdrop resmi foto kegiatan',
                'dicatat_oleh' => $perkap->id,
            ]
        );

        // Log peminjaman barang
        if ($userAnggota) {
            PeminjamanInventaris::updateOrCreate(
                [
                    'inventaris_id' => $inv1->id,
                    'user_id' => $userAnggota->id,
                    'tanggal_pinjam' => now()->subDays(4)->toDateString(),
                ],
                [
                    'jumlah_pinjam' => 1,
                    'keperluan' => 'Praktek MC Bahasa Inggris di Aula',
                    'tanggal_kembali_rencana' => now()->subDays(4)->toDateString(),
                    'tanggal_kembali_aktual' => now()->subDays(4)->toDateString(),
                    'status' => 'dikembalikan',
                    'dicatat_oleh' => $perkap->id,
                ]
            );
        }

        // ==========================================
        // 8. KEUANGAN & KAS ANGGOTA (DIVISI BENDAHARA)
        // ==========================================
        $anggotas = User::role('anggota')->get();
        foreach ($anggotas as $agt) {
            // Tagihan bulan ini (berjalan)
            TagihanKas::updateOrCreate(
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

            // Tagihan bulan lalu (sudah lunas)
            $bulanLalu = now()->subMonth();
            $tagihanLalu = TagihanKas::updateOrCreate(
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

            PembayaranKas::updateOrCreate(
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

        // Catatan Pengeluaran Kas
        PengeluaranKas::updateOrCreate(
            ['judul' => 'Pembelian Spidol Whiteboard & Baterai Mic Wireless'],
            [
                'nominal' => 35000,
                'tanggal' => now()->subDays(5)->toDateString(),
                'kategori' => 'alat',
                'keterangan' => 'Keperluan latihan speaking & vocabulary di lab',
                'dicatat_oleh' => $bendahara->id,
            ]
        );

        PengeluaranKas::updateOrCreate(
            ['judul' => 'Konsumsi Snack & Air Mineral Ice Breaking Peserta'],
            [
                'nominal' => 60000,
                'tanggal' => now()->subDays(4)->toDateString(),
                'kategori' => 'konsumsi',
                'keterangan' => 'Roti dan air mineral untuk orientasi anggota baru',
                'dicatat_oleh' => $bendahara->id,
            ]
        );

        PengeluaranKas::updateOrCreate(
            ['judul' => 'Print & Jilid Proposal SEC English Festival 2026'],
            [
                'nominal' => 20000,
                'tanggal' => now()->subDays(1)->toDateString(),
                'kategori' => 'alat',
                'keterangan' => 'Penggandaan proposal ke Kepala Sekolah & Komite',
                'dicatat_oleh' => $bendahara->id,
            ]
        );
    }
}
