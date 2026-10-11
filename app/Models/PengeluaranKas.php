<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranKas extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_kas';

    protected $fillable = ['judul', 'nominal', 'tanggal', 'kategori', 'keterangan', 'dicatat_oleh'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
