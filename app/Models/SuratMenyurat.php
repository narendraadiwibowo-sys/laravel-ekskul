<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMenyurat extends Model
{
    protected $table = 'surat_menyurats';

    protected $fillable = [
        'nomor_surat', 'jenis', 'perihal', 'asal_tujuan',
        'tanggal_surat', 'tanggal_terima_kirim', 'keterangan', 'dicatat_oleh',
    ];
    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_terima_kirim' => 'date',
    ];

    public function pencatat() { return $this->belongsTo(User::class, 'dicatat_oleh'); }
}
