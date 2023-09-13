<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'stock_product_category_id',
        'name',
        'unit_id',
        'height',
        'width',
    ];

    public function stockProductCategory(){
        return $this->belongsTo(StockProductCategory::class, 'stock_product_category_id', 'id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function invoiceHasProducts()
    {
        return $this->hasMany(InvoiceHasProduct::class);
    }
}
