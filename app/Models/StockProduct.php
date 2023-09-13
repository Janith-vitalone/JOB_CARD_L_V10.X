<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockProduct extends Model
{
    use softDeletes;

    protected $fillable = [
        'stock_product_category_id',
        'name',
        'note',
        'price',
        'qty',
        'reorder_level'
    ];

    public function stockProductCategory(){
        return $this->belongsTo(StockProductCategory::class, 'stock_product_category_id', 'id');
    }
}
