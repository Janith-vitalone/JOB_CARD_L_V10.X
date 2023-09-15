<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class QuotationHasItem extends Model
{
    use SoftDeletes;


    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
       'description',
       'sub_description',
       'unit_price',
       'qty',
       'total',
       'quotation_id',
    ];

    protected static $logAttributes = [
        'description',
        'sub_description',
        'unit_price',
        'qty',
        'total',
        'quotation_id',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
