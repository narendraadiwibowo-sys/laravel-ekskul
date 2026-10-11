<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kegiatans';

    protected $fillable = [
        'judul', 'deskripsi', 'tanggal', 'waktu_mulai', 'waktu_selesai',
        'lokasi', 'status', 'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function notulensis()
    {
        return $this->hasMany(Notulensi::class);
    }

    // Cek apakah jadwal ini H-1 dari hari ini (buat banner pengumuman otomatis)
    public function isBesok(): bool
    {
        return $this->tanggal->isTomorrow();
    }

    public function persenKehadiran(): float
    {
        $total = $this->presensis()->count();
        if ($total === 0) return 0;
        $hadir = $this->presensis()->where('status', 'hadir')->count();
        return round(($hadir / $total) * 100, 1);
    }
}
