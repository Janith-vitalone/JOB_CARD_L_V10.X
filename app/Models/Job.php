<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Job extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected $table = 'injobs';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_no',
        'job_note',
        'client_id',
        'client_note',
        'user_id',
        'screenshot',
        'finishing_date',
        'finishing_time',
        'created_by',
        'job_status',
        'po_no',
        'quote_no',
    ];

    protected static $logAttributes = [
        'job_no',
        'job_note',
        'client_id',
        'client_note',
        'user_id',
        'screenshot',
        'finishing_date',
        'finishing_time',
        'created_by',
        'job_status',
        'po_no',
        'quote_no',
    ];

    // Designer
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function jobHasTasks()
    {
        return $this->hasMany(JobHasTask::class);
    }

    public function jobHasProducts()
    {
        return $this->hasMany(JobHasProduct::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function isInvoiced()
    {
        return $this->invoice != null ? true:false;
    }

    public function isFullyPaid()
    {
        return $this->invoice->payment_status == 'paid' ? true:false;
    }
}
