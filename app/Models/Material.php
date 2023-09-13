<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Material extends Model
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
