<?php

namespace Database\Seeders;

use App\Models\Pengurus;
use Illuminate\Database\Seeder;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Pemetaan 25 personil pengurus SEC SMKN 1 Purwokerto
         * Foto 1.jpg sampai 25.jpg diambil langsung dari folder public/images/
         * Sesuai instruksi: Divisi Acara TIDAK ADA Koordinator
         */
        $penguruses = [
            // ================================================
            // 1. INTI — Ketua & Wakil (Presidium Utama)
            // ================================================
            [
                'urutan'         => 1,
                'nama'           => 'Ravanelli Putra Maulana',
                'jabatan'        => 'Ketua Umum',
                'divisi'         => 'Inti',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 'ravv_putm',
                'foto'           => '1.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 2,
                'nama'           => 'Shelly Evelyn',
                'jabatan'        => 'Wakil Ketua',
                'divisi'         => 'Inti',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 2',
                'instagram'      => 'ev_shee',
                'foto'           => '2.jpg',
                'periode'        => '2026/2027',
            ],

            // ================================================
            // 2. SEKRETARIS
            // ================================================
            [
                'urutan'         => 3,
                'nama'           => 'Okta Nanda Ariska',
                'jabatan'        => 'Sekretaris 1 / Koordinator',
                'divisi'         => 'Sekretaris',
                'is_koordinator' => true,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 'onanawairy',
                'foto'           => '3.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 4,
                'nama'           => 'Amelia Nasywa',
                'jabatan'        => 'Sekretaris 2',
                'divisi'         => 'Sekretaris',
                'is_koordinator' => false,
                'kelas'          => 'XII DKV 2',
                'instagram'      => 'n.asywa_4',
                'foto'           => '4.jpg',
                'periode'        => '2026/2027',
            ],

            // ================================================
            // 3. BENDAHARA
            // ================================================
            [
                'urutan'         => 5,
                'nama'           => 'Vika Nur Aisyah',
                'jabatan'        => 'Bendahara 1 / Koordinator',
                'divisi'         => 'Bendahara',
                'is_koordinator' => true,
                'kelas'          => 'XII MPLB 4',
                'instagram'      => 'v1k4na',
                'foto'           => '5.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 6,
                'nama'           => 'Zein Vies Airin Nabila Yahya',
                'jabatan'        => 'Bendahara 2',
                'divisi'         => 'Bendahara',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 'zeinvies.airinn',
                'foto'           => '6.jpg',
                'periode'        => '2026/2027',
            ],

            // ================================================
            // 4. HUMAS
            // ================================================
            [
                'urutan'         => 7,
                'nama'           => 'Rieska Nur Fathonah',
                'jabatan'        => 'Koordinator Humas',
                'divisi'         => 'Humas',
                'is_koordinator' => true,
                'kelas'          => 'XII MPLB 1',
                'instagram'      => 'rskanf_',
                'foto'           => '7.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 8,
                'nama'           => 'Alifah Nurhidayah',
                'jabatan'        => 'Anggota Humas',
                'divisi'         => 'Humas',
                'is_koordinator' => false,
                'kelas'          => 'XII MPLB 1',
                'instagram'      => '__alifairy',
                'foto'           => '8.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 9,
                'nama'           => 'Zumratul Amanah',
                'jabatan'        => 'Anggota Humas',
                'divisi'         => 'Humas',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 'senaichi_',
                'foto'           => '9.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 10,
                'nama'           => 'Silvia Bella Oktaviani',
                'jabatan'        => 'Anggota Humas',
                'divisi'         => 'Humas',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 's.vybellaa',
                'foto'           => '10.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 11,
                'nama'           => 'Ika Agustiyana',
                'jabatan'        => 'Anggota Humas',
                'divisi'         => 'Humas',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 'theikaana_',
                'foto'           => '11.jpg',
                'periode'        => '2026/2027',
            ],

            // ================================================
            // 5. ACARA (Catatan: TIDAK ADA KOORDINATOR)
            // ================================================
            [
                'urutan'         => 12,
                'nama'           => 'Fellisya Luthfia Milani',
                'jabatan'        => 'Anggota Acara',
                'divisi'         => 'Acara',
                'is_koordinator' => false,
                'kelas'          => 'XII MPLB 1',
                'instagram'      => 'yvlynzaa',
                'foto'           => '12.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 13,
                'nama'           => 'Shahinda Adawiyah',
                'jabatan'        => 'Anggota Acara',
                'divisi'         => 'Acara',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 5',
                'instagram'      => 'shahinda.ad',
                'foto'           => '13.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 14,
                'nama'           => 'Risma Amelia',
                'jabatan'        => 'Anggota Acara',
                'divisi'         => 'Acara',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 'mlliaay_',
                'foto'           => '14.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 15,
                'nama'           => 'Mazaya Salsabila Zaafarani',
                'jabatan'        => 'Anggota Acara',
                'divisi'         => 'Acara',
                'is_koordinator' => false,
                'kelas'          => 'XII TF 1',
                'instagram'      => 'm.sabilasy_',
                'foto'           => '15.jpg',
                'periode'        => '2026/2027',
            ],

            // ================================================
            // 6. PDD (Publikasi, Dekorasi, Dokumentasi)
            // ================================================
            [
                'urutan'         => 16,
                'nama'           => 'Jireh Sabian Pangestu',
                'jabatan'        => 'Koordinator PDD',
                'divisi'         => 'PDD',
                'is_koordinator' => true,
                'kelas'          => 'XII DKV 1',
                'instagram'      => null,
                'foto'           => '16.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 17,
                'nama'           => 'Basma Kayla Sahrani',
                'jabatan'        => 'Anggota PDD',
                'divisi'         => 'PDD',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 5',
                'instagram'      => 'bsme._.u',
                'foto'           => '17.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 18,
                'nama'           => 'Nayara Irfiana Putri',
                'jabatan'        => 'Anggota PDD',
                'divisi'         => 'PDD',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 5',
                'instagram'      => 'yra4aaa_',
                'foto'           => '18.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 19,
                'nama'           => 'Narendra Adi Wibowo',
                'jabatan'        => 'Anggota PDD',
                'divisi'         => 'PDD',
                'is_koordinator' => false,
                'kelas'          => 'XII PPLG 2',
                'instagram'      => null,
                'foto'           => '19.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 20,
                'nama'           => 'Harif Setyo Pratama',
                'jabatan'        => 'Anggota PDD',
                'divisi'         => 'PDD',
                'is_koordinator' => false,
                'kelas'          => 'XII PPLG 1',
                'instagram'      => null,
                'foto'           => '20.jpg',
                'periode'        => '2026/2027',
            ],

            // ================================================
            // 7. PERKAP (Peralatan & Perlengkapan)
            // ================================================
            [
                'urutan'         => 21,
                'nama'           => 'Leny Nur Apriliana',
                'jabatan'        => 'Koordinator Perkap',
                'divisi'         => 'Perkap',
                'is_koordinator' => true,
                'kelas'          => 'XII AKL 5',
                'instagram'      => 'lenyy_1404',
                'foto'           => '21.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 22,
                'nama'           => 'Khalisa Naura',
                'jabatan'        => 'Anggota Perkap',
                'divisi'         => 'Perkap',
                'is_koordinator' => false,
                'kelas'          => 'XII TF 1',
                'instagram'      => 'kha_nauu',
                'foto'           => '22.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 23,
                'nama'           => 'Calista Dwi Rahmadani',
                'jabatan'        => 'Anggota Perkap',
                'divisi'         => 'Perkap',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 2',
                'instagram'      => 'calysst___',
                'foto'           => '23.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 24,
                'nama'           => 'Naufal Febby Wicaksono',
                'jabatan'        => 'Anggota Perkap',
                'divisi'         => 'Perkap',
                'is_koordinator' => false,
                'kelas'          => 'XII AKL 1',
                'instagram'      => 'naufebbyw',
                'foto'           => '24.jpg',
                'periode'        => '2026/2027',
            ],
            [
                'urutan'         => 25,
                'nama'           => 'Maharani Putri Ramadhan',
                'jabatan'        => 'Anggota Perkap',
                'divisi'         => 'Perkap',
                'is_koordinator' => false,
                'kelas'          => 'XII MPLB 2',
                'instagram'      => 'hayrabluss',
                'foto'           => '25.jpg',
                'periode'        => '2026/2027',
            ],
        ];

        Pengurus::truncate();
        foreach ($penguruses as $p) {
            Pengurus::create($p);
        }

        $this->command->info('✅ Seluruh 25 personil pengurus berhasil di-seed dengan urutan foto 1.jpg - 25.jpg!');
    }
}
