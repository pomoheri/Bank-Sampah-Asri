<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarik extends Model
{
    protected $fillable = [
        'nasabah_id',
        'tanggal_tarik',
        'jumlah_uang_tarik'
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
        //
    }
}
