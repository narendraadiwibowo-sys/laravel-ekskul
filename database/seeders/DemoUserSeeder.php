<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            // Super Admin
            [
                'name' => 'Administrator Utama',
                'email' => 'admin@email.com',
                'role' => ['admin', 'ketua'],
                'nis' => null,
                'kelas' => 'Staff IT / Pembina',
            ],
            // Ketua Umum & Wakil (Inti)
            [
                'name' => 'Ravanelli Putra Maulana',
                'email' => 'ketua@ekskul.test',
                'role' => ['ketua', 'admin'],
                'nis' => '11001',
                'kelas' => 'XII AKL 1',
            ],
            [
                'name' => 'Shelly Evelyn',
                'email' => 'wakil@ekskul.test',
                'role' => ['ketua', 'admin'],
                'nis' => '11002',
                'kelas' => 'XII AKL 2',
            ],
            // Divisi Sekretaris
            [
                'name' => 'Okta Nanda Ariska',
                'email' => 'sekretaris@ekskul.test',
                'role' => ['sekretaris'],
                'nis' => '11003',
                'kelas' => 'XII AKL 1',
            ],
            // Divisi Bendahara
            [
                'name' => 'Vika Nur Aisyah',
                'email' => 'bendahara@ekskul.test',
                'role' => ['bendahara'],
                'nis' => '11004',
                'kelas' => 'XII MPLB 4',
            ],
            // Divisi Humas
            [
                'name' => 'Rieska Nur Fathonah',
                'email' => 'humas@ekskul.test',
                'role' => ['humas'],
                'nis' => '11005',
                'kelas' => 'XII MPLB 1',
            ],
            // Divisi Acara
            [
                'name' => 'Fellisya Luthfia Milani',
                'email' => 'acara@ekskul.test',
                'role' => ['acara'],
                'nis' => '11006',
                'kelas' => 'XII MPLB 1',
            ],
            // Divisi PDD
            [
                'name' => 'Jireh Sabian Pangestu',
                'email' => 'pdd@ekskul.test',
                'role' => ['pdd'],
                'nis' => '11007',
                'kelas' => 'XII DKV 1',
            ],
            // Divisi Perkap
            [
                'name' => 'Leny Nur Apriliana',
                'email' => 'perkap@ekskul.test',
                'role' => ['perkap'],
                'nis' => '11008',
                'kelas' => 'XII AKL 5',
            ],
            // Anggota Biasa & User
            [
                'name' => 'Narendra User Anggota',
                'email' => 'user@email.com',
                'role' => ['user', 'anggota'],
                'nis' => '12001',
                'kelas' => 'XI PPLG 2',
            ],
            [
                'name' => 'Dewi Anggota Aktif',
                'email' => 'anggota@ekskul.test',
                'role' => ['anggota', 'user'],
                'nis' => '12002',
                'kelas' => 'XI OTKP 3',
            ],
            // Pembina
            [
                'name' => 'Bapak Pembina Ekskul',
                'email' => 'pembina@ekskul.test',
                'role' => ['pembina'],
                'nis' => null,
                'kelas' => 'Guru Pembina',
            ],
        ];

        foreach ($akun as $a) {
            $user = User::updateOrCreate(
                ['email' => $a['email']],
                [
                    'name' => $a['name'],
                    'password' => Hash::make('password'),
                    'nis' => $a['nis'] ?? null,
                    'kelas' => $a['kelas'] ?? null,
                    'email_verified_at' => now(),
                ]
            );
            $user->syncRoles((array) $a['role']);
        }
    }
}
