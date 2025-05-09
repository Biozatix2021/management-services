<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesSparepart extends Model
{
    protected $table = 'services_spareparts';
    protected $fillable = [
        'service_id',
        'nama_sparepart',
        'qty',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
