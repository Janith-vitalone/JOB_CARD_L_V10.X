<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockProductCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_roles','user_role_id','user_id');
    }

    public function isAssignedToUser()
    {
        return $this->users->count() > 0 ? true:false;
    }

    public function products()
    {
        return $this->hasMany(SupplierProduct::class);
    }
}
