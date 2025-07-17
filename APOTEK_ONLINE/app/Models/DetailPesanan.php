<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = [
        'pesanan_id',
        'obat_id',
        'jumlah',
        'harga',
        'catatan'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
