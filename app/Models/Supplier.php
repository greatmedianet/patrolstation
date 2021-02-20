<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'suppliers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'supplier_type',
        'paid_date',
        'address',
        'quantities',
        'price_per_liter',
        'total_amount',
        'tank_id',
        'shop_id',
    ];

    public function supplierType()
    {
        return $this->belongsTo('App\Models\SupplierType', 'supplier_type', 'id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id', 'id');
    }

    public function tank()
    {
        return $this->belongsTo('App\Models\Tank', 'tank_id', 'id');
    }
}
