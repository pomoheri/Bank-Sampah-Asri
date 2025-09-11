<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'sampahs'; // jika nama tabel memang "sampah"

    // Kolom yang boleh diisi secara mass-assignment (via create/update)
    protected $fillable = [
        'nama_sampah',
        'jenis_sampah',
        'harga_per_kg',
    ];
}
