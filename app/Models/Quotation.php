<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Quotation extends Model
{
    use SoftDeletes;
    use LogsActivity;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'quote_no',
        'quote_date',
        'total',
        'user_id',
        'status',
        'heading',
        'description',
    ];

    protected static $logAttributes = [
        'client_id',
        'quote_no',
        'quote_date',
        'total',
        'user_id',
        'status',
    ];

    public function quotationHasItems()
    {
        return $this->hasMany(QuotationHasItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
