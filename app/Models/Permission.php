<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Permission extends Model
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
        'form_id',
    ];

    protected static $logAttributes = [
        'name',
        'slug',
        'form_id',
    ];

    public function userRoles()
    {
        return $this->belongsToMany(UserRole::class);
    }

    public function isAssignedToRole()
    {
        return $this->userRoles->count() > 0 ? true:false;
    }
}
