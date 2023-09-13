<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'dob',
        'designation_id',
        'gender',
        'contact_no',
        'avatar',
        'email',
        'password',
    ];

    protected static $logAttributes = [
        'name',
        'last_name',
        'dob',
        'designation_id',
        'gender',
        'contact_no',
        'avatar',
        'email',
        'password',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userRoles()
    {
        return $this->belongsToMany(UserRole::class,'user_has_roles','user_id','user_role_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);

    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
