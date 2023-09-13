<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherPayment extends Model
{
    use softDeletes;

    protected $fillable = [
        'paymentCategories_id',
        'bank',
        'description',
        'cheque_no',
        'banking_date',
        'amount'
    ];

    public function paymentCategory(){
        return $this->belongsTo(PaymentCategory::class, 'paymentCategories_id', 'id');
    }
}
