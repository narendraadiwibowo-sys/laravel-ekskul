<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipDrive extends Model
{
    protected $table = 'arsip_drives';

    protected $fillable = [
        'judul',
        'deskripsi',
        'link_drive',
        'tanggal_event',
        'thumbnail',
        'tipe',
        'status_tayang',
        'tanggal_tayang',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_event' => 'date',
        'tanggal_tayang' => 'date',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function thumbnailUrl(): ?string
    {
        if (!$this->thumbnail) {
            return null;
        }
        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }
        return asset('images/thumbnails/' . $this->thumbnail);
    }
}
