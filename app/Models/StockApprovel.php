<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockApprovel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stock_id',
        'user_id',
        'qty',
        'status',
    ];

    public function stock(){
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
