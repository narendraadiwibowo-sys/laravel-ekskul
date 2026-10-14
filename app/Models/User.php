<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nis', // nomor induk siswa, opsional
        'kelas',
        'foto',
        'is_active',
    ];

    public function fotoUrl(): string
    {
        if ($this->foto && file_exists(public_path('images/users/' . $this->foto))) {
            return asset('images/users/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=1d4ed8&color=fff&size=150';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jadwalDibuat()
    {
        return $this->hasMany(JadwalKegiatan::class, 'dibuat_oleh');
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function tagihanKas()
    {
        return $this->hasMany(TagihanKas::class);
    }

    // Helper untuk cek status kas bulan berjalan (dipakai di dashboard anggota)
    public function tagihanBulanIni()
    {
        return $this->tagihanKas()
            ->where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->first();
    }

    // Persentase kehadiran anggota ini sepanjang semester/periode
    public function persenKehadiran(): float
    {
        $total = $this->presensis()->count();
        if ($total === 0) return 0;
        $hadir = $this->presensis()->where('status', 'hadir')->count();
        return round(($hadir / $total) * 100, 1);
    }
}
