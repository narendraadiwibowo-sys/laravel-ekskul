<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulensi extends Model
{
    use HasFactory;

    protected $table = 'notulensis';

    protected $fillable = ['jadwal_kegiatan_id', 'judul', 'isi', 'dibuat_oleh'];

    public function jadwal()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
