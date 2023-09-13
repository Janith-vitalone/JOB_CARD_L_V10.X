<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockIn extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'invoice_no',
        'total',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function stockHasProduct(){
        return $this->hasMany(StockInProduct::class);
    }
}
