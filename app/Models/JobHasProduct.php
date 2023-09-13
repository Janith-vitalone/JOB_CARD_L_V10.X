<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class JobHasProduct extends Model
{
    use SoftDeletes;
    use LogsActivity;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'name',
        'product_id',
        'price',
        'qty',
        'description',
        'total',
    ];

    protected static $logAttributes = [
        'job_id',
        'name',
        'product_id',
        'price',
        'qty',
        'description',
        'total',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
