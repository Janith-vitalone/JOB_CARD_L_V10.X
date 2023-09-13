<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
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
