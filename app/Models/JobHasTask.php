<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class JobHasTask extends Model
{
    use SoftDeletes;
    use LogsActivity;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'description',
        'width',
        'height',
        'unit_id',
        'unit',
        'copies',
        'printer_id',
        'printer',
        'print_type',
        'print_type_id',
        'sqft_rate',
        'material_id',
        'materials',
        'lamination_id',
        'lamination',
        'lamination_rate',
        'unit_price',
        'total',
        'finishing_id',
        'finishing_rate',
        'finishing',
        'job_type',
        'job_ss',
        'format',
        'format_id',
        'product_id',
        'product_category_id',
        'stock_qty',
    ];

    protected static $logAttributes = [
        'job_id',
        'description',
        'width',
        'height',
        'unit_id',
        'unit',
        'copies',
        'printer_id',
        'printer',
        'print_type',
        'print_type_id',
        'sqft_rate',
        'material_id',
        'materials',
        'lamination_id',
        'lamination',
        'lamination_rate',
        'unit_price',
        'total',
        'finishing_id',
        'finishing_rate',
        'finishing',
        'job_type',
        'job_ss',
        'format',
        'format_id',
        'product_id',
        'product_category_id',
        'stock_qty',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
