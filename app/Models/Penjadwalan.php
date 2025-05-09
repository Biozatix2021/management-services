<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    protected $table = 'penjadwalans';
    protected $fillable = [
        'teknisi_id',
        'groupId',
        'title',
        'start',
        'end',
        'fullday',
        'keterangan',
        'status'
    ];

    public function teknisi()
    {
        return $this->belongsTo(teknisi::class, 'teknisi_id');
    }
}
