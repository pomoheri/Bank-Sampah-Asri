<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nasabah extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function setoran()
    {
        return $this->hasMany(Setoran::class);
    }
    public function tarik()
    {
        return $this->hasMany(Tarik::class);
    }

    use HasFactory;

    protected $fillable = [
        'nama_nasabah',
        'no_hp',
        'user_id'
    ];
}
