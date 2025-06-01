<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    protected $table = 'stock_transfers';
    protected $fillable = [
        'from_warehouse_id',
        'to_warehouse_id',
        'alat_id',
        'no_seri_transfer',
        'transfer_date',
        'qty_transfer',
        'description',
    ];
    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }
    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
    public function getTransferDateAttribute($value)
    {
        return $value ? date('d-M-Y', strtotime($value)) : null;
    }
}
