<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceHasProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'qty',
        'unit_price',
        'description',
    ];

    public function products()
    {
        return $this->belongsTo(SupplierProduct::class, 'product_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
