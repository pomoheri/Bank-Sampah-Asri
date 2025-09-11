<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public function setoran()
    {
        return $this->belongsTo(Setoran::class);
    }
    public function tarik()
    {
        return $this->belongsTo(Tarik::class);
    }
    //
}
