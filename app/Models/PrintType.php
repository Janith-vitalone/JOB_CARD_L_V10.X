<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PrintType extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'job_type',
        'rate',
    ];

    protected static $logAttributes = [
        'name',
        'slug',
        'job_type',
        'rate',
    ];
}
