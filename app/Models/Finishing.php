<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Finishing extends Model
{
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'rate',
        'job_type',
        'format_id',
    ];

    protected static $logAttributes = [
        'name',
        'rate',
        'job_type',
        'format_id',
    ];

    public function format()
    {
        return $this->belongsTo(Format::class);
    }
}
