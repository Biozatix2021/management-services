<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'service_code',
        'alat_id',
        'no_seri',
        'service_name',
        'service_type',
        'service_date',
        'keluhan',
        'service_description',
        'service_price',
        'service_duration',
        'teknisi_id',
        'rumah_sakit_id',
        'perusahaan_id',
        'created_by'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, 'teknisi_id');
    }

    public function rumahSakit()
    {
        return $this->belongsTo(rumah_sakit::class, 'rumah_sakit_id');
    }
}
