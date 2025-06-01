<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailStock extends Model
{
    protected $table = 'detail_stocks';
    protected $fillable = [
        'stock_id',
        'alat_id',
        'warehouse_id',
        'no_seri',
        'date_in',
        'date_out',
        'status',
        'condition',
        'perusahaan_id',
        'instalation_code',
        'description',
        'is_out',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
    public function getDateInAttribute($value)
    {
        return $value ? date('d-m-Y', strtotime($value)) : null;
    }
    public function getDateOutAttribute($value)
    {
        return $value ? date('d-m-Y', strtotime($value)) : null;
    }
}
