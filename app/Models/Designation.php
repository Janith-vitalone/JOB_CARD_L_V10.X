<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Designation extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected static $logAttributes = [
        'name',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function isAssignedToUser()
    {
        return $this->user->count() > 0 ? true:false;
    }
}
