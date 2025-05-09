<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';
    protected $fillable = [
        'nama_perusahaan',
        'logo_perusahaan',
        'prefix_url',

    ];
}
