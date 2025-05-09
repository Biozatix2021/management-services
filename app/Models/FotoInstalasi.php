<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoInstalasi extends Model
{
    protected $table = 'foto_instalasis';

    protected $fillable = [
        'kode_instalasi',
        'path',
    ];

    public function instalasi()
    {
        return $this->belongsTo(Instalasi_Alat::class, 'kode_instalasi', 'kode_instalasi');
    }
}
