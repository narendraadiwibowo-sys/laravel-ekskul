<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Jadwal
            "jadwal.view", "jadwal.create", "jadwal.update", "jadwal.delete",
            // Presensi
            "presensi.view", "presensi.catat",
            // Notulensi
            "notulensi.view", "notulensi.create", "notulensi.update", "notulensi.delete",
            // Kas anggota (tagihan & pembayaran)
            "kas.view", "kas.catat", "kas.generate_tagihan",
            // Pengeluaran kas
            "pengeluaran.view", "pengeluaran.create", "pengeluaran.update", "pengeluaran.delete",
            // Laporan
            "laporan.view", "laporan.download",
            // Pengumuman (Humas & All view)
            "pengumuman.view", "pengumuman.create", "pengumuman.delete",
            // Surat Menyurat (Sekretaris)
            "surat.view", "surat.create", "surat.update", "surat.delete",
            // Program Kerja / Timeline Event (Acara)
            "proker.view", "proker.create", "proker.update", "proker.delete",
            // Arsip Drive (PDD)
            "drive.view", "drive.create", "drive.update", "drive.delete",
            // Inventaris & Peminjaman (Perkap)
            "inventaris.view", "inventaris.create", "inventaris.update", "inventaris.delete",
            "peminjaman.view", "peminjaman.catat",
            // Struktur Organisasi Management
            "pengurus.manage",
            // User & Anggota Management
            "user.manage",
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(["name" => $permission]);
        }

        // 1. ROLE: Admin & Ketua (Superadmin - full access to everything)
        $admin = Role::firstOrCreate(["name" => "admin"]);
        $admin->syncPermissions(Permission::all());

        $ketua = Role::firstOrCreate(["name" => "ketua"]);
        $ketua->syncPermissions(Permission::all());

        // 2. ROLE: Sekretaris
        $sekretaris = Role::firstOrCreate(["name" => "sekretaris"]);
        $sekretaris->syncPermissions([
            "jadwal.view", "jadwal.create", "jadwal.update",
            "presensi.view", "presensi.catat",
            "notulensi.view", "notulensi.create", "notulensi.update", "notulensi.delete",
            "surat.view", "surat.create", "surat.update", "surat.delete",
            "pengumuman.view",
            "laporan.view",
            "user.manage",
        ]);

        // 3. ROLE: Bendahara
        $bendahara = Role::firstOrCreate(["name" => "bendahara"]);
        $bendahara->syncPermissions([
            "jadwal.view",
            "notulensi.view",
            "pengumuman.view",
            "kas.view", "kas.catat", "kas.generate_tagihan",
            "pengeluaran.view", "pengeluaran.create", "pengeluaran.update", "pengeluaran.delete",
            "laporan.view", "laporan.download",
        ]);

        // 4. ROLE: Humas
        $humas = Role::firstOrCreate(["name" => "humas"]);
        $humas->syncPermissions([
            "jadwal.view",
            "notulensi.view",
            "pengumuman.view", "pengumuman.create", "pengumuman.delete",
            "kas.view",
        ]);

        // 5. ROLE: Acara
        $acara = Role::firstOrCreate(["name" => "acara"]);
        $acara->syncPermissions([
            "jadwal.view", "jadwal.create", "jadwal.update", "jadwal.delete",
            "proker.view", "proker.create", "proker.update", "proker.delete",
            "notulensi.view",
            "pengumuman.view",
            "kas.view",
        ]);

        // 6. ROLE: PDD
        $pdd = Role::firstOrCreate(["name" => "pdd"]);
        $pdd->syncPermissions([
            "drive.view", "drive.create", "drive.update", "drive.delete",
            "jadwal.view",
            "notulensi.view",
            "pengumuman.view",
            "kas.view",
        ]);

        // 7. ROLE: Perkap
        $perkap = Role::firstOrCreate(["name" => "perkap"]);
        $perkap->syncPermissions([
            "inventaris.view", "inventaris.create", "inventaris.update", "inventaris.delete",
            "peminjaman.view", "peminjaman.catat",
            "jadwal.view",
            "notulensi.view",
            "pengumuman.view",
            "kas.view",
        ]);

        // 8. ROLE: Anggota & User
        $anggota = Role::firstOrCreate(["name" => "anggota"]);
        $anggota->syncPermissions([
            "jadwal.view",
            "notulensi.view",
            "pengumuman.view",
            "kas.view",
            "proker.view",
            "drive.view",
            "inventaris.view",
        ]);

        $userRole = Role::firstOrCreate(["name" => "user"]);
        $userRole->syncPermissions([
            "jadwal.view",
            "notulensi.view",
            "pengumuman.view",
            "kas.view",
            "proker.view",
            "drive.view",
            "inventaris.view",
        ]);

        // 9. ROLE: Pembina
        $pembina = Role::firstOrCreate(["name" => "pembina"]);
        $pembina->syncPermissions([
            "jadwal.view",
            "notulensi.view",
            "presensi.view",
            "pengumuman.view",
            "proker.view",
            "drive.view",
            "inventaris.view",
            "laporan.view", "laporan.download",
        ]);
    }
}
