<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInProduct extends Model
{

    protected $fillable = [
        'stock_in_id',
        'stock_product_category_id',
        'supplier_product_id',
        'qty',
        'unit_price',
    ];

    public function stockIn(){
        return $this->belongsTo(StockIn::class, 'stock_in_id', 'id');
    }

    public function stockProductCategory(){
        return $this->belongsTo(StockProductCategory::class, 'stock_product_category_id', 'id');
    }

    public function supplierProduct(){
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id', 'id');
    }
}
