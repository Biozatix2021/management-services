<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranServices extends Model
{
    protected $table = 'lampiran_services';
    protected $fillable = [
        'service_code',
        'lampiran_name',
        'lampiran_path',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_code', 'service_code');
    }
    public function getLampiranPathAttribute($value)
    {
        return asset('storage/' . $value);
    }
    public function getLampiranNameAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
