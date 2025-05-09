<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sop_alat extends Model
{
    protected $table = 'sop_alats';
    protected $fillable = ['alat_id', 'item'];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}
