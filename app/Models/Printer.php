<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Printer extends Model
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
        'job_type',
    ];

    protected static $logAttributes = [
        'name',
        'job_type',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }
}
