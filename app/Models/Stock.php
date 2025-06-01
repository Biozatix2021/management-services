<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'id',
        'alat_id',
        'warehouse_id',
        'stock',
        'unit',
        'low_stock_alert',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function detailStocks()
    {
        return $this->hasMany(DetailStock::class);
    }
    public function getStockAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }
    public function setStockAttribute($value)
    {
        $this->attributes['stock'] = str_replace('.', '', $value);
    }
}
