<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alats';
    protected $fillable = [
        'catalog_number',
        'nama',
        'brand',
        'tipe',
        'gambar',
        'is_deleted'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
