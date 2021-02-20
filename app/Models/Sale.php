<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'date',
        'invoice_no',
        'customer_name',
        'business_type',
        'product',
        'pump_id',
        'nozzle_id',
        'counter_id',
        'qty',
        'discount',
        'price',
        'shop_id',
    ];

    public function businessType()
    {
    	return $this->belongsTo('App\Models\BusinessType', 'business_type', 'id');
    }

    public function counter()
    {
        return $this->belongsTo('App\Models\Counter', 'counter_id', 'id');
    }

    public function pump()
    {
        return $this->belongsTo('App\Models\Pump', 'pump_id', 'id');
    }

    public function nozzle()
    {
        return $this->belongsTo('App\Models\Nozzle', 'nozzle_id', 'id');
    }

    public function Product()
    {
        return $this->belongsTo('App\Models\Product', 'product', 'id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id', 'id');
    }
}
