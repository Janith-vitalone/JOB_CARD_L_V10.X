<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'fax',
        'address',
    ];

    protected static $logAttributes = [
        'name',
        'contact_person',
        'phone',
        'email',
        'fax',
        'address',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
