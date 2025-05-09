<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranInstalasi extends Model
{
    protected $table = 'lampiran_instalasis';

    protected $fillable = [
        'kode_instalasi',
        'nama_dokumen',
        'path',
    ];
}
