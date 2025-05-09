<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instalasi_Alat extends Model
{
    protected $table = 'instalasi_alats';
    protected $fillable = [
        'kode_instalasi',
        'no_seri',
        'status_instalasi',
        'teknisi',
        'keterangan',
        'foto',
        'tanggal_instalasi',
        'tipe_garansi',
        'aktif_garansi',
        'habis_garansi',
        'qrcode_path',
        'alat_id',
        'perusahaan_id',
        'rumah_sakit_id',
        'user_id',
        'is_deleted'
    ];

    public function foto_instalasi()
    {
        return $this->hasMany(FotoInstalasi::class, 'kode_instalasi', 'kode_instalasi');
    }
    public function lampiran_instalasi()
    {
        return $this->hasMany(LampiranInstalasi::class, 'kode_instalasi', 'kode_instalasi');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id', 'id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id', 'id');
    }

    public function rumah_sakit()
    {
        return $this->belongsTo(Rumah_Sakit::class, 'rumah_sakit_id', 'id');
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, 'teknisi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
