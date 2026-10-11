<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'penguruses';

    protected $fillable = [
        'nama', 'jabatan', 'divisi', 'is_koordinator',
        'kelas', 'instagram', 'foto', 'urutan', 'periode',
    ];

    protected $casts = ['is_koordinator' => 'boolean'];

    public function fotoUrl(): string
    {
        if ($this->foto && file_exists(public_path('images/pengurus/' . $this->foto))) {
            return asset('images/pengurus/' . $this->foto);
        }
        if ($this->foto && file_exists(public_path('images/' . $this->foto))) {
            return asset('images/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=1e3a8a&color=fff&size=300';
    }

    public function scopePeriode($query, $periode = '2026/2027')
    {
        return $query->where('periode', $periode)->orderBy('urutan');
    }

    public static function byDivisi(string $periode = '2026/2027'): array
    {
        return static::where('periode', $periode)
            ->orderBy('urutan')
            ->get()
            ->groupBy('divisi')
            ->toArray();
    }
}
