<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanKas extends Model
{
    use HasFactory;

    protected $table = 'tagihan_kas';

    protected $fillable = ['user_id', 'bulan', 'tahun', 'nominal', 'status'];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranKas::class);
    }

    public function namaBulan(): string
    {
        $nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        return $nama[$this->bulan] ?? '-';
    }
}
