<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rumah_sakit extends Model
{
    protected $table = 'rumah_sakits';
    protected $fillable = [
        'nama',
        'latitude',
        'longitude'
    ];
}
