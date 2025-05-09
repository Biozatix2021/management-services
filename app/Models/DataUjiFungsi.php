<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataUjiFungsi extends Model
{
    protected $table = 'data_uji_fungsis';
    protected $fillable = [
        'alat_id',
        'no_seri',
        'no_order',
        'no_faktur',
        'tgl_faktur',
        'tgl_terima',
        'tgl_selesai',
        'keterangan',
        'id_teknisi',
        'status',
        'is_deleted',
        'created_by_user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function detail_uji_fungsi()
    {
        return $this->hasMany(DetailUjiFungsi::class, 'data_uji_fungsi_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, 'id_teknisi');
    }
}
