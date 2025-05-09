<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Uji_Fungsi extends Model
{
    protected $table = 'm_uji_fungsis';
    protected $fillable = ['alat_id', 'item', 'qty', 'satuan',];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}
