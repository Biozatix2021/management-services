<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'status',
        'is_delete',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function alat()
    {
        return $this->hasMany(Alat::class);
    }
    public function detailStocks()
    {
        return $this->hasMany(DetailStock::class);
    }
    public function getPhoneAttribute($value)
    {
        return preg_replace('/^0/', '+62', $value);
    }
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/^\+62/', '0', $value);
    }
    public function getStatusAttribute($value)
    {
        return $value ? 'Aktif' : 'Tidak Aktif';
    }
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value == 'Aktif' ? 0 : 1;
    }
}
