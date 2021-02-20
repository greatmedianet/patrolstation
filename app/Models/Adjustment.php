<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Adjustment extends Model
{
    use HasFactory, SoftDeletes;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'adjustments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Date',
        'Adjustment_No',
        'Adjustment_Type',
        'Product',
        'Qty',
        'Price',
        'Tank_id',
        'Shop_id',
    ];

    public function AdjustmentType()
    {
        return $this->belongsTo('App\Models\AdjustmentType','Adjustment_Type', 'id'); 
    }

    public function Product()
    {
        return $this->belongsTo('App\Models\Product', 'Product', 'id'); 
    }

    public function Tank()
    {
        return $this->belongsTo('App\Models\Tank', 'Tank_id', 'id'); 
    }

    public function Shop()
    {
        return $this->belongsTo('App\Models\Shop', 'Shop_id', 'id'); 
    }

}
