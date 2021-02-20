<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nozzle extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'name',
        'pump_id',
        'tank_id',
        'default_pump_meter',
        'current_pump_meter',
        'pipe_length',
    ];

    public function Sale()
    {
    	return $this->belongsTo('App\Models\Sale'); 
    }

    public function tank()
    {
        return $this->belongsTo('App\Models\Tank', 'tank_id', 'id'); 
    }

    public function pump()
    {
        return $this->belongsTo('App\Models\Pump', 'pump_id', 'id'); 
    }

}
