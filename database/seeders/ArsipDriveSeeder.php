<?php

namespace Database\Seeders;

use App\Models\ArsipDrive;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArsipDriveSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        $items = [
            [
                'judul' => 'Dokumentasi Rapat Perdana & Pelantikan SEC 2026',
                'deskripsi' => 'Foto dan video dokumentasi pelantikan anggota baru SEC di Aula SMKN 1 Purwokerto',
                'link_drive' => 'https://drive.google.com/drive/folders/example1',
                'tanggal_event' => now()->subDays(5)->toDateString(),
                'tipe' => 'drive',
                'status_tayang' => 'sudah_tayang',
                'dibuat_oleh' => $admin->id,
            ],
            [
                'judul' => 'Pamflet Workshop Speaking & English Fest 2026',
                'deskripsi' => 'Desain poster promosi event workshop English Club. Wajib diposting di IG Story & Grup kelas H-1 pelaksanaan.',
                'link_drive' => '#',
                'tanggal_event' => now()->addDays(2)->toDateString(),
                'tanggal_tayang' => now()->addDay()->toDateString(),
                'tipe' => 'pamflet',
                'status_tayang' => 'siap_tayang',
                'dibuat_oleh' => $admin->id,
            ],
            [
                'judul' => 'Pamflet Latihan Rutin Debate & Story Telling',
                'deskripsi' => 'Poster jadwal mingguan kumpul ekskul hari Jumat siang di lab bahasa.',
                'link_drive' => '#',
                'tanggal_event' => now()->addDays(5)->toDateString(),
                'tanggal_tayang' => now()->addDays(4)->toDateString(),
                'tipe' => 'pamflet',
                'status_tayang' => 'sudah_tayang',
                'dibuat_oleh' => $admin->id,
            ],
        ];

        foreach ($items as $item) {
            ArsipDrive::firstOrCreate(['judul' => $item['judul']], $item);
        }
    }
}
