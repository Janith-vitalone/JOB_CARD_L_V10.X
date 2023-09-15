<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Lamination extends Model
{
    use SoftDeletes;


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
