<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailUjiFungsi extends Model
{
    protected $table = 'detail_uji_fungsis';
    protected $fillable = [
        'data_uji_fungsi_id',
        'item',
        'qty',
        'satuan',
        'status',
        'foto',
    ];
}
