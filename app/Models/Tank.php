<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tank extends Model
{
    use HasFactory , SoftDeletes; 

     protected $fillable = [
    	'name',
        'shop_id',
        'product_id',
        'max_quantities',
        'current_quantities',
    ];

      public function Shop()
    {
    	return $this->belongsTo('App\Models\Shop');
    }

    public function product()
    {
    	return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function pump()
    {
        return $this->hasMany('App\Models\Pump');
    }
}
