<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
    	'name','shop_id','price'
    ];

    public function shop()
    {
    	return $this->belongsTo('App\Models\Shop', 'shop_id', 'id'); 
    }

    public function sale()
    {
    	return $this->belongsTo('App\Models\Sale', 'sale_id', 'id'); 
    }
}
