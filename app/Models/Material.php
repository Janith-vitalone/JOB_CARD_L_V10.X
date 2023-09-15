<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Material extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'job_type',
        'format_id',
    ];

    protected static $logAttributes = [
        'name',
        'job_type',
        'format_id',
    ];

    public function printers()
    {
        return $this->belongsToMany(Printer::class);
    }

    public function format()
    {
        return $this->belongsTo(Format::class);
    }
}
