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
            [
                'name' => 'Administrator',
                'email' => 'admin@email.com',
                'role' => ['admin', 'ketua'],
                'nis' => null,
                'kelas' => 'Staff Admin',
            ],
            [
                'name' => 'User Anggota',
                'email' => 'user@email.com',
                'role' => ['user', 'anggota'],
                'nis' => '12001',
                'kelas' => 'XI RPL 1',
            ],
            [
                'name' => 'Budi Ketua',
                'email' => 'ketua@ekskul.test',
                'role' => ['ketua', 'admin'],
                'nis' => '11001',
                'kelas' => 'XII RPL 1',
            ],
            [
                'name' => 'Sari Sekretaris',
                'email' => 'sekretaris@ekskul.test',
                'role' => ['sekretaris'],
                'nis' => '11002',
                'kelas' => 'XII AKL 2',
            ],
            [
                'name' => 'Andi Bendahara',
                'email' => 'bendahara@ekskul.test',
                'role' => ['bendahara'],
                'nis' => '11003',
                'kelas' => 'XII BDP 1',
            ],
            [
                'name' => 'Dewi Anggota',
                'email' => 'anggota@ekskul.test',
                'role' => ['anggota', 'user'],
                'nis' => '12002',
                'kelas' => 'XI OTKP 3',
            ],
            [
                'name' => 'Pak Guru Pembina',
                'email' => 'pembina@ekskul.test',
                'role' => ['pembina'],
                'nis' => null,
                'kelas' => 'Guru Pembina',
            ],
        ];

        foreach ($akun as $a) {
            $user = User::firstOrCreate(
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
