<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Format extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'job_type'
    ];

    protected static $logAttributes = [
        'name',
        'job_type'
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function laminations()
    {
        return $this->hasMany(Lamination::class);
    }

    public function finishings()
    {
        return $this->hasMany(Finishing::class);
    }
}
