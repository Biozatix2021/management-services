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
        'service_start_date',
        'service_end_date',
        'service_status',
        'teknisi_id',
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

    public function sparepart()
    {
        return $this->hasMany(ServicesSparepart::class, 'service_id');
    }

    public function foto_services()
    {
        return $this->hasMany(FotoServices::class, 'service_code', 'service_code');
    }
    public function lampiran_services()
    {
        return $this->hasMany(LampiranServices::class, 'service_code', 'service_code');
    }
}
