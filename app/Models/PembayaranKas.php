<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranKas extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_kas';

    protected $fillable = [
        'tagihan_kas_id', 'user_id', 'nominal', 'tanggal_bayar', 'bukti', 'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function tagihan()
    {
        return $this->belongsTo(TagihanKas::class, 'tagihan_kas_id');
    }

    public function anggota()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
