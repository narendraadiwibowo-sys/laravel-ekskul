<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKegiatan extends Model
{
    protected $table = 'program_kegiatans';

    protected $fillable = [
        'judul', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai',
        'status', 'prioritas', 'pic', 'catatan', 'dibuat_oleh',
    ];
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pembuat() { return $this->belongsTo(User::class, 'dibuat_oleh'); }

    public function statusLabel(): string
    {
        return match($this->status) {
            'perencanaan' => 'Perencanaan',
            'pembuatan_proposal' => 'Pembuatan Proposal',
            'persiapan' => 'Persiapan',
            'sedang_berjalan' => 'Sedang Berjalan',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'perencanaan' => '#94a3b8',
            'pembuatan_proposal' => '#60a5fa',
            'persiapan' => '#fbbf24',
            'sedang_berjalan' => '#34d399',
            'selesai' => '#a78bfa',
            'dibatalkan' => '#f87171',
            default => '#94a3b8',
        };
    }

    public function statusProgress(): int
    {
        return match($this->status) {
            'perencanaan' => 10,
            'pembuatan_proposal' => 30,
            'persiapan' => 60,
            'sedang_berjalan' => 80,
            'selesai' => 100,
            'dibatalkan' => 0,
            default => 0,
        };
    }
}
