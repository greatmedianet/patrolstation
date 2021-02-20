<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pump extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name','pump_type','tank_id','shop_id',
    ];

    public function pumpType()
    {
        return $this->belongsTo('App\Models\PumpType', 'pump_type', 'id');
    }

    public function tank()
    {
        return $this->belongsTo('App\Models\Tank', 'tank_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id', 'id');
    }

    public function sale()
    {
    	return $this->hasMany('App\Models\Sale'); 
    }
}
