<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanInventaris extends Model
{
    protected $table = 'peminjaman_inventaris';
    protected $fillable = [
        'inventaris_id', 'user_id', 'jumlah_pinjam', 'keperluan',
        'tanggal_pinjam', 'tanggal_kembali_rencana', 'tanggal_kembali_aktual',
        'status', 'dicatat_oleh',
    ];
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    public function inventaris() { return $this->belongsTo(Inventaris::class); }
    public function peminjam() { return $this->belongsTo(User::class, 'user_id'); }
    public function pencatat() { return $this->belongsTo(User::class, 'dicatat_oleh'); }

    public function terlambat(): bool
    {
        return $this->status === 'dipinjam'
            && $this->tanggal_kembali_rencana
            && $this->tanggal_kembali_rencana->isPast();
    }
}
