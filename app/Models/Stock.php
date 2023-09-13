<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stock_product_category_id',
        'supplier_product_id',
        'qty',
        'reorder_level',
    ];

    public function stockProductCategory(){
        return $this->belongsTo(StockProductCategory::class, 'stock_product_category_id', 'id');
    }
    public function product(){
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id', 'id');
    }
}
