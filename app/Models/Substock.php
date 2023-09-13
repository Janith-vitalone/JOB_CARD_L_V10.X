<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Substock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stock_id',
        'stock_product_category_id',
        'supplier_product_id',
        'unit_id',
        'available_area',
    ];

    public function stock(){
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function stockProductCategory(){
        return $this->belongsTo(StockProductCategory::class, 'stock_product_category_id', 'id');
    }
    public function product(){
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id', 'id');
    }
}
