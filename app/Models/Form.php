<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Form extends Model
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
        'controller',
    ];

    protected static $logAttributes = [
        'name',
        'controller',
    ];

    public function permission()
    {
        return $this->hasOne(Permission::class);
    }
}
