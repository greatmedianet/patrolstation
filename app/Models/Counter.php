<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counter extends Model
{
    use HasFactory, SoftDeletes; 

     protected $fillable = [
    	'name','shop_id'
    ];

    public function Shop()
    {
    	return $this->belongsTo('App\Models\Shop');
    }
}
