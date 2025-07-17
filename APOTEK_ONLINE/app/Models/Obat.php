<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = ['nama', 'kategori_obat_id', 'deskripsi', 'stok', 'harga'];

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_obat_id', 'id');
    }
    
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
