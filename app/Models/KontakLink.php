<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakLink extends Model
{
    protected $table = 'kontak_links';

    protected $fillable = [
        'nama',
        'kategori',
        'kontak_url',
        'keterangan',
        'dibuat_oleh',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
