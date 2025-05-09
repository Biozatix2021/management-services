<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garansi extends Model
{
    protected $table = 'garansis';
    protected $fillable = [
        'ID_garansi',
        'nama_garansi',
        'durasi',
        'penyedia',
        'catatan_tambahan',
    ];
}
