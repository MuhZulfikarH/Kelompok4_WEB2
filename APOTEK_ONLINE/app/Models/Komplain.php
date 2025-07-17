<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BalasanKomplain;

class Komplain extends Model
{
    use HasFactory;

    protected $table = 'komplains';

    protected $fillable = ['user_id', 'isi'];

    public $timestamps = true;

    /**
     * Relasi: Komplain milik 1 user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Komplain punya 1 balasan.
     */
    public function balasan()
    {
        return $this->hasOne(BalasanKomplain::class, 'komplain_id');
    }
}
