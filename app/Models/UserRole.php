<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class UserRole extends Model
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
        'slug',
    ];

    protected static $logAttributes = [
        'name',
        'slug',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_roles','user_role_id','user_id');
    }

    public function isAssignedToUser()
    {
        return $this->users->count() > 0 ? true:false;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
