<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Komplain;

class BalasanKomplain extends Model
{
    use HasFactory;

    protected $table = 'balasan_komplains';

    protected $fillable = ['komplain_id', 'isi'];

    public $timestamps = true;

    /**
     * Relasi: Balasan milik 1 komplain.
     */
    public function komplain()
    {
        return $this->belongsTo(Komplain::class, 'komplain_id');
    }
}
