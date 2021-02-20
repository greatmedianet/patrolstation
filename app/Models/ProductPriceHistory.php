<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductPriceHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_price_histories';

    protected $fillable = [
    	'name', 'shop_id', 'user_id', 'price',
    ];
    
    public function shop()
    {
    	return $this->belongsTo('App\Models\Shop', 'shop_id', 'id'); 
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id'); 
    }
}
