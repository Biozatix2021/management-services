<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoServices extends Model
{
    protected $table = 'foto_services';
    protected $fillable = [
        'service_code',
        'path',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_code', 'service_code');
    }

    public function getPathAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
