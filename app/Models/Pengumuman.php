<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';
    protected $fillable = ['judul', 'isi', 'penting', 'berlaku_sampai', 'dibuat_oleh'];
    protected $casts = ['penting' => 'boolean', 'berlaku_sampai' => 'date'];

    public function pembuat() { return $this->belongsTo(User::class, 'dibuat_oleh'); }

    public function masihBerlaku(): bool
    {
        return !$this->berlaku_sampai || $this->berlaku_sampai->isFuture() || $this->berlaku_sampai->isToday();
    }
}
