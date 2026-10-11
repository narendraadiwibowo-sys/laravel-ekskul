<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';
    protected $fillable = ['nama_barang', 'kode', 'kategori', 'jumlah', 'kondisi', 'keterangan', 'dicatat_oleh'];

    public function pencatat() { return $this->belongsTo(User::class, 'dicatat_oleh'); }
    public function peminjamans() { return $this->hasMany(PeminjamanInventaris::class); }

    public function sedangDipinjam(): int
    {
        return $this->peminjamans()->where('status', 'dipinjam')->sum('jumlah_pinjam');
    }

    public function jumlahTersedia(): int
    {
        return max(0, $this->jumlah - $this->sedangDipinjam());
    }

    public function kondisiLabel(): string
    {
        return match($this->kondisi) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'hilang' => 'Hilang',
            default => ucfirst($this->kondisi),
        };
    }
}
