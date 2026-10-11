<?php

namespace Database\Seeders;

use App\Models\KontakLink;
use Illuminate\Database\Seeder;

class KontakLinkSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Pembina Ekskul SEC SMKN 1',
                'kategori' => 'pembina',
                'kontak_url' => 'pembina@ekskul.test',
                'keterangan' => 'Guru Pembina Bahasa Inggris & Students English Club',
            ],
            [
                'nama' => 'Official Instagram SEC SMKN 1 Purwokerto',
                'kategori' => 'sosmed',
                'kontak_url' => 'https://instagram.com/sec_smkn1pwt',
                'keterangan' => 'Akun publikasi & dokumentasi resmi Instagram SEC',
            ],
            [
                'nama' => 'Waka Kesiswaan SMKN 1 Purwokerto',
                'kategori' => 'sekolah',
                'kontak_url' => 'kesiswaan@smkn1purwokerto.sch.id',
                'keterangan' => 'Pihak sekolah untuk koordinasi izin kegiatan & surat resmi',
            ],
            [
                'nama' => 'Website Resmi SMKN 1 Purwokerto',
                'kategori' => 'sekolah',
                'kontak_url' => 'https://smkn1purwokerto.sch.id',
                'keterangan' => 'Portal informasi sekolah SMKN 1 Purwokerto',
            ],
            [
                'nama' => 'Google Drive Utama SEC 2026/2027',
                'kategori' => 'grup_link',
                'kontak_url' => 'https://drive.google.com',
                'keterangan' => 'Cloud drive arsip dokumen, materi speaking, dan proposal',
            ],
        ];

        foreach ($data as $d) {
            KontakLink::firstOrCreate(['nama' => $d['nama']], $d);
        }
    }
}
