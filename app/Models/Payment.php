<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Payment extends Model
{
    use SoftDeletes;
    use LogsActivity;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'paid_amount',
        'payment_type',
        'cheque_no',
        'bank',
        'branch',
        'cheque_date',
    ];

    protected static $logAttributes = [
        'invoice_id',
        'paid_amount',
        'payment_type',
        'cheque_no',
        'bank',
        'branch',
        'cheque_date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
