<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_no',
        'job_id',
        'sub_total',
        'discount',
        'grand_total',
        'payment_status',
        'paid_date',
        'due_date',
        'note',
        'product_id',
        'qty',
        'unit_price',
        'client_id'
    ];

    protected static $logAttributes = [
        'invoice_no',
        'job_id',
        'sub_total',
        'discount',
        'grand_total',
        'payment_status',
        'paid_date',
        'due_date',
        'note',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoiceproducts()
    {
        return $this->hasMany(InvoiceHasProduct::class);
    }
}
