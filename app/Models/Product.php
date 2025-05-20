<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'catalog_number',
        'name',
        'price',
        'supplier_id',
        'category_id',
    ];

    public function detailQuotations()
    {
        return $this->hasMany(DetailQuotation::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Perusahaan::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
