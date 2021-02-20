<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'purchases';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Date',
        'Invoice_No',
        'Supplier',
        'Supplier_Type',
        'Product',
        'Qty',
        'Price',
        'Tank_Id',
        'Shop_Id',
    ];

    public function supplierType()
    {
        return $this->belongsTo('App\Models\SupplierType', 'Supplier_Type', 'id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'Shop_Id', 'id');
    }

    public function tank()
    {
        return $this->belongsTo('App\Models\Tank', 'Tank_Id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'Product', 'id');
    }
}
