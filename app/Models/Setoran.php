<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
    public function sampah()
    {
        return $this->belongsTo(Sampah::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
    //protected $table = 'setorans';
    protected $fillable = [
        'nasabah_id',
        'sampah_id',
        'berat_setor',
        'tanggal_setoran',
        'jumlah_uang',
    ];
}
